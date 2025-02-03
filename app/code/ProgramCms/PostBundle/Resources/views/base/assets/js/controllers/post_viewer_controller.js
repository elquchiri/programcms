/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import {basicSetup, EditorView} from 'codemirror';
import {EditorState} from '@codemirror/state';
import {javascript} from '@codemirror/lang-javascript';
import { python } from "@codemirror/lang-python";
import { html } from "@codemirror/lang-html";
import { php } from "@codemirror/lang-php";
import { css } from "@codemirror/lang-css";
import Plyr from 'plyr';

application.register('post-viewer', class extends Controller {

    connect() {
        const self = this;
        $(this.element).find('pre code').each(function() {
            const codeBlock = $(this)[0];
            const language = $(this).parent().data('language');
            const codeContent = codeBlock.textContent.trim(); // Get the code content
            const wrapper = document.createElement("code");
            codeBlock.replaceWith(wrapper);

            new EditorView({
                state: EditorState.create({
                    doc: codeContent,
                    extensions: [
                        basicSetup,
                        self.getLanguageExtension(language),
                        EditorView.editable.of(false)
                    ],
                }),
                parent: wrapper, // Attach CodeMirror to the wrapper
            });
        });

        // Video process
        $(this.element).find('video').each(function() {
            const videoId = $(this).attr('id');
            const player = new Plyr('#' + videoId);
        });

        // Sticky
        $('html, body').on("scroll", function () {
            if($('.first-sticky').length > 0) {
                const firstSticky = document.querySelector(".first-sticky"); // The main sticky element
                const firstStickyBottom = firstSticky.getBoundingClientRect().bottom;

                const secondStickies = document.querySelectorAll(".second-sticky");
                secondStickies.forEach((sticky) => {
                    const stickyTop = sticky.getBoundingClientRect().top;
                    if (stickyTop <= firstStickyBottom) {
                        sticky.classList.add("sticky-active");
                    } else {
                        sticky.classList.remove("sticky-active");
                    }
                });
            }
        });
    }

    getLanguageExtension(language) {
        switch (language) {
            case 'javascript':
                return javascript();
            case 'htmlmixed':
                return html();  // Assuming HTML is handled
            case 'php':
                return php();
            case 'python':
                return python();
            case 'css':
                return css();   // Assuming CSS is handled
            default:
                return javascript();  // Default to JavaScript
        }
    }
})