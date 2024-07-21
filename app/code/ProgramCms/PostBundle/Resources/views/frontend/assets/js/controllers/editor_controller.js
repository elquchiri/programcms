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
import Loader from "@programcms/loader";

application.register('editor', class extends Controller {
    editor;

    connect() {
        let self = this;
        const postId = $('#post_id').val();
        self.editor = grapesjs.init({
            container: '#editor-wrapper',
            fromElement: true,
            height: '100%',
            width: 'auto',
            canvasCss: '#gjs { background-color: #dedede; !important } p { outline: none !important; } .gjs-hovered {outline: none !important; box-shadow: none !important; } .gjs-selected {outline: none !important; box-shadow: none !important;}',
            i18n: {
                detectLocale: false,
                locale: 'ar',
                messages: {ar},
            },
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

        self.editor.on('load', () => {
            const wrapper = self.editor.getWrapper();

            wrapper.addStyle({direction: 'rtl'});
            $('.pcms-editor').show();
            self.editor.select(wrapper.getChildAt(0));
            wrapper.set({
                attributes: {id: 'my-wrapper'}
            });

            self.updateEditorStyle(self.editor);

            if (postId != null || postId !== '') {
                self.loadProjectData(self.editor, postId);
            }
        });

        self.editor.on('rte:enable', function () {
            self.editor.RichTextEditor.getToolbarEl().style.display = 'none';
        });

        self.editor.on('canvas:frame:load', ({window}) => {
            function isSelectionInTag(tag) {
                const currentNode = window.getSelection().anchorNode;
                if (currentNode) {
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
        });

        let rteAction = $('.editor-rte-action');

        rteAction.on('mousedown', function (e) {
            //e.stopImmediatePropagation();
            e.stopPropagation();
        });

        rteAction.on('mouseup', function (e) {
            let actionId = $(this).attr('id');
            switch (actionId) {
                case 'bold':
                    self.editor.RichTextEditor.run('bold');
                    //editor.RichTextEditor.globalRte.exec('fontWeight', 'bold');
                    break;
                case 'italic':
                    self.editor.RichTextEditor.run('italic');
                    break;
                case 'underline':
                    self.editor.RichTextEditor.run('underline');
                    break;
                case 'textColor':
                    $('#text-color-choose').trigger('click');
                    break;
            }
            e.preventDefault();
            e.stopPropagation();
        });

        // Init Coloris
        Coloris.init();
        Coloris({
            el: '#text-color-choose',
            theme: 'default',
            themeMode: 'light',
            rtl: true,
            margin: 30,
            onChange: function (color, input) {
                let rte = self.editor.RichTextEditor.globalRte;
                rte.exec('foreColor', color);
                //rte.insertHTML(`<span style="color: ${color}">${rte.selection()}</span>`);
                $('#choosen-color').css({backgroundColor: color});
            }
        });
    }

    onSubmit(event) {
        event.preventDefault();
        let form = $(this.element);
        let self = this;
        let postTitleElement = $('input[name=post_title]');
        let categoryId = $('input[name=category_id]');
        const postId = $('#post_id').val();
        $.ajax({
            url: form.attr('action'),
            method: 'post',
            data: {
                'post_id': postId,
                'post_title': postTitleElement.val(),
                'post_data': JSON.stringify(self.editor.getProjectData()),
                'post_html': self.editor.getHtml(),
                'post_css': self.editor.getCss(),
                'category_id': categoryId.val()
            },
            beforeSend: function () {
                Loader.startLoader();
            },
            success: function (response) {
                console.log(response);
            },
            complete: function () {
                Loader.stopLoader();
            }
        });
    }

    loadProjectData(editor, postId) {
        // Load Project Data
        const base_url = window.location.origin;
        let self = this;
        $.ajax({
            url: base_url + '/post/ajax/loadpost/post_id/' + postId,
            method: 'post',
            data: {
                'post_id': postId
            },
            beforeSend: function () {
                Loader.startLoader();
            },
            success: function (result) {
                if(result.edit) {
                    let data = JSON.parse(result.data);
                    editor.loadProjectData(data);
                    self.updateEditorStyle(editor);
                }
            },
            complete: function () {
                Loader.stopLoader();
            }
        });
    }

    updateEditorStyle(editor) {
        const styleEl = window.document.createElement('style');
        const iframe = editor.Canvas.getFrameEl();
        const iframeBody = iframe.contentDocument.body;
        iframeBody.style.backgroundColor = '#eee';
        iframeBody.style.borderTop = 'thick solid red !important;';

        styleEl.innerHTML = `
                        *::-webkit-scrollbar-thumb {background: #888 !important;}
                        *::-webkit-scrollbar-track {background: inherit !important;}
                    `;
        // Append the style element to the iframe document head
        iframe.contentDocument.head.appendChild(styleEl);
    }
});