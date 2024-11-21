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
import Drive from "@programcms/drive";
import hljs from 'highlight.js';

application.register('editor', class extends Controller {
    editor;
    selectedAsset = false;

    connect() {
        let self = this;
        const postId = $('#post_id').val();
        const commentId = $('#comment_id').val();
        let lang = $('html').attr('lang');
        let langCode = lang.split('_')[0];
        const baseUrl = window.location.origin;

        self.editor = grapesjs.init({
            container: '#editor-wrapper',
            fromElement: true,
            height: '100%',
            width: 'auto',
            // canvasCss: '#gjs { background-color: #dedede; !important } p { outline: none !important; } .gjs-hovered {outline: none !important; box-shadow: none !important; } .gjs-selected {outline: none !important; box-shadow: none !important;}',
            canvasCss: '.gjs-selected {outline: 1px dashed #0d6efd !important; box-shadow: none !important;}',
            i18n: {
                detectLocale: false,
                locale: langCode,
                messages: {ar},
            },
            panels: {
                defaults: [
                    {
                        id: 'layers',
                        el: '#layers-container',
                        // Make the panel resizable
                        resizable: {
                            maxDim: 350,
                            minDim: 200,
                            tc: false, // Top handler
                            cl: true, // Left handler
                            cr: false, // Right handler
                            bc: false, // Bottom handler
                            // Being a flex child we need to change `flex-basis` property
                            // instead of the `width` (default)
                            keyWidth: 'flex-basis',
                        },
                    },
                ],
            },
            storageManager: false,
            showToolbar: false,
            keepEmptyTextNodes: false,
            blockManager: {
                appendTo: '#blocks',
                blocks: [
                    {
                        id: 'section',
                        label: 'section',
                        category: 'Text',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/section.png">`,
                        attributes: {class: 'gjs-block-section'},
                        content: `<section>
                          <h1>This is a simple title</h1>
                          <div>This is just a Lorem text: Lorem ipsum dolor sit amet</div>
                        </section>`
                    }, {
                        id: 'text',
                        label: 'text',
                        category: 'Text',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/text.png">`,
                        content: '<div data-gjs-type="text">Insert your text here</div>',
                    }, {
                        id: 'image',
                        label: 'image',
                        category: 'Media',
                        select: true,
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/image.png">`,
                        content: {type: 'image'},
                        activate: true
                    }, {
                        id: 'video',
                        label: 'Video',
                        category: 'Media',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/video.png">`,
                        select: true,
                        content: {type: 'video'},
                        activate: true
                    }, {
                        id: 'file',
                        label: 'File',
                        category: 'Media',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/file.png">`,
                        select: true,
                        content: {type: 'file'},
                        activate: true
                    },
                    {
                        id: 'divider',
                        'label': 'Divider',
                        media: `<svg viewBox="0 0 24 24">
        <path fill="currentColor" d="M21 18H2V20H21V18M19 10V14H4V10H19M20 8H3C2.45 8 2 8.45 2 9V15C2 15.55 2.45 16 3 16H20C20.55 16 21 15.55 21 15V9C21 8.45 20.55 8 20 8M21 4H2V6H21V4Z"></path>
    </svg>`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'quote',
                        label: 'Quote',
                        category: 'Text',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/quote.png">`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'one-column',
                        label: 'column',
                        category: 'Columns',
                        media: `<svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M2 20h20V4H2v16Zm-1 0V4a1 1 0 0 1 1-1h20a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1Z"></path>
                        </svg>`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'two-columns',
                        label: '2columns',
                        category: 'Columns',
                        media: `<svg viewBox="0 0 23 24">
        <path fill="currentColor" d="M2 20h8V4H2v16Zm-1 0V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1ZM13 20h8V4h-8v16Zm-1 0V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1Z"></path>
      </svg>`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: { type: 'two-columns' },
                    },
                    {
                        id: 'three-columns',
                        label: '3columns',
                        category: 'Columns',
                        media: `<svg viewBox="0 0 23 24">
      <path fill="currentColor" d="M2 20h4V4H2v16Zm-1 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1ZM17 20h4V4h-4v16Zm-1 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1ZM9.5 20h4V4h-4v16Zm-1 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z"></path>
    </svg>`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'unordered-list',
                        label: 'U-List',
                        category: 'Lists',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/unordered_list.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `<ul style="list-style-type: disc; padding-left: 20px;">
            <li>List Item 1</li>
            <li>List Item 2</li>
            <li>List Item 3</li>
        </ul>`
                    },
                    {
                        id: 'ordered-list',
                        label: 'O-List',
                        category: 'Lists',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/ordered_list.png">`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'check-list',
                        label: 'C-List',
                        category: 'Lists',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/check_list.png">`,
                        select: true,
                        hover: true,
                        activate: true
                    },
                    {
                        id: 'table',
                        label: 'Table',
                        category: 'Table',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/table.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `
    <table style="width:100%; border: 1px solid #ddd; padding: 7px">
      <thead>
        <tr>
          <th style="border: 1px solid #ddd; padding: 8px;">Header 1</th>
          <th style="border: 1px solid #ddd; padding: 8px;">Header 2</th>
          <th style="border: 1px solid #ddd; padding: 8px;">Header 3</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="border: 1px solid #ddd; padding: 8px;">Row 1 Col 1</td>
          <td style="border: 1px solid #ddd; padding: 8px;">Row 1 Col 2</td>
          <td style="border: 1px solid #ddd; padding: 8px;">Row 1 Col 3</td>
        </tr>
        <tr>
          <td style="border: 1px solid #ddd; padding: 8px;">Row 2 Col 1</td>
          <td style="border: 1px solid #ddd; padding: 8px;">Row 2 Col 2</td>
          <td style="border: 1px solid #ddd; padding: 8px;">Row 2 Col 3</td>
        </tr>
      </tbody>
    </table>
  `,
                    },
                    {
                        id: 'code',
                        label: 'Code',
                        category: 'Coding',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/code.png">`,
                        select: true,
                        // content: '<div class="code"><pre><code>Hello world !</code></pre></div>',
                        content: '<pre><code>Hello World!</code></pre>',
                        activate: true
                    },
                    {
                        id: 'button',
                        label: 'Button',
                        category: 'Forms',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/button.png">`,
                        content: '<button class="btn btn-primary" data-gjs-type="button">Insert your text here</button>',
                    },
                ]
            },
            style: `
                #my-wrapper {
                  margin: 0 auto;
                  padding-left: 29px !important;
                  padding-right: 29px !important;
                  padding-top: 23px !important;
                  padding-bottom: 23px !important;
                  background-color: #FFFFFF !important;
                  min-height: 1000px;
                }
            `,
            layerManager: {
                appendTo: '#layers-container',
            },
            styleManager: {
                appendTo: '#styles-container',
                sectors: [{
                    name: 'general',
                    open: true,
                    buildProps: ['border'],
                    // properties: [
                    //     {
                    //         // options: integer | radio | select | color | slider | file | composite | stack
                    //         type: 'integer',
                    //         name: 'width',
                    //         property: 'width', // CSS property (if buildProps contains it will be extended)
                    //         units: ['px', '%'], // Units, available only for 'integer' types
                    //         defaults: 'auto', // Default value
                    //         min: 0, // Min value, available only for 'integer' types
                    //     }
                    // ]
                },
                    {
                        name: 'Appearance',
                        open: true,
                        buildProps: ['font-family', 'font-size', 'color', 'border', 'background-color']
                    },
                    {
                        name: 'dimension',
                        open: true,
                        buildProps: ['width', 'height', 'min-width', 'max-width', 'min-height', 'max-height', 'padding', 'margin']
                    }, {
                        name: 'extra',
                        open: true,
                        buildProps: ['background-color', 'box-shadow', 'custom-prop', 'video-url'],
                        properties: [
                            {
                                id: 'custom-prop',
                                name: 'Custom Label',
                                property: 'font-size',
                                type: 'select',
                                defaults: '32px',
                                options: [
                                    {value: '12px', name: 'Tiny'},
                                    {value: '18px', name: 'Medium'},
                                    {value: '32px', name: 'Big'}
                                ]
                            }
                        ]
                    }]
            },
            traitManager: {
                appendTo: '#traits-container',
            },
            assetManager: {
                custom: {
                    open(props) {
                        // Init and open your external Asset Manager
                        props.types = ['image', 'video', 'file'];
                        self.openMediaBrowser(props);
                        props.container = $('.file_manager')[0];
                    },
                    close(props) {

                    },
                },
                assets: [],
                upload: baseUrl + '/drive/ajax/upload',
                uploadName: 'files',
                autoAdd: true
            }
        });

        self.editor.DomComponents.addType('video', {
            model: {
                defaults: {
                    tagName: 'video',
                    style: { width: '100%', height: '100%' },
                    stylable: ['width', 'height'],
                }
            },
            view: {
                events: {
                    'dblclick': 'clickOnElement'
                },
                init() {
                    this.listenTo(this.model, 'change:target', this.updateTarget);
                },
                updateTarget(src) {
                    this.model.set('src', src);
                },
                clickOnElement(ev) {
                    const editor = self.editor;
                    const assetManager = editor.AssetManager;
                    assetManager.open();
                }
            }
        });

        self.editor.DomComponents.addType('file', {
            model: {
                defaults: {
                    tagName: 'div',
                    fileUrl: '',
                    fileName: '',
                    fileSize: '',
                },
                init() {
                    this.listenTo(this, 'change:fileUrl', this.toHTML);
                    this.listenTo(this, 'change:fileName', this.toHTML);
                    this.listenTo(this, 'change:fileSize', this.toHTML);
                },
                toHTML() {
                    let html = `<div style="width: 400px; padding: 17px; background-color: #888;">`;
                    const url = this.get('fileUrl');
                    const name = this.get('fileName');
                    const size = this.get('fileSize') ?? 0;
                    if(url) {
                        html += `<a href="${url}" target="_blank">${name}</a>`;
                        html += `<div>Size: ${size} KB</div>`;
                    }else{
                        html += 'Double Click to add File ...';
                    }
                    html += `</div>`;
                    return html;
                }
            },
            view: {
                events: {
                    'dblclick': 'clickOnElement'
                },
                init({model}) {
                    if (self.editor.BlockManager.getDragBlock() === self.editor.BlockManager.get('file')) {
                        self.editor.AssetManager.open();
                    }
                    this.listenTo(model, 'change:fileUrl', this.onRender);
                    this.listenTo(model, 'change:fileName', this.onRender);
                    this.listenTo(model, 'change:fileSize', this.onRender);
                },
                onRender() {
                    let html = `<div style="width: 400px; padding: 17px; background-color: #888;">`;
                    const url = this.model.get('fileUrl');
                    const name = this.model.get('fileName');
                    const size = this.model.get('fileSize');
                    if(url) {
                        html += `<a href="${url}" target="_blank">${name}</a>`;
                        html += `<p>Size: ${size} Kb</p>`;
                    }else{
                        html += 'Double-cliquez pour ajouter un fichier';
                    }
                    html += `</div>`;
                    this.el.innerHTML = html;
                },
                clickOnElement(ev) {
                    const selfInner = this;
                    const assetManager = self.editor.AssetManager;
                    assetManager.open();
                    $('body').on('pcms:drive:file:selected', '#drive-image', function (e, selectedFile, selectedFileName, selectedFileSize) {
                        if (selectedFile) {
                            selfInner.model.set('fileUrl', selectedFile);
                            selfInner.model.set('fileName', selectedFileName);
                            selfInner.model.set('fileSize', selectedFileSize);
                            selfInner.onRender();
                        }
                    });
                }
            }
        });

        self.editor.DomComponents.addType('table', {
            model: {
                defaults: {
                    tagName: 'table',
                    style: {width: '100%', height: 'auto'},
                    stylable: ['width'],
                    traits: [
                        { type: 'text', name: 'Title' },
                        { type: 'text', name: 'Cols' },
                        { type: 'text', name: 'Rows' },
                    ],
                }
            },
        });

        self.editor.DomComponents.addType('two-columns', {
            model: {
                defaults: {
                    tagName: 'div',
                    classes: ['row'],
                    style: { display: 'flex', width: '100%', height: 'auto' },
                    stylable: ['width', 'height', 'padding'],
                    droppable: false,
                    components: [
                        {
                            tagName: 'div',
                            attributes: { id: 'column-1' }, // Unique ID for column 1
                            style: { flex: 1, padding: '10px' },
                            droppable: true,
                            content: 'Column 1',
                        },
                        {
                            tagName: 'div',
                            attributes: { id: 'column-2' }, // Unique ID for column 2
                            style: { flex: 1, padding: '10px' },
                            droppable: true,
                            content: 'Column 2',
                        },
                    ],
                },
            },
        });

        $('.components_manager div').on('click', function (e) {
            e.preventDefault();
            const selectedManager = $(this).attr('id');
            // Link process
            $('.components_manager div').removeClass('active');
            $('#' + selectedManager).addClass('active');
            // Manager process
            $('.component_container').hide();
            $('#components').find('#' + selectedManager + '-container').show();
        });

        self.editor.on('load', () => {
            const wrapper = self.editor.getWrapper();
            const dir = $('html').attr('dir');
            wrapper.addStyle({direction: dir});
            $('.pcms-editor').show();
            self.editor.select(wrapper.getChildAt(0));
            wrapper.set({
                attributes: {id: 'my-wrapper', 'selectable': false, 'draggable': false}
            });

            self.updateEditorStyle(self.editor);

            if (postId != null && postId !== '') {
                self.loadPostProjectData(self.editor, postId);
            }

            if (commentId != null && commentId !== '') {
                self.loadCommentProjectData(self.editor, commentId);
            }
        });

        let debounceTimer; // Timer for debounce

        self.editor.on('component:update', (component) => {
            const codeElement = component.getEl()?.querySelector('pre code');
            if (codeElement) {
                delete codeElement.dataset.highlighted;
                const rawCode = codeElement.innerHTML; // Get the raw text content

                codeElement.innerHTML = hljs.highlight(rawCode, {language: 'html'}).value; // Set the highlighted HTML
            }
        });

        self.editor.on('component:selected', (component) => {
            const el = component.getEl();

            if (el.tagName === 'CODE') {
                // Listen for input event
                el.addEventListener('input', () => {
                    // Clear the debounce timer
                    clearTimeout(debounceTimer);

                    // Delay the re-highlighting by 500ms to avoid triggering too frequently
                    debounceTimer = setTimeout(() => {
                        const rawCode = el.textContent; // Get the raw text content

                        // Update the content model with the raw code
                        component.set('content', rawCode);

                        // Apply syntax highlighting after the user finishes typing
                        el.innerHTML = hljs.highlight(rawCode, {language: 'html'}).value; // Set the highlighted HTML
                    }, 500); // Adjust the debounce delay as needed (500ms)
                });
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
                        'text-align': 'left'
                    });
                    break;
                case 'rightAlign':
                    self.editor.getSelected().addStyle({
                        'text-align': 'right'
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
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    if (response.message) {
                        $('.editor_message').show();
                        $('.editor_message_container').html(response.message);
                        setTimeout(function () {
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
        styleEl.innerHTML = `
                        *::-webkit-scrollbar-thumb {background: #ccc !important;}
                        *::-webkit-scrollbar-track {background: inherit !important;}
                        *::-webkit-scrollbar {width: 5px;}
                    `;
        // Append the style element to the iframe document head
        iframe.contentDocument.head.appendChild(styleEl);
    }

    openMediaBrowser(props) {
        Drive.init({
            container: "drive-image",
            editor: this.editor
        });

        Drive.openDialog();

        const self = this;
        $('body').on('pcms:drive:file:selected', '#drive-image', function (e, selectedFile, selectedFileName, selectedFileSize) {
            e.preventDefault();

            self.selectedAsset = self.editor.AssetManager.get(selectedFile);

            props.select(self.selectedAsset);

            const selected = self.editor.getSelected();
            if (selected && selected.is('video')) {
                selected.getView().updateTarget(self.selectedAsset.getSrc());
            }

            if (selected && selected.is('file')) {
                selected.set('fileUrl', selectedFile);
                selected.set('fileName', selectedFileName);
                selected.set('fileSize', selectedFileSize);
            }

            props.close();
        }).on('pcms:drive:closed', '#drive-image', function (e) {
            e.preventDefault();
            props.close();
        });
    }
});