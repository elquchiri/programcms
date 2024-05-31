/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import grapesjs from 'grapesjs';
import ar from '../locale/ar';
import Coloris from "@melloware/coloris";

application.register('editor', class extends Controller {

    connect() {
        const editorId = $(this.element).attr('id');

        const editor = grapesjs.init({
            container: '#' + editorId,
            fromElement: true,
            height: '100%',
            width: 'auto',
            canvasCss: '#gjs { background-color: #dedede; !important } p { outline: none !important; } .gjs-hovered {outline: none !important; box-shadow: none !important; } .gjs-selected {outline: none !important; box-shadow: none !important;}',
            i18n: {
                detectLocale: false,
                locale: 'ar',
                messages: {ar},
            },
            // layerManager: {
            //     appendTo: '.layers-container'
            // },
            // Avoid any default panel
            panels: {defaults: []},
            storageManager: false,
            showToolbar: false,
            keepEmptyTextNodes: true,
            style: `
                #my-wrapper {
                  width: 900px;
                  margin: 0 auto;
                  padding: 25px 35px 25px 35px;
                  margin-top: 15px;
                  margin-bottom: 15px;
                  border: 1px solid #CCC;
                  background-color: #FFFFFF;
                  min-height: 1000px;
                }
            `,
        });

        editor.on('load', () => {
            const wrapper = editor.getWrapper();
            wrapper.addStyle({direction: 'rtl'});
            $('.pcms-editor').show();
            editor.select(wrapper.getChildAt(0));
            wrapper.set({
                attributes: { id: 'my-wrapper' }
            });
            const iframe = editor.Canvas.getFrameEl();
            const iframeBody = iframe.contentDocument.body;
            iframeBody.style.backgroundColor = '#eee';
            iframeBody.style.borderTop = 'thick solid red !important;';
        });

        editor.on('rte:enable', function () {
            editor.RichTextEditor.getToolbarEl().style.display = 'none';
        });

        editor.on('canvas:frame:load', ({window}) => {
            function isSelectionInTag(tag) {
                const currentNode = window.getSelection().anchorNode;
                if(currentNode) {
                    return currentNode.parentElement.tagName === tag;
                }
                return false;
            }

            // window.document.addEventListener('selectionchange', function (e) {
            //     if (isSelectionInTag('FONT')) {
            //         myButton.classList.add('active');
            //     } else {
            //         myButton.classList.remove('active');
            //     }
            // });

            const iframe = editor.Canvas.getFrameEl();
            const styleEl = window.document.createElement('style');
            styleEl.innerHTML = `
                *::-webkit-scrollbar-thumb {background: #888 !important;}
                *::-webkit-scrollbar-track {background: inherit !important;}
            `;
            // Append the style element to the iframe document head
            iframe.contentDocument.head.appendChild(styleEl);
        });

        let rteAction = $('.editor-rte-action');

        rteAction.on('mousedown', function (e) {
            //e.stopImmediatePropagation();
            e.stopPropagation();
        });

        rteAction.on('mouseup', function (e) {
            let actionId = $(this).attr('id');
            switch(actionId) {
                case 'bold':
                    editor.RichTextEditor.run('bold');
                    //editor.RichTextEditor.globalRte.exec('fontWeight', 'bold');
                    break;
                case 'italic':
                    editor.RichTextEditor.run('italic');
                    break;
                case 'underline':
                    editor.RichTextEditor.run('underline');
                    break;
                case 'textColor':
                    $('#text-color-choose').trigger('click');
                    break;
            }
            e.preventDefault();
            e.stopPropagation();
        });

        Coloris.init();
        Coloris({
            el: '#text-color-choose',
            theme: 'default',
            themeMode: 'light',
            rtl: true,
            margin: 30,
            onChange: function(color, input) {
                let rte = editor.RichTextEditor.globalRte;
                rte.exec('foreColor', color);
                //rte.insertHTML(`<span style="color: ${color}">${rte.selection()}</span>`);
                $('#choosen-color').css({backgroundColor: color});
            }
        });
    }
});