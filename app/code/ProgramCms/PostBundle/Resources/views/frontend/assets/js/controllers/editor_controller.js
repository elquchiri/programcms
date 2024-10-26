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
        let lang = $('html').attr('lang');
        let langCode = lang.split('_')[0];

        self.editor = grapesjs.init({
            container: '#editor-wrapper',
            fromElement: true,
            height: '100%',
            width: 'auto',
            // canvasCss: '#gjs { background-color: #dedede; !important } p { outline: none !important; } .gjs-hovered {outline: none !important; box-shadow: none !important; } .gjs-selected {outline: none !important; box-shadow: none !important;}',
            i18n: {
                detectLocale: false,
                locale: langCode,
                messages: {ar},
            },
            // Avoid any default panel
            panels: {defaults: []},
            storageManager: false,
            showToolbar: false,
            keepEmptyTextNodes: false,
            blockManager: {
                appendTo: '#blocks',
                blocks: [
                    {
                        id: 'section', // id is mandatory
                        label: 'section', // You can use HTML/SVG inside labels
                        media: `<svg viewBox="0 0 24 24">
        <path fill="currentColor" d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M4,6V18H20V6H4M6,9H18V11H6V9M6,13H16V15H6V13Z"></path>
    </svg>`,
                        attributes: {class: 'gjs-block-section'},
                        content: `<section>
                          <h1>This is a simple title</h1>
                          <div>This is just a Lorem text: Lorem ipsum dolor sit amet</div>
                        </section>`,
                    }, {
                        id: 'text',
                        label: 'text',
                        media: `<svg style="width:48px;height:48px" viewBox="0 0 24 24">
<path fill="currentColor" d="M18.5,4L19.66,8.35L18.7,8.61C18.25,7.74 17.79,6.87 17.26,6.43C16.73,6 16.11,6 15.5,6H13V16.5C13,17 13,17.5 13.33,17.75C13.67,18 14.33,18 15,18V19H9V18C9.67,18 10.33,18 10.67,17.75C11,17.5 11,17 11,16.5V6H8.5C7.89,6 7.27,6 6.74,6.43C6.21,6.87 5.75,7.74 5.3,8.61L4.34,8.35L5.5,4H18.5Z" />
</svg>`,
                        content: '<div data-gjs-type="text">Insert your text here</div>',
                    }, {
                        id: 'image',
                        label: 'image',
                        media: `<svg style="width:48px;height:48px" viewBox="0 0 24 24">
<path fill="currentColor" d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z" />
</svg>`,
                        select: true,
                        content: {type: 'image'},
                        activate: true,
                    }, {
                        id: 'button',
                        label: 'Button',
                        media: `<svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20 20.5C20 21.3 19.3 22 18.5 22H13C12.6 22 12.3 21.9 12 21.6L8 17.4L8.7 16.6C8.9 16.4 9.2 16.3 9.5 16.3H9.7L12 18V9C12 8.4 12.4 8 13 8S14 8.4 14 9V13.5L15.2 13.6L19.1 15.8C19.6 16 20 16.6 20 17.1V20.5M20 2H4C2.9 2 2 2.9 2 4V12C2 13.1 2.9 14 4 14H8V12H4V4H20V12H18V14H20C21.1 14 22 13.1 22 12V4C22 2.9 21.1 2 20 2Z"></path>
                        </svg>`,
                        content: '<div data-gjs-type="text">Insert your text here</div>',
                    }, {
                        id: 'one-column',
                        'label': 'column',
                        media: `<svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M2 20h20V4H2v16Zm-1 0V4a1 1 0 0 1 1-1h20a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1Z"></path>
                        </svg>`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'two-columns',
                        'label': '2columns',
                        media: `<svg viewBox="0 0 23 24">
        <path fill="currentColor" d="M2 20h8V4H2v16Zm-1 0V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1ZM13 20h8V4h-8v16Zm-1 0V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1Z"></path>
      </svg>`,
                        select: true,
                        hover: true,
                        activate: true
                    }
                ]
            },
            style: `
                #my-wrapper {
                  margin: 0 auto;
                  padding: 15px 35px 25px 35px;
                  background-color: #FFFFFF;
                  min-height: 1000px;
                }
            `,
            styleManager: {
                appendTo: '#components',
                sectors: [{
                    name: 'general',
                    open: true,
                    // Use built-in properties
                    buildProps: ['width', 'height', 'padding', 'margin'],
                    // Use `properties` to define/override single property
                    properties: [
                        {
                            // Type of the input,
                            // options: integer | radio | select | color | slider | file | composite | stack
                            type: 'integer',
                            name: 'width',
                            property: 'width', // CSS property (if buildProps contains it will be extended)
                            units: ['px', '%'], // Units, available only for 'integer' types
                            defaults: 'auto', // Default value
                            min: 0, // Min value, available only for 'integer' types
                        }
                    ]
                },
                    {
                    name: 'dimension',
                    open: false,
                    // Use built-in properties
                    buildProps: ['width', 'min-height', 'padding'],
                    // Use `properties` to define/override single property
                    properties: [
                        {
                            // Type of the input,
                            // options: integer | radio | select | color | slider | file | composite | stack
                            type: 'integer',
                            name: 'The width', // Label for the property
                            property: 'width', // CSS property (if buildProps contains it will be extended)
                            units: ['px', '%'], // Units, available only for 'integer' types
                            defaults: 'auto', // Default value
                            min: 0, // Min value, available only for 'integer' types
                        }
                    ]
                },{
                    name: 'extra',
                    open: false,
                    buildProps: ['background-color', 'box-shadow', 'custom-prop'],
                    properties: [
                        {
                            id: 'custom-prop',
                            name: 'Custom Label',
                            property: 'font-size',
                            type: 'select',
                            defaults: '32px',
                            // List of options, available only for 'select' and 'radio'  types
                            options: [
                                { value: '12px', name: 'Tiny' },
                                { value: '18px', name: 'Medium' },
                                { value: '32px', name: 'Big' },
                            ],
                        }
                    ]
                }]
            },
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

            if (commentId != null && commentId !== '') {
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
                    self.editor.RichTextEditor.globalRte.insertHTML('<ul><li>' + selectedText + '</li></ul>');
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

        // window.addEventListener('keydown', (e) => {
        //     if (e.key === 'Enter') {
        //         const selectedComponent = self.editor.getSelected();
        //         if (selectedComponent.props().tagName === 'p') {
        //             const appendedComponent = self.editor.getWrapper().append('<p><br></p>', {
        //                 at: (selectedComponent.index() + 1)
        //             });
        //             const el = appendedComponent[0].getEl();
        //             self.editor.select(appendedComponent[0]);
        //             el.setAttribute('contenteditable', 'true');
        //             //el.focus();
        //             appendedComponent[0].getView().onActive();
        //
        //             setTimeout(function () {
        //                 appendedComponent[0].getEl().removeChild(appendedComponent[0].getEl().firstChild);
        //             });
        //         }
        //     }
        // });
        // window.addEventListener('keyup', (e) => {
        //     if (e.key === 'Enter') {
        //         const selectedComponent = self.editor.getSelected();
        //         if (selectedComponent.props().tagName === 'ul') {
        //             if (
        //                 selectedComponent.getEl().children.length >= 2 &&
        //                 selectedComponent.getEl().children[selectedComponent.getEl().children.length - 2].firstChild.tagName === 'BR' &&
        //                 selectedComponent.getEl().children[selectedComponent.getEl().children.length - 1].firstChild.tagName === 'BR'
        //             ) {
        //                 if (selectedComponent.getEl().children.length >= 2) {
        //                     let counted = selectedComponent.index() + 1;
        //                     selectedComponent.getEl().removeChild(selectedComponent.getEl().children[selectedComponent.getEl().children.length - 1]);
        //                     selectedComponent.getEl().removeChild(selectedComponent.getEl().children[selectedComponent.getEl().children.length - 1]);
        //                     if (selectedComponent.getEl().children.length === 0) {
        //                         // let newComponent = selectedComponent.replaceWith('<p><br></p>');
        //                         counted = selectedComponent.index();
        //                         selectedComponent.remove();
        //                         // newComp[0].getEl().focus();
        //                     }
        //                     const newComp = self.editor.getWrapper().append('<p><br></p>', {at: counted});
        //                     newComp[0].getEl().setAttribute('contenteditable', 'true');
        //                     self.editor.select(newComp[0]);
        //                     newComp[0].getEl().focus();
        //                 }
        //             }
        //         } else {
        //             self.editor.select(selectedComponent);
        //             // Remove <br>
        //             //selectedComponent.getEl().removeChild(selectedComponent.getEl().firstChild);
        //         }
        //     }
        // });

        self.editor.on('component:selected', (component) => {
            if (self.editor.getSelected().props().tagName === 'li') {
                const selectedParent = self.editor.getSelected().parent();
                self.editor.select(selectedParent);
            }

            // if (self.editor.getSelected().props().tagName === 'p') {
            //     component.getEl().setAttribute('contenteditable', 'true');
            //     component.getEl().focus();
            // }

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

        $('#add_link_button').on('click', function (e) {
            e.preventDefault();
            let linkUrl = $('#link_url').val();
            let linkTitle = $('#link_title').val();

            self.editor.RichTextEditor.globalRte.insertHTML("<a href='" + linkUrl + "'>" + linkTitle + "</a>");
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
        if (editorMode === 'post') {
            data = {
                'post_id': postId,
                'post_title': postTitleElement.val(),
                'post_data': JSON.stringify(self.editor.getProjectData()),
                'post_html': self.editor.getHtml(),
                'post_css': self.editor.getCss(),
                'category_id': categoryId.val()
            };
        } else {
            data = {
                'comment_id': commentId,
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
                if(response.success) {
                    window.location.href = response.redirect_url;
                }else{
                    if(response.message) {
                        $('.editor_message').show();
                        $('.editor_message_container').html(response.message);
                        setTimeout(function() {
                            $('.editor_message').fadeOut();
                        }, 3000);
                    }
                }
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
                if (result.edit) {
                    let data = JSON.parse(result.data);
                    $('.post_title').val(result.title);
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
                if (result.edit) {
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

        styleEl.innerHTML = `
                        *::-webkit-scrollbar-thumb {background: #ccc !important;}
                        *::-webkit-scrollbar-track {background: inherit !important;}
                    `;
        // Append the style element to the iframe document head
        iframe.contentDocument.head.appendChild(styleEl);
    }
});