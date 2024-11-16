/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Controller } from "@hotwired/stimulus";
import io from "socket.io-client";

let peerConnections = {}; // Store peer connections by user ID

application.register("chat-call", class extends Controller {
    connect() {
        this.socket = io('http://localhost:3000', {
            reconnectionDelay: 1000,
            reconnection: true,
            reconnectionAttempts: 10,
            transports: ['websocket'],
            agent: false,
            upgrade: false,
            rejectUnauthorized: false,
            autoConnect: true,
            auth: {
                sessionId: connectedUserObject.sessionId
            }
        });

        const self = this;
        this.roomId = document.getElementById('conversation_id').value;
        this.localVideo = document.getElementById('local-video');
        this.videoContainer = document.getElementById('row-full');
        this.iceCandidateQueue = {}; // Queue for ICE candidates
        this.cameraEnabled = true; // Track Camera status
        this.audioEnabled = true; // Track Audio status

        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then((stream) => {
                this.localStream = stream;
                this.localVideo.srcObject = stream;
                this.socket.emit('join room', this.roomId, connectedUserObject);
            })
            .catch((error) => console.error('Error accessing media devices:', error));

        // Handle socket events
        this.socket.on('users-in-room', (users) => {
            users.forEach(user => this.initiateCall(user));
        });
        this.socket.on('user-joined', (user) => this.initiateCall(user));
        this.socket.on('offer', async (offer, userId) => await this.handleOffer(offer, userId));
        this.socket.on('answer', async (answer, userId) => await this.handleAnswer(answer, userId));
        this.socket.on('ice candidate', (candidate, userId) => this.queueOrAddCandidate(candidate, userId));
        this.socket.on('user-left', (user) => this.removePeer(user));

        // Camera disable events
        this.socket.on('camera-disabled', (data) => this.handleCameraDisabled(data));
        this.socket.on('audio-disabled', (data) => this.handleAudioDisabled(data));

        this.socket.on('cancel-call', (user, roomId) => {
            $('#' + user.id).find('.invite').html('+ Invite');
        });

        // Add camera toggle button event
        document.getElementById('toggle-camera').addEventListener('click', () => this.toggleCamera());
        document.getElementById('disable-audio').addEventListener('click', () => this.toggleAudio());
        document.getElementById('disconnect').addEventListener('click', () => this.closeChatWindow());
        document.getElementById('chat_menu').addEventListener('click', () => this.showUsers());

        $('.invite').on('click', function(e) {
            e.preventDefault();
            const userId = $(this).data('user-id');
            $(this).html('Calling ...');
            self.socket.emit('call-user', userId, self.roomId.replace('-conv', ''));
        });
    }

    toggleCamera() {
        const videoTrack = this.localStream.getVideoTracks()[0];
        videoTrack.enabled = !videoTrack.enabled; // Toggle the video track
        this.cameraEnabled = videoTrack.enabled;

        // Inform other users about the camera status
        this.socket.emit('camera-disabled', { userId: this.socket.id, disabled: !videoTrack.enabled });

        // Update button text
        document.getElementById('toggle-camera').title = videoTrack.enabled ? 'Disable Camera' : 'Enable Camera';
        if(!videoTrack.enabled) {
            document.getElementById('toggle-camera').classList.add('enabled');
        }else{
            document.getElementById('toggle-camera').classList.remove('enabled');
        }
    }

    toggleAudio() {
        const audioTrack = this.localStream.getAudioTracks()[0];
        audioTrack.enabled = !audioTrack.enabled; // Toggle the audio track
        this.audioEnabled = audioTrack.enabled;

        // Inform other users about the camera status
        this.socket.emit('audio-disabled', { userId: this.socket.id, disabled: !audioTrack.enabled });

        // Update button text
        document.getElementById('disable-audio').title = audioTrack.enabled ? 'Disable Audio' : 'Enable Audio';
        if(!audioTrack.enabled) {
            document.getElementById('disable-audio').classList.add('enabled');
        }else{
            document.getElementById('disable-audio').classList.remove('enabled');
        }
    }

    closeChatWindow() {
        window.close();
    }

    showUsers() {
        $('.right').toggle();
    }

    handleCameraDisabled({ userId, disabled }) {
        const userVideo = document.getElementById(`video-${userId}`);
        if (userVideo) {
            userVideo.style.display = disabled ? 'none' : 'block';
        }
    }

    handleAudioDisabled({ userId, disabled }) {
        // Do nothing
    }

    initiateCall(user) {
        const socketId = user.socketId;

        this.notifyStatus(user, 'online');

        const peerConnection = this.createPeerConnection(socketId);
        peerConnections[socketId] = peerConnection;

        this.localStream.getTracks().forEach(track => peerConnection.addTrack(track, this.localStream));
        peerConnection.createOffer()
            .then(offer => peerConnection.setLocalDescription(offer))
            .then(() => this.socket.emit('offer', peerConnection.localDescription, socketId));
    }

    async handleOffer(offer, userId) {
        const peerConnection = this.createPeerConnection(userId);
        await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));

        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        this.socket.emit('answer', peerConnection.localDescription, userId);

        this.processQueuedCandidates(userId);
    }

    async handleAnswer(answer, userId) {
        const peerConnection = peerConnections[userId];
        await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));

        this.processQueuedCandidates(userId);
    }

    queueOrAddCandidate(candidate, userId) {
        if (peerConnections[userId] && peerConnections[userId].remoteDescription) {
            peerConnections[userId].addIceCandidate(new RTCIceCandidate(candidate)).catch(error => {
                console.error('Error adding ICE candidate', error);
            });
        } else {
            if (!this.iceCandidateQueue[userId]) {
                this.iceCandidateQueue[userId] = [];
            }
            this.iceCandidateQueue[userId].push(candidate);
        }
    }

    processQueuedCandidates(userId) {
        const peerConnection = peerConnections[userId];
        if (this.iceCandidateQueue[userId] && peerConnection.remoteDescription) {
            this.iceCandidateQueue[userId].forEach(async (candidate) => {
                try {
                    await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
                } catch (error) {
                    console.error('Error adding queued ICE candidate', error);
                }
            });
            delete this.iceCandidateQueue[userId];
        }
    }

    createPeerConnection(userId) {
        const peerConnection = new RTCPeerConnection({
            iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
        });

        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                this.socket.emit('ice candidate', event.candidate, userId);
            }
        };

        peerConnection.ontrack = (event) => {
            this.addRemoteVideoStream(userId, event.streams[0]);
        };

        return peerConnection;
    }

    addRemoteVideoStream(userId, stream) {
        let chatColumn = document.getElementById('chat_user_' + userId);
        if (!chatColumn) {
            chatColumn = document.createElement('div');
            chatColumn.id = 'chat_user_' + userId;
            chatColumn.className = 'column';

            let videoClass = document.createElement('div');
            videoClass.className = 'video';

            let remoteVideo = document.createElement('video');
            remoteVideo.id = `video-${userId}`;
            remoteVideo.autoplay = true;
            remoteVideo.srcObject = stream;
            remoteVideo.style.width = '100%';
            remoteVideo.style.height = '100%';
            videoClass.appendChild(remoteVideo);

            chatColumn.appendChild(videoClass);
            this.videoContainer.appendChild(chatColumn);
        }
    }

    removePeer(user) {
        if (peerConnections[user.socketId]) {
            peerConnections[user.socketId].close();
            delete peerConnections[user.socketId];
        }
        const remoteVideo = document.getElementById(`chat_user_${user.socketId}`);
        if (remoteVideo) remoteVideo.remove();

        this.notifyStatus(user, 'offline');
    }

    notifyStatus(user, status) {
        const userSelector = $('#' + user.id);
        if(status === 'online') {
            userSelector.find('.conversation_status').removeClass('offline').addClass('online');
            userSelector.find('button.invite').html('+ Invite').hide();

        }else if(status === 'offline') {
            userSelector.find('.conversation_status').removeClass('online').addClass('offline');
            userSelector.find('button.invite').show();
        }
    }
});