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
        const commentId = $('#comment_id').val();

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
            keepEmptyTextNodes: false,
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
                attributes: {id: 'my-wrapper', 'selectable': false, 'draggable': false}
            });

            // Add default text
            const defaultComp = self.editor.getWrapper().append({
                type: 'text',
                tagName: 'p',
                content: 'Hello',
                draggable: false,
                droppable: true,
                //style: {'padding': 0, 'margin': 0},
                editable: true,
                selectable: true
            }, {
                at: 0
            });
            const el = defaultComp[0].getEl();
            self.editor.select(defaultComp[0]);
            el.setAttribute('contenteditable', 'true');
            el.focus();
            defaultComp[0].getView().onActive();

            self.updateEditorStyle(self.editor);

            if (postId != null && postId !== '') {
                self.loadPostProjectData(self.editor, postId);
            }

            if(commentId != null && commentId !== '') {
                self.loadCommentProjectData(self.editor, commentId);
            }
        });

        self.editor.on('rte:enable', function () {
            self.editor.RichTextEditor.getToolbarEl().style.display = 'none';
        });

        self.editor.on('canvas:frame:load', ({window}) => {
            window.document.addEventListener('selectionchange', function (e) {
                if (self.isSelectionInTag(self.editor, 'B')) {
                    $('#bold').addClass('active');
                } else {
                    $('#bold').removeClass('active');
                }

                if (self.isSelectionInTag(self.editor, 'I')) {
                    $('#italic').addClass('active');
                } else {
                    $('#italic').removeClass('active');
                }

                if (self.isSelectionInTag(self.editor, 'A')) {
                    $('#link').addClass('active');
                } else {
                    $('#link').removeClass('active');
                }
            });
        });

        let rteAction = $('.editor-rte-action');
        let panelActions = $('.panel__actions, .modal__actions');

        panelActions.on('mousedown', function (e) {
            e.stopPropagation();
        });

        rteAction.on('mouseup', function (e) {
            let actionId = $(this).attr('id');
            let selectedText = self.editor.RichTextEditor.globalRte.selection().toString();
            switch (actionId) {
                case 'bold':
                    console.log(selectedText);
                    self.editor.RichTextEditor.run('bold');
                    // self.editor.RichTextEditor.globalRte.exec('fontWeight', 'bold');
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
                case 'unorderedList':
                    self.editor.RichTextEditor.globalRte.insertHTML('<ul><li>'+ selectedText + '</li></ul>');
                    break;
                case 'orderedList':
                    const appendedComponent = self.editor.getWrapper().append('<ul><li><br></li></ul>', {
                        at: (self.editor.getSelected().index() + 1)
                    });
                    self.editor.select(appendedComponent[0]);
                    const el = appendedComponent[0].getEl();
                    el.setAttribute('contenteditable', 'true');
                    el.focus();
                    break;
                case 'centerAlign':
                    self.editor.getSelected().addStyle({
                        'text-align': 'center'
                    });
                    break;
                case 'leftAlign':
                    self.editor.getSelected().addStyle({
                        'text-align': 'right'
                    });
                    break;
                case 'rightAlign':
                    self.editor.getSelected().addStyle({
                        'text-align': 'left'
                    });
                    break;
                case 'link':
                    $('#linkModal').modal('show');
                    $('#form_link').trigger('reset');
                    $('#link_title').val(selectedText);
                    break;
            }
            e.preventDefault();
            e.stopPropagation();
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const selectedComponent = self.editor.getSelected();
                if(selectedComponent.props().tagName === 'p') {
                    const appendedComponent = self.editor.getWrapper().append('<p><br></p>', {
                        at: (selectedComponent.index() + 1)
                    });
                    const el = appendedComponent[0].getEl();
                    self.editor.select(appendedComponent[0]);
                    el.setAttribute('contenteditable', 'true');
                    //el.focus();
                    appendedComponent[0].getView().onActive();

                    setTimeout(function() {
                        appendedComponent[0].getEl().removeChild(appendedComponent[0].getEl().firstChild);
                    });
                }
            }
        });
        window.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                const selectedComponent = self.editor.getSelected();
                if(selectedComponent.props().tagName === 'ul') {
                    if (
                        selectedComponent.getEl().children.length >= 2 &&
                        selectedComponent.getEl().children[selectedComponent.getEl().children.length - 2].firstChild.tagName === 'BR' &&
                        selectedComponent.getEl().children[selectedComponent.getEl().children.length - 1].firstChild.tagName === 'BR'
                    ) {
                        if (selectedComponent.getEl().children.length >= 2) {
                            let counted = selectedComponent.index() + 1;
                            selectedComponent.getEl().removeChild(selectedComponent.getEl().children[selectedComponent.getEl().children.length - 1]);
                            selectedComponent.getEl().removeChild(selectedComponent.getEl().children[selectedComponent.getEl().children.length - 1]);
                            if(selectedComponent.getEl().children.length === 0) {
                                // let newComponent = selectedComponent.replaceWith('<p><br></p>');
                                counted = selectedComponent.index();
                                selectedComponent.remove();
                                // newComp[0].getEl().focus();
                            }
                            const newComp = self.editor.getWrapper().append('<p><br></p>', {at: counted});
                            newComp[0].getEl().setAttribute('contenteditable', 'true');
                            self.editor.select(newComp[0]);
                            newComp[0].getEl().focus();
                        }
                    }
                }else {
                    self.editor.select(selectedComponent);
                    // Remove <br>
                    //selectedComponent.getEl().removeChild(selectedComponent.getEl().firstChild);
                }
            }
        });

        self.editor.on('component:selected', (component) => {
            if(self.editor.getSelected().props().tagName === 'li') {
                const selectedParent = self.editor.getSelected().parent();
                self.editor.select(selectedParent);
            }

            if(self.editor.getSelected().props().tagName === 'p') {
                component.getEl().setAttribute('contenteditable', 'true');
                component.getEl().focus();
            }

            if (component.is('wrapper')) {
                // Deselect the wrapper
                self.editor.select(component.getChildAt(0));
                component.getEl().focus();
            }
        });

        // self.editor.on('component:update', (component) => {
        //     component.replaceWith('<p>Hello</p>');
        //     //component.getEl().removeChild(component.getEl().lastChild);
        // });

        // self.editor.DomComponents.addType('text', {
        //     view: {
        //         tagName: 'p',
        //         events: {
        //             click: 'onActive',  // Listen for the click event
        //         },
        //         onActive(e) {
        //             const editable = self.editor.getSelected().getEl();
        //             self.editor.select(this.model); // Select the model in the editor
        //             //self.editor.trigger('component:toggled'); // Trigger the component toggled event
        //             editable.setAttribute('contenteditable', 'true'); // Make the element content editable
        //             editable.focus(); // Focus the element
        //         },
        //     },
        // });

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

        $('#add_link_button').on('click', function(e) {
            e.preventDefault();
            let linkUrl = $('#link_url').val();
            let linkTitle = $('#link_title').val();

            self.editor.RichTextEditor.globalRte.insertHTML("<a href='"+ linkUrl +"'>"+ linkTitle +"</a>");
            $('#linkModal').modal('hide');
        });
    }

    isSelectionInTag(editor, tag) {
        const selection = editor.RichTextEditor.globalRte.selection();
        const currentNode = selection.anchorNode;

        if (currentNode) {
            let node = currentNode;

            // Traverse up the DOM tree to check if any parent element matches the specified tag
            while (node) {
                if (node.nodeType === Node.ELEMENT_NODE && node.tagName === tag) {
                    return true;
                }
                node = node.parentElement;
            }
        }

        return false;
    }

    onSubmit(event) {
        event.preventDefault();
        let form = $(this.element);
        let self = this;
        let postTitleElement = $('input[name=post_title]');
        let categoryId = $('input[name=category_id]');
        const postId = $('#post_id').val();
        const commentId = $('#comment_id').val();
        const editorMode = $('#editor_mode').val();
        let data;
        if(editorMode === 'post') {
            data = {
                'post_id': postId,
                'post_title': postTitleElement.val(),
                'post_data': JSON.stringify(self.editor.getProjectData()),
                'post_html': self.editor.getHtml(),
                'post_css': self.editor.getCss(),
                'category_id': categoryId.val()
            };
        }else{
            data = {
                'comment_id' : commentId,
                'comment_data': JSON.stringify(self.editor.getProjectData()),
                'comment': self.editor.getHtml(),
                'comment_css': self.editor.getCss()
            }
        }

        $.ajax({
            url: form.attr('action'),
            method: 'post',
            data: data,
            beforeSend: function () {
                Loader.startLoader();
            },
            success: function (response) {
                window.location.href = response.redirect_url;
            },
            complete: function () {
                Loader.stopLoader();
            }
        });
    }

    loadPostProjectData(editor, postId) {
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

    loadCommentProjectData(editor, commentId) {
        // Load Project Data
        const base_url = window.location.origin;
        let self = this;
        $.ajax({
            url: base_url + '/post/ajax/loadcomment/comment_id/' + commentId,
            method: 'post',
            data: {
                'comment_id': commentId
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

    isInsideUl(editor, keyMode) {
        // Get the currently selected component
        const selected = editor.getSelected();

        // If there's no selection, return false
        if (!selected) return false;

        if (selected.props().tagName === 'p') {
            return false;
        }

        const selectedElement = selected.getEl();
        const size = selectedElement.children.length;
        // if(selectedElement !== undefined) {
        //     return false;
        // }

        if (selected.props().tagName === 'ul') {
            if (keyMode === 'down') {
                return true;
            } else {
                if (
                    selectedElement.children.length >= 3 &&
                    selectedElement.children[size - 2].innerHTML === '<br>' &&
                    selectedElement.lastChild.innerHTML === '<br>'
                ) {
                    return false;
                }
            }
        }
        // return selected.props().tagName === 'ul';

        // Traverse up the component tree to check for a <ul> element
        let parent = selected;
        while (parent) {
            if (parent.get('tagName') === 'ul') {
                return true; // The cursor is inside a <ul> element
            }
            parent = parent.parent(); // Move to the parent component
        }

        return false; // No <ul> element found
    }
});