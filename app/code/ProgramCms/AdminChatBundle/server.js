/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

const express = require('express');
const {createServer} = require('node:http');
const {Server} = require('socket.io');
const axios = require('axios');

const app = express();
const server = createServer(app);
const io = new Server(server);

let connectedUsers = [];
const rooms = {}; // Track users in each room
const sessions = {};

server.listen(3000, () => {
    console.log('server running at http://localhost:3000');
});

io.on("connection", (socket) => {
    socket.on('userConnected', (user) => {
        addUser(user, socket);
        io.emit('updateUserList', connectedUsers);
        socket.join(user.id + '-user');

        const sessionCookie = user.sessionId;

        axios.post('http://dev-progra.com/admin/admin_chat/api/conversations', {}, {
            headers: {
                Cookie: sessionCookie
            },
            withCredentials: true
        })
            .then(response => {
                if (response.data.success) {
                    const conversations = response.data.conversations;
                    for (let i = 0; i < conversations.length; i++) {
                        socket.join((conversations[i].id) + "-conv");
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error.message);
            });

        socket.on('disconnect', () => {
            removeUserById(user.id);
            // Emit the updated list of users
            io.emit('updateUserList', connectedUsers);
        });
    });

    socket.on('new_message', (message) => {
        let currentUser = findUserBySocketId(message.socketId);

        axios.post('http://dev-progra.com/admin/admin_chat/api/newmessage', {
            conversation_id: message.conversationId,
            message: message.content,
            users: message.users
        }, {
            headers: {
                'Content-Type': 'application/json',
                Cookie: currentUser.sessionId
            },
            withCredentials: true
        })
            .then(response => {
                if (response.data.success) {
                    const data = response.data.data;
                    socket.emit('new_conversation', data.conversationId);

                    if(message.users) {
                        let newUsers = message.users.split(',');
                        newUsers = newUsers.map(str => parseInt(str, 10));
                        // Join current user to newly created conversation
                        socket.join(data.conversationId + "-conv");

                        for(let i=0; i<newUsers.length; i++) {
                            const findedUser = findUserById(newUsers[i]);
                            if(findedUser) {
                                const userSocket = io.sockets.sockets.get(findedUser.socketId);
                                userSocket.join(data.conversationId + "-conv");
                            }
                        }
                    }

                    socket.to((data.conversationId) + "-conv").emit('receive_message', {
                        user: currentUser,
                        conversationId: data.conversationId,
                        conversationTitle: data.conversationTitle,
                        content: data.message,
                        updatedAt: data.updatedAt
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

    });

    socket.on('is_typing', (data) => {
        socket.to((data.conversationId) + "-conv").emit('receive_typing', {
            user: data.user,
            conversationId: data.conversationId,
        });
    });

    socket.on('stop_typing', (data) => {
        socket.to((data.conversationId) + "-conv").emit('receive_stop_typing', {
            user: data.user,
            conversationId: data.conversationId,
        });
    });

    /**
     * Call System
     */
    socket.on('cancel-call', (user, conversationId) => {
        const fUser = findUserBySessionId(socket.handshake.auth.sessionId);
        socket.to(user.id + '-user').emit('cancel-call', fUser, conversationId);
    });

    socket.on('join room', (roomId, connectedUserObject) => {
        const sessionId = socket.handshake.auth.sessionId;

        socket.join(connectedUserObject.id + '-user');

        // Initialize the room if it doesn't exist
        if (!rooms[roomId]) rooms[roomId] = [];
        if (!sessions[roomId]) sessions[roomId] = [];

        if(sessions[roomId] && sessions[roomId].includes(sessionId)) {
            socket.disconnect();
        }

        // Add the new user to the room
        rooms[roomId].push(socket.id);
        sessions[roomId].push(sessionId);
        socket.join(roomId);

        // Send the new user the list of users already in the room
        socket.emit('users-in-room', getUsersOfRoom(roomId, sessionId));

        // Notify existing users about the new user
        const user = findUserBySessionId(sessionId);
        user.socketId = socket.id;
        socket.to(roomId).emit('user-joined', user);

        socket.on('offer', (offer, targetUserId) => {
            socket.to(targetUserId).emit('offer', offer, socket.id);
        });

        socket.on('answer', (answer, targetUserId) => {
            socket.to(targetUserId).emit('answer', answer, socket.id);
        });

        socket.on('ice candidate', (candidate, targetUserId) => {
            socket.to(targetUserId).emit('ice candidate', candidate, socket.id);
        });

        socket.on('camera-disabled', (data) => {
            // Relay the message to the other users in the room
            socket.to(roomId).emit('camera-disabled', data);
        });

        socket.on('audio-disabled', (data) => {
            // Relay the message to the other users in the room
            socket.to(roomId).emit('audio-disabled', data);
        });

        socket.on('disconnect', () => {
            // Remove user from room
            rooms[roomId] = rooms[roomId].filter(id => id !== socket.id);
            sessions[roomId] = sessions[roomId].filter(id => id !== sessionId);

            // Notify remaining users that someone left
            socket.to(roomId).emit('user-left', user);

            // Remove the room if it's empty
            if (rooms[roomId].length === 0) delete rooms[roomId];
            if (sessions[roomId].length === 0) delete sessions[roomId];
        });

        socket.on('call-user', (userId, conversationId) => {
            //const fUser = findUserBySessionId(socket.handshake.auth.sessionId);
            socket.to(userId + '-user').emit('call-user', connectedUserObject, conversationId);
        });

        // if(rooms[roomId].length === 1) {
        //     // Call Other users in conversation
        //     const conversationUsers = connectedUserObject.users;
        //     for(let i=0; i<conversationUsers.length; i++) {
        //         const currentUser = findUserById(conversationUsers[i]);
        //         if(currentUser && !sessions[roomId].includes(currentUser.sessionId)) {
        //             const intRoomId = roomId.replace('-conv', '');
        //             socket.to(currentUser.id + '-user').emit('call-user', connectedUserObject, intRoomId);
        //         }
        //     }
        // }
    });
});

function getUsersOfRoom(roomId, sessionId) {
    let users = [];
    const sessionIds = sessions[roomId].filter(id => id !== sessionId);
    for(let i=0; i<sessionIds.length; i++) {
        const session = sessionIds[i];
        const user = findUserBySessionId(session);
        user.socketId = rooms[roomId][i];
        users.push(user);
    }
    return users;
}

/**
 * Add User
 * @param userObject
 * @param socket
 */
function addUser(userObject, socket) {
    const exists = findUserById(userObject.id);
    if (!exists) {
        userObject.socketId = socket.id;
        connectedUsers.push(userObject);
    }
}

/**
 * Find User
 * @param id
 * @returns {*}
 */
function findUserById(id) {
    return connectedUsers.find(user => user.id === id);
}

/**
 * Find User By Socket Id
 * @param id
 * @returns {*}
 */
function findUserBySocketId(id) {
    return connectedUsers.find(user => user.socketId === id);
}

/**
 * Find User by Session Id
 * @param id
 * @returns {*}
 */
function findUserBySessionId(id) {
    return connectedUsers.find(user => user.sessionId === id);
}

/**
 * Remove User
 * @param id
 */
function removeUserById(id) {
    const index = connectedUsers.findIndex(user => user.id === id);
    if (index !== -1) {
        connectedUsers.splice(index, 1);
    }
}