/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import io from 'socket.io-client'

application.register('chat-client', class extends Controller {

    connect() {
        const socket = io('http://localhost:3000', {
            reconnectionDelay: 1000,
            reconnection: true,
            reconnectionAttemps: 10,
            transports: ['websocket'],
            agent: false,
            upgrade: false,
            rejectUnauthorized: false
        });

        socket.on("connect", () => {

        });

        socket.emit("hello", "world", (response) => {
            console.log(response); // "got it"
        });
    }
});