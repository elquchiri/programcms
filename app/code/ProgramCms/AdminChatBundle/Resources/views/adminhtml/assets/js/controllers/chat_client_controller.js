/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import io from 'socket.io-client'
import Modal from '@programcms/modal';

application.register('chat-client', class extends Controller {

    static connectedUsers;
    userBadges = [];
    userBadgesObjects = [];

    connect() {
        let self = this;
        const notificationSound = document.getElementById('notificationSound');
        const callSound = document.getElementById('callSound');

        this.getConversations();

        const socket = io('http://localhost:3000', {
            reconnectionDelay: 1000,
            reconnection: true,
            reconnectionAttemps: 10,
            transports: ['websocket'],
            agent: false,
            upgrade: false,
            rejectUnauthorized: false,
            autoConnect: true,
            auth: {
                sessionId: connectedUserObject.sessionId
            }
        });

        socket.on("connect", () => {
            // Notify the server of the connected user
            socket.emit('userConnected', connectedUserObject);
        });

        socket.on('updateUserList', (connectedUsers) => {
            $('.online_users_counter').html(connectedUsers.length);
        });

        $('body').on('submit', '.message_input form', function (e) {
            e.preventDefault();
            const messageInput = $(this).find('input[type=text]');
            const message = messageInput.val();
            if (message !== '') {
                const convId = $(this).find('input[name=conversation_id]').val();
                const users = $(this).find('input[name=users]').val();
                const conversationTitle = convId ? $('#' + convId).data('conversation-title') : '';

                self.sendNewMessage(socket, {
                    socketId: socket.id,
                    user: connectedUserObject,
                    conversationId: convId,
                    conversationTitle: conversationTitle,
                    content: message,
                    users: users
                });
            }
            messageInput.val('');
        });

        self.isTyping(socket);

        socket.on('receive_message', (message) => {
            notificationSound.play();
            self.newMessageTemplate(message, message.user);
            self.notifyNewMessage(message);
        });

        socket.on('receive_typing', (data) => {
            $('#chat-box-' + data.conversationId).find('.is_typing').html(data.user.firstname + ' is Typing ...').show();
        });

        socket.on('receive_stop_typing', (data) => {
            $('#chat-box-' + data.conversationId).find('.is_typing').html('').hide();
        });

        socket.on('call-user', (userCalling, roomId) => {
            self.openCallingModal(userCalling, roomId, callSound, socket);
        });

        this.reduceChatBox();

        $('.new_message_button').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            self.appendNewMessageBox();
        });

        $('body').on('click', '.close_conversation_button', function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });

        $('body').on('keyup', '.chat_to input[type=text]', function (e) {
            e.preventDefault();
            const searchUser = $(this).val();
            if (searchUser !== '') {
                self.searchUsers(searchUser, self.userBadges);
            }
        });

        $('body').on('click', '.user_list_link', function (e) {
            e.preventDefault();
            const userId = parseInt($(this).data('user-id'));
            const userName = $(this).data('user-name');
            const users = $('input[name=users]');
            if (!(self.userBadges.includes(userId))) {
                $('.chat_to').prepend(
                    "<span class=\"badge_user badge rounded-pill bg-primary\" data-user-id=\""+ userId +"\">" +
                    userName +
                    " <a class=\"remove_user_badge ms-2\" href=\"#\">×</a>" +
                    "</span>"
                );
                self.userBadges.push(userId);
                self.userBadgesObjects.push({
                    id: userId,
                    name: userName
                });

                users.val(self.userBadges.join());
                $(this).hide();
                $('.chat_to input[type=text]').val("");

                self.getUsersConversation(self.userBadges.join());
            }
        });

        $('body').on('click', '.remove_user_badge', function(e) {
            e.preventDefault();
            const users = $('input[name=users]');
            const selectedUserId = $(this).parent().data('user-id');
            self.userBadges.splice(self.userBadges.indexOf(selectedUserId), 1);
            users.val(self.userBadges.join());
            $(this).parent().remove();
            self.getUsersConversation(self.userBadges.join());
        });

        $('body').on('click', '#online-admins-container a', function (e) {
            e.preventDefault();
            const convId = $(this).attr('id');
            const conversationTitle = $(this).data('conversation-title');
            self.resetMessageCounter(convId);
            self.openNewChat(convId, conversationTitle);
        });

        // Call Conversation
        $('body').on('click', '.call_conversation', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const conversationId = $(this).data('conversation-id');
            window.open("/admin/admin_chat/call/index/id/" + conversationId, "", "width=1100,height=500");
        });
    }

    getConversations() {
        const self = this;
        $.ajax({
            type: 'POST',
            url: '/admin/admin_chat/api/conversations',
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    const convs = data.conversations;
                    for (let i = 0; i < convs.length; i++) {
                        const conv = convs[i];
                        self.newConversationLink(conv);
                    }
                }
            }
        })
    }

    openNewChat(conversationId, conversationTitle) {
        const self = this;
        const chatBoxSelector = $('#chat-box-' + conversationId);
        if (chatBoxSelector.length === 0) {
            if (!this.canAppendChatBox(conversationId)) {
                const chatBoxes = document.querySelectorAll('.chat-box');
                $(chatBoxes[1]).remove();
            }

            $('.chat-container').prepend(
                "<div class=\"chat-box\" id=\"chat-box-" + conversationId + "\">\n" +
                "                <span class=\"chat_title_notification position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary\">0</span>" +
                "                <div class=\"title\">" +
                "                   <div class=\"conversation_status\"></div>" +
                "                   <span class=\"conversation_title\">" + conversationTitle + "</span>" +
                "                   <a href=\"#\" class=\"close_conversation_button float-end\">\n" +
                "                        <img src=\"/bundles/programcmsadminchat/images/close_conversation.png\" alt=\"\" />\n" +
                "                   </a>\n" +
                "                   <a href=\"#\" class=\"me-3 float-end\">\n" +
                "                        <img src=\"/bundles/programcmsadminchat/images/add_user.png\" alt=\"\" />\n" +
                "                   </a>\n" +
                "                   <a href=\"#\" class=\"call_conversation me-3 float-end\" data-conversation-id=\""+ conversationId +"\">\n" +
                "                        <img src=\"/bundles/programcmsadminchat/images/call.png\" alt=\"\" />\n" +
                "                   </a>\n" +
                "                </div>\n" +
                "                <div class=\"full_messages_container\">\n" +
                "                   <div class=\"messages_container\"></div>\n" +
                "                   <div class=\"is_typing position-absolute top-0\"></div>\n" +
                "                </div>\n" +
                "                <div class=\"message_input\">\n" +
                "                    <form action=\"#\" method=\"POST\">\n" +
                "                        <input type=\"text\" placeholder=\"Write your message ...\" />\n" +
                "                        <input type=\"hidden\" name=\"conversation_id\" value=\"" + conversationId + "\" />\n" +
                "                    </form>\n" +
                "                </div>\n" +
                "            </div>"
            );

            $.ajax({
                type: 'POST',
                url: '/admin/admin_chat/api/messages',
                dataType: 'json',
                data: {'conversation_id': conversationId},
                success: function (data) {
                    if (data.success) {
                        const messages = data.messages;
                        self.loadMessagesInChatBox(messages, conversationId)
                    }
                }
            });
        } else {
            chatBoxSelector.removeClass('collapsed').removeClass('blinking');
        }
    }

    /**
     * Send Message in a conversation
     * @param socket
     * @param message
     */
    sendNewMessage(socket, message) {
        if (message.users) {
            message.conversationId = 'new';
            message.conversationTitle = this.formatConversationUsers(message.users);
            this.notifyNewMessage(message);
            $('#chat-box-' + message.conversationId).find('.close_conversation_button').trigger('click');
            socket.on('new_conversation', (conversationId) => {
                $('#' + message.conversationId).attr('id', conversationId);
                $('#' + conversationId).trigger('click');
            });
        } else {
            this.newMessageTemplate(message, connectedUserObject);
            this.notifyNewMessage(message);
        }

        socket.emit('new_message', message);
    }

    /**
     * New Message Template
     * @param message
     * @param user
     */
    newMessageTemplate(message, user) {
        $('#chat-box-' + message.conversationId).find('.messages_container').append(
            "<div class=\"chat-message\">" +
            "<div><a class=\"user_url\" href=\"#\">" + user.firstname + "</a></div>" +
            message.content +
            "</div>"
        );
    }

    /**
     * Check if can append new chat box
     * @param conversationId
     * @returns {boolean}
     */
    canAppendChatBox(conversationId) {
        const screenWidth = window.innerWidth;
        const boxWidth = 365;
        const boxSpacing = 23;
        const maxBoxes = Math.floor(screenWidth / (boxWidth + boxSpacing));
        const chatBoxes = document.querySelectorAll('.chat-box');
        const currentBoxCount = chatBoxes.length;

        return currentBoxCount < maxBoxes;
    }

    reduceChatBox() {
        const self = this;
        $('body').on('click', '.chat-box .title', function (e) {
            e.preventDefault();
            const boxId = $(this).parent().attr('id');
            const boxSelector = $('#' + boxId);
            const convId = boxId.replace("chat-box-", "");
            if (boxSelector.hasClass('collapsed')) {
                boxSelector.removeClass('collapsed').removeClass('blinking');
                self.resetMessageCounter(convId);
            } else {
                boxSelector.addClass('collapsed');
            }

            if ($('.chat-box').length === $('.chat-box.collapsed').length) {
                $('.chat-box.collapsed').addClass('full_collapsed');
            } else {
                $('.chat-box.collapsed').removeClass('full_collapsed');
            }
        });
    }

    notifyNewMessage(message) {
        const chatBoxSelector = $('#chat-box-' + message.conversationId);
        let messageCount = parseInt(chatBoxSelector.find('.chat_title_notification').text());

        if(message.user.id !== connectedUserObject.id) {
            if (chatBoxSelector.hasClass('collapsed')) {
                chatBoxSelector.find('.chat_title_notification').text(messageCount + 1).show();
                chatBoxSelector.addClass('blinking');
            }
        }

        let conversationLink = $('#' + message.conversationId);
        if(conversationLink.length === 0) {
            this.newConversationLink({
                id: message.conversationId,
                title: message.conversationTitle,
                lastMessage: message.content,
                updatedAt: message.updatedAt
            });
            conversationLink = $('#' + message.conversationId);
        }
        // Update Conversation Link UI
        if (conversationLink.length > 0) {
            // Move Conversation Link to top
            conversationLink.parent().prepend(conversationLink);

            if(message.user.id !== connectedUserObject.id) {
                let notifCount = parseInt(conversationLink.find('.chat-notification-count').text());
                conversationLink.find('.chat-notification-count').html(notifCount + 1).show();
            }
            conversationLink.find('.last_message').html(message.content);
            conversationLink.find('.updatedAt').html('Right now');
        }
    }

    /**
     * Reset Message Counter
     * @param conversationId
     */
    resetMessageCounter(conversationId) {
        $('#' + conversationId).find('.chat-notification-count').text('0').hide();
        $('#chat-box-' + conversationId).find('.chat_title_notification').text('0').hide();
    }

    isTyping(socket) {
        let typingTimeout;

        $('body').on('keyup', '.message_input form input[type=text]', function (e) {
            const convId = $(this).parent().find('input[name=conversation_id]').val();

            socket.emit('is_typing', {
                conversationId: convId,
                user: connectedUserObject
            });

            clearTimeout(typingTimeout);

            // Emit "stopTyping" if the user stops typing for 1 second
            typingTimeout = setTimeout(() => {
                socket.emit('stop_typing', {
                    conversationId: convId,
                    user: connectedUserObject
                });
            }, 1000);
        });
    }

    appendNewMessageBox() {
        const self = this;
        if ($('#chat-box-new').length > 0) {
            $('#chat-box-new').removeClass('collapsed');
        } else {
            self.userBadges = [];
            $('.chat-container').prepend(
                "<div class=\"chat-box\" id=\"chat-box-new\">\n" +
                "                <div class=\"title\">" +
                "                   New Message" +
                "                   <a href=\"#\" class=\"close_conversation_button float-end\">\n" +
                "                       <img src=\"/bundles/programcmsadminchat/images/close_conversation.png\" alt=\"\" />\n" +
                "                   </a>" +
                "                </div>" +
                "                <div class=\"chat_to\">" +
                "                    <input type=\"text\" placeholder=\"Choose one or multiple users ...\" />\n" +
                "                </div>" +
                "                <div class=\"full_messages_container\">\n" +
                "                   <ul id=\"new_message_container\" class=\"messages_container list-group list-group-flush\">\n" +
                "                   </ul>" +
                "                </div>" +
                "                <div class=\"message_input\">\n" +
                "                    <form action=\"#\" method=\"POST\">\n" +
                "                        <input type=\"text\" placeholder=\"Write your message ...\" />\n" +
                "                        <input type=\"hidden\" name=\"conversation_id\" value=\"\" />\n" +
                "                        <input type=\"hidden\" name=\"users\" value=\"\" />\n" +
                "                    </form>" +
                "                </div>" +
                "            </div>"
            );
        }
    }

    searchUsers(searchUser, userBadges) {
        const newMessageContainer = $('#new_message_container');
        $.ajax({
            type: 'POST',
            url: '/admin/admin_chat/api/search',
            dataType: 'json',
            data: {qWord: searchUser},
            success: function (response) {
                if (response.success) {
                    newMessageContainer.html("");
                    const users = response.data;
                    for (let i = 0; i < users.length; i++) {
                        let user = users[i];
                        if (!userBadges.includes(user.id)) {
                            newMessageContainer.append(
                                "<a href=\"#\" data-user-id=\"" + user.id + "\" data-user-name=\"" + user.firstname + " " + user.lastname[0] + ".\" class=\"user_list_link list-group-item list-group-item-action\" aria-current=\"true\">" +
                                user.firstname + " " + user.lastname +
                                "</a>"
                            );
                        }
                    }
                }
            }
        });
    }

    getUsersConversation(usersIds) {
        const self = this;
        const messagesContainer = $('#chat-box-new').find('.messages_container');
        messagesContainer.html("");
        $.ajax({
            type: 'POST',
            url: '/admin/admin_chat/api/usersconversation',
            dataType: 'json',
            data: {users: usersIds},
            success: function (response) {
                if (response.success) {
                    const conversationId = response.data.conversationId;
                    const messages = response.data.messages;
                    self.loadMessagesInChatBox(messages, 'new');
                }
            }
        });
    }

    /**
     * Load Messages
     * @param messages
     * @param conversationId
     */
    loadMessagesInChatBox(messages, conversationId) {
        const messagesContainer = $('#chat-box-' + conversationId).find('.messages_container');
        for (let i = 0; i < messages.length; i++) {
            const message = messages[i];
            messagesContainer.append(
                "<div class=\"chat-message\">" +
                "<div><a class=\"user_url\" href=\"#\">" + message.user + "</a></div>" +
                message.content +
                "</div>"
            );
        }
    }

    /**
     * New Conversation
     * @param conv
     */
    newConversationLink(conv) {
        $('#online-admins-container').append(
            "<a href=\"#\" id=\"" + conv.id + "\" data-conversation-title=\"" + conv.title + "\" class=\"list-group-item list-group-item-action\" aria-current=\"true\">" +
                conv.title +
                "<span class=\"badge rounded-pill bg-primary float-end chat-notification-count ms-2\">0</span>" +
                "<span class=\"updatedAt text-muted float-end\" style=\"font-size: 14px;\">"+ conv.updatedAt +"</span>" +
            "<div class=\"last_message text-muted text-truncate\">" + conv.lastMessage + "</div> " +
            "</a>"
        );
    }

    /**
     * Format Conversation Title
     * @param users
     * @returns {string}
     */
    formatConversationUsers(users) {
        users = users.split(',');
        users = users.map(str => parseInt(str, 10));
        let title = "";
        for(let i=0; i<users.length; i++) {
            const user = this.findUserById(users[i]);
            title += user.name;
            if(i < users.length - 1) {
                title += " + ";
            }
        }
        return title;
    }

    findUserById(id) {
        return this.userBadgesObjects.find(user => user.id === id);
    }

    openCallingModal(userCalling, roomId, callSound, socket) {
        const self = this;
        const modalOptions = {
            id: 'user-calling-modal',
            title: userCalling.firstname + ' is calling you ...',
            content: 'Do you accept ?',
            buttons: [
                {
                    text: 'Pick Up',
                    class: 'btn-success',
                    click: function() {
                        window.open("/admin/admin_chat/call/index/id/" + roomId, "", "width=1100,height=500");
                        $('#user-calling-modal').modal('hide').remove();
                        self.stopAudio(callSound);
                    }
                },
                {
                    text: 'Hang',
                    class: 'btn-danger',
                    dismiss: true,
                    click: function() {
                        self.stopAudio(callSound);
                        socket.emit('cancel-call', userCalling, roomId);
                    }
                }
            ]
        }
        Modal.open('confirm', modalOptions);
        callSound.play();
    }

    /**
     * Stop Audio
     * @param audio
     */
    stopAudio(audio) {
        audio.pause();           // Pause the audio
        audio.currentTime = 0;   // Reset the audio to the beginning
    }
});