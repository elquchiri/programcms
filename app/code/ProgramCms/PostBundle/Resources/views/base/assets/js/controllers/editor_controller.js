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

import {basicSetup} from 'codemirror';
import {EditorView, keymap} from "@codemirror/view"
import {EditorState} from '@codemirror/state';
import {indentWithTab} from "@codemirror/commands"
import {javascript} from '@codemirror/lang-javascript';
import {python} from "@codemirror/lang-python";
import {html} from "@codemirror/lang-html";
import {php} from "@codemirror/lang-php";
import {css} from "@codemirror/lang-css";


application.register('editor', class extends Controller {
    editor;
    selectedAsset = false;

    static values = {
        loadEndpoint: {type: String},
        saveEndpoint: {type: String},
        entityId: {type: String},
        json: {type: String},
        icon: {type: String}
    };

    connect() {
        let self = this;
        const commentId = $('#comment_id').val();
        let lang = $('html').attr('lang');
        let langCode = lang.split('_')[0];
        const baseUrl = window.location.origin;

        $('html, body').css({'overflow': 'hidden'});
        $('body').append("<div class=\"editor_message\">\n" +
                "        <div class=\"editor_message_container p-2\" style=\"font-size: 14px; text-align: center\"></div>\n" +
                "    </div>");

        this.prepareEditorHeader();

        this.preparePanelTop();

        self.editor = grapesjs.init({
            container: '#editor-wrapper',
            fromElement: true,
            height: '100%',
            width: 'auto',
            canvasCss: '.gjs-selected {outline: 1px dashed #0d6efd !important; box-shadow: none !important;}',
            i18n: {
                detectLocale: false,
                locale: langCode,
                messages: {ar},
            },
            canvas: {
                styles: [
                    "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css", // bootstrap styles
                ],
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
                    {
                        id: 'panel-devices',
                        el: '.panel__devices',
                        buttons: [
                            {
                                id: 'device-desktop',
                                label: '<svg style="display: block; max-width:22px" viewBox="0 0 24 24">\n' +
                                    '            <path fill="currentColor" d="M21,16H3V4H21M21,2H3C1.89,2 1,2.89 1,4V16A2,2 0 0,0 3,18H10V20H8V22H16V20H14V18H21A2,2 0 0,0 23,16V4C23,2.89 22.1,2 21,2Z"></path>\n' +
                                    '        </svg>',
                                command: 'set-device-desktop',
                                active: true,
                                togglable: false,
                            },
                            {
                                id: 'device-tablet',
                                label: '<svg style="display: block; max-width:22px" viewBox="0 0 24 24">\n' +
                                    '            <path fill="currentColor" d="M19,18H5V6H19M21,4H3C1.89,4 1,4.89 1,6V18A2,2 0 0,0 3,20H21A2,2 0 0,0 23,18V6C23,4.89 22.1,4 21,4Z"></path>\n' +
                                    '        </svg>',
                                command: 'set-device-tablet',
                                active: true,
                                togglable: false,
                            },
                            {
                                id: 'device-mobile',
                                label: '<svg style="display: block; max-width:22px" viewBox="0 0 24 24">\n' +
                                    '            <path fill="currentColor" d="M17,19H7V5H17M17,1H7C5.89,1 5,1.89 5,3V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V3C19,1.89 18.1,1 17,1Z"></path>\n' +
                                    '        </svg>',
                                command: 'set-device-mobile',
                                togglable: false,
                            },
                        ],
                    },
                    {
                        id: 'basic-actions',
                        el: '.panel__basic-actions',
                        buttons: [
                            {
                                id: 'view',
                                className: 'btn-view',
                                label: 'View', // Text on the button
                                command: 'preview', // Custom command for viewing
                                togglable: true, // Allows toggling on/off
                            },
                        ],
                    },
                ],
            },
            storageManager: false,
            showToolbar: false,
            keepEmptyTextNodes: false,
            deviceManager: {
                devices: [
                    {
                        name: 'Desktop',
                        width: '', // default size
                    },
                    {
                        name: 'Mobile',
                        width: '320px', // this value will be used on canvas width
                        widthMedia: '480px', // this value will be used in CSS @media
                    },
                    {
                        name: 'Tablet',
                        width: '520px',
                        widthMedia: '680px',
                    },
                ],
            },
            blockManager: {
                appendTo: '#blocks',
                blocks: [
                    {
                        id: 'link',
                        label: 'Link',
                        category: 'Basic',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/head.png">`,
                        content: {type: 'link'}
                    },
                    {
                        id: 'head',
                        label: 'Title',
                        category: 'Text',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/head.png">`,
                        content: `<h2>Title</h2>`
                    },
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
                        attributes: {class: 'gjs-block-section'},
                        content: `<div>Insert your text here</div>`,
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
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/divider.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `<hr/>`
                    },
                    {
                        id: 'quote',
                        label: 'Quote',
                        category: 'Text',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/quote.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `<blockquote>Some Text Here</blockquote>`
                    },
                    {
                        id: 'one-column',
                        label: 'column',
                        category: 'Columns',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/column.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: {type: 'column'},
                    },
                    {
                        id: 'two-columns',
                        label: '2columns',
                        category: 'Columns',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/2columns.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: {type: 'two-columns'},
                    },
                    {
                        id: 'three-columns',
                        label: '3columns',
                        category: 'Columns',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/3columns.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: {type: 'three-columns'},
                    },
                    {
                        id: 'division',
                        label: 'division',
                        category: 'Columns',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/column.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: {type: 'division'},
                    },
                    {
                        id: 'unordered-list',
                        label: 'U-List',
                        category: 'Lists',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/unordered_list.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `<ul style="list-style-type: disc; padding-left: 20px;"><li>List Item 1</li><li>List Item 2</li></ul>`
                    },
                    {
                        id: 'ordered-list',
                        label: 'O-List',
                        category: 'Lists',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/ordered_list.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `<ol style="padding-left: 20px;">
            <li>List Item 1</li>
            <li>List Item 2</li>
        </ol>`
                    },
                    {
                        id: 'check-list',
                        label: 'C-List',
                        category: 'Lists',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/check_list.png">`,
                        select: true,
                        hover: true,
                        activate: true,
                        content: `<ul style="list-style-type: '&check;'; padding-left: 20px;">
            <li>List Item 1</li>
            <li>List Item 2</li>
        </ul>`
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
                        content: {
                            type: 'code', // Use the component type defined above
                            codeContent: 'console.log("New Code Block!");', // Default content for the new block
                            codeOutput: '',
                        },
                        activate: true,
                        select: true,
                    },
                    {
                        id: 'button',
                        label: 'Button',
                        category: 'Forms',
                        media: `<img src="/bundles/programcmspost/images/editor/blocks/button.png">`,
                        // content: '<button class="btn btn-primary" data-gjs-type="button">Insert your text here</button>',
                        content: {type: 'button'},
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
                    buildProps: ['float', 'display', 'top', 'right', 'left', 'bottom'],
                    properties: [
                        {
                            type: 'select',
                            property: 'position',
                            label: 'Position',
                            default: 'static',
                            options: [
                                {id: 'static', label: 'static'},
                                {id: 'relative', label: 'relative'},
                                {id: 'absolute', label: 'absolute'},
                                {id: 'fixed', label: 'fixed'},
                            ]
                        },
                    ]
                },
                    {
                        name: 'typography',
                        open: false,
                        buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-decoration', 'text-shadow'],
                    },
                    {
                        name: 'Appearance',
                        open: false,
                        buildProps: ['border', 'border-radius', 'background', 'background-color', 'opacity', 'box-shadow'],
                        properties: [
                            {
                                name: 'Background Color',
                                property: 'background-color',
                                type: 'color',
                            },
                        ],
                    },
                    {
                        name: 'dimension',
                        open: false,
                        buildProps: ['width', 'height', 'min-width', 'max-width', 'min-height', 'max-height', 'padding', 'margin']
                    },
                ]
            },
            traitManager: {
                appendTo: '#traits-container',
            },
            selectorManager: {
                appendTo: '#traits-container',
                custom: true,
                componentFirst: true,
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

        self.editor.Commands.add('set-device-desktop', {
            run: (editor) => editor.setDevice('Desktop'),
        });
        self.editor.Commands.add('set-device-mobile', {
            run: (editor) => editor.setDevice('Mobile'),
        });
        self.editor.Commands.add('set-device-tablet', {
            run: (editor) => editor.setDevice('Tablet'),
        });

        self.editor.DomComponents.addType('default', {
            model: {
                defaults: {
                    style: {
                        'font-family': 'Arial', // Default font-family
                    },
                },
            },
        });

        self.editor.DomComponents.addType('link', {
            model: {
                defaults: {
                    tagName: 'a',
                    attributes: { href: '#' },
                    traits: [
                        {
                            type: 'text',
                            label: 'Href',
                            name: 'href',
                            placeholder: 'https://example.com',
                        },
                        {
                            type: 'text',
                            label: 'Text',
                            name: 'text',
                            placeholder: 'Link text',
                            changeProp: 1, // Allows real-time updates
                        },
                    ],
                    text: 'Click me', // Default text for the link
                },
                init() {
                    // Listen for changes to the "style" and "text" traits
                    this.on('change:text', this.handleTextChange);
                },
                handleTextChange() {
                    this.set('content', this.get('text')); // Update link text
                },
            },
            view: {
                onRender() {
                    const text = this.model.get('text') || 'Click me';
                    this.el.innerHTML = text;
                },
            },
        });

        self.editor.DomComponents.addType('video', {
            model: {
                defaults: {
                    tagName: 'video',
                    style: {width: '100%'},
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
                    let html = `<div id="${this.getId()}" style="width: 400px; padding: 17px; background-color: #dedede; border-radius: 3px; border: 1px solid #888;">`;
                    const url = this.get('fileUrl');
                    const name = this.get('fileName');
                    const size = this.get('fileSize') ?? 0;
                    if (url) {
                        html += `<div class="row"><div class="col-md-3 text-center"><img src="/bundles/programcmsdrive/images/file_types/file.png"></div><div class="col-md"><a href="${url}" target="_blank">${name}</a>`;
                        html += `<div>Size: ${size} KB</div></div></div>`;
                    } else {
                        html += '...';
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
                    if (url) {
                        html += `<a href="${url}" target="_blank">${name}</a>`;
                        html += `<p>Size: ${size} Kb</p>`;
                    } else {
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

        self.editor.DomComponents.addType('code', {
            model: {
                defaults: {
                    tagName: 'div',
                    traits: [
                        {
                            name: 'language',
                            label: 'Language',
                            type: 'select',
                            options: [
                                {value: 'javascript', name: 'JavaScript'},
                                {value: 'htmlmixed', name: 'HTML'},
                                {value: 'css', name: 'CSS'},
                                {value: 'php', name: 'PHP'},
                                {value: 'python', name: 'Python'},
                            ],
                        },
                    ],
                },
                toHTML() {
                    const language = this.getAttributes().language;
                    return "<pre data-language=\"" + language + "\"><code>" + this.get('codeOutput') + "</code></pre>";
                }
            },
            view: {
                init({model}) {
                    this.listenTo(model, 'render', this.onRender); // Trigger on initial render
                    this.listenTo(model, 'update', this.onRender); // Trigger on updates
                    this.listenTo(model, 'change:attributes:language', this.onLanguageChange);  // Listen to language change

                },
                onRender() {
                    setTimeout(() => {
                        if (!this.cmEditor && this.el) {
                            this.initializeCodeMirror();
                        }
                    }, 0); // Delay to ensure DOM is fully rendered
                },
                onLanguageChange() {
                    const language = this.model.getAttributes().language;
                    if (this.cmEditor) {
                        this.cmEditor.setState(EditorState.create({
                            doc: this.model.get('codeContent'),
                            extensions: [
                                basicSetup,
                                this.getLanguageExtension(language), // Apply the language mode
                            ],
                        }));
                    }
                },
                getLanguageExtension(language) {
                    switch (language) {
                        case 'javascript':
                            return javascript();
                        case 'htmlmixed':
                            return html();  // Assuming HTML is handled
                        case 'css':
                            return css();
                        case 'php':
                            return php();
                        case 'python':
                            return python();   // Assuming CSS is handled
                        default:
                            return javascript();  // Default to JavaScript
                    }
                },
                initializeCodeMirror() {
                    const language = this.model.getAttributes().language;
                    this.cmEditor = new EditorView({
                        state: EditorState.create({
                            doc: this.model.get('codeContent') || 'console.log("Hello, GrapesJS!");',
                            extensions: [
                                basicSetup,
                                this.getLanguageExtension(language),
                                keymap.of([indentWithTab]),
                                EditorView.updateListener.of((update) => {
                                    if (update.docChanged) {
                                        // Save CodeMirror content to the GrapesJS model
                                        const newCode = this.cmEditor.state.doc.toString();
                                        this.model.set('codeContent', newCode); // Save to the component model
                                        if (language === 'htmlmixed') {
                                            this.model.set('codeOutput', newCode.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
                                        } else if (language === 'php') {
                                            this.model.set('codeOutput', newCode.replace(/&/g, '&amp;')
                                                .replace(/</g, '&lt;')
                                                .replace(/>/g, '&gt;'));
                                        } else {
                                            this.model.set('codeOutput', newCode);
                                        }
                                    }
                                }),
                            ],
                        }),
                        parent: this.el,
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
                        {type: 'text', name: 'Title'},
                        {type: 'text', name: 'Cols'},
                        {type: 'text', name: 'Rows'},
                    ],
                }
            },
        });

        self.editor.DomComponents.addType('column', {
            model: {
                defaults: {
                    tagName: 'div',
                    classes: ['col-md-1'], // Default class for the column
                    style: { padding: '15px' },
                    traits: [
                        {
                            type: 'select', // Dropdown trait
                            label: 'Width',
                            name: 'column-width',
                            options: [
                                { value: 'col-md-1', name: '1' },
                                { value: 'col-md-2', name: '2' },
                                { value: 'col-md-3', name: '3' },
                                { value: 'col-md-4', name: '4' },
                                { value: 'col-md-5', name: '5' },
                                { value: 'col-md-6', name: '6' },
                                { value: 'col-md-7', name: '7' },
                                { value: 'col-md-8', name: '8' },
                                { value: 'col-md-9', name: '9' },
                                { value: 'col-md-10', name: '10' },
                                { value: 'col-md-11', name: '11' },
                                { value: 'col-md-12', name: '12' },
                            ],
                            changeProp: 1, // Trigger a property change when the value changes
                        },
                    ],
                },

                // Listen for changes to the 'column-width' property and update the class
                init() {
                    this.listenTo(this, 'change:column-width', this.updateColumnWidth);
                },

                updateColumnWidth() {
                    const widthClass = this.get('column-width');
                    const classes = this.get('classes');
                    // Extract class names as plain strings
                    const classList = classes.map((cls) => (typeof cls === 'string' ? cls : cls.id || ''));
                    // Remove existing col-md-* classes
                    const filteredClasses = classList.filter((cls) => !cls.startsWith('col-md-'));
                    filteredClasses.push(widthClass); // Add the new width class
                    this.set('classes', filteredClasses);
                }
            },
        });

        self.editor.DomComponents.addType('two-columns', {
            model: {
                defaults: {
                    tagName: 'div',
                    classes: ['row'],
                    droppable: true,
                    components: [
                        {
                            type: 'column'
                        },
                        {
                            type: 'column'
                        },
                    ],
                },
            },
        });

        self.editor.DomComponents.addType('three-columns', {
            model: {
                defaults: {
                    tagName: 'div',
                    classes: ['row'],
                    droppable: true,
                    components: [
                        {
                            type: 'column'
                        },
                        {
                            type: 'column'
                        },
                        {
                            type: 'column'
                        }
                    ],
                },
            },
        });

        self.editor.DomComponents.addType('division', {
            model: {
                defaults: {
                    tagName: 'div',
                    style: {width: '100%', padding: '25px'},
                },
            },
        });

        self.editor.DomComponents.addType('button', {
            model: {
                defaults: {
                    tagName: 'button',
                    attributes: { type: 'button', class: 'btn btn-primary'},
                    text: 'Click me!',
                    editable: true,
                    content: 'Click me!',
                    traits: [
                        {
                            type: 'text',
                            label: 'Text',
                            name: 'text',
                            changeProp: 1, // Triggers a rerender when changed
                        },
                        {
                            type: 'text',
                            label: 'Type',
                            name: 'type',
                            changeProp: 1,
                        },
                    ],
                },
                init() {
                    this.on('change:text', this.handleTextChange); // Listen for text changes
                },
                handleTextChange() {
                    const newText = this.get('text');
                    this.set('content', newText);
                    this.trigger('change:content');
                },
            },
            view: {
                onRender() {
                    const text = this.model.get('text');
                    this.el.innerHTML = text;
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

            if (self.entityIdValue != null && self.entityIdValue !== '') {
                self.loadProjectData(self.editor);
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

    prepareMenuBar() {
        const menu = `<div class="menu-bar">
                        <ul class="root-menu">
                            <li class="menu-item">
                                File
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        New
                                        <ul class="sub-menu">
                                            <li class="menu-item">Project</li>
                                            <li class="menu-item">File</li>
                                        </ul>
                                    </li>
                                    <li class="menu-item">Open</li>
                                    <li class="menu-item">Save</li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                Edit
                                <ul class="sub-menu">
                                    <li class="menu-item">Undo</li>
                                    <li class="menu-item">Redo</li>
                                    <li class="menu-item">
                                        Preferences
                                        <ul class="sub-menu">
                                            <li class="menu-item">Settings</li>
                                            <li class="menu-item">Shortcuts</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                Display
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        New
                                        <ul class="sub-menu">
                                            <li class="menu-item">Project</li>
                                            <li class="menu-item">File</li>
                                        </ul>
                                    </li>
                                    <li class="menu-item">Open</li>
                                    <li class="menu-item">Save</li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                Help
                                <ul class="sub-menu">
                                    <li class="menu-item">Documentation</li>
                                    <li class="menu-item">About</li>
                                </ul>
                            </li>
                        </ul>
                    </div>`;
        return menu;
    }

    prepareEditorHeader() {
        const editorHeader = `<div class="image-input-container">
                                <a href="">
                                    <img class="float-start" src="${this.iconValue}" width="35"
                                         height="35" alt=""/>
                                </a>
                                <div class="w-100 ms-2">
                                    <input type="text" name="editor_title" id="editor_title" class="form-control editor_title p-1 ps-2" placeholder="Document Title ...">
                                    ${this.prepareMenuBar()}
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-switch me-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                            <label class="form-check-label text-primary" style="font-size: 12px; font-weight: bold;" for="flexSwitchCheckDefault">Auto Save</label>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary rounded-start-5 ps-3" data-action="editor#onPreview">Preview</button>
                            <button type="button" class="btn btn-primary active" data-action="editor#onSubmit">Save</button>
                            <button type="button" class="btn btn-primary rounded-end-5 pe-3 dropdown-toggle active"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Save Post Privately</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <p class="mb-0 p-3 pt-2 pb-2 text-muted" style="font-size: 14px;">
                                    The Post is saved to your account and will not be published on the site. You can publish it later.
                                </p>
                            </ul>
                        </div>`;
        $('.editor-header').html(editorHeader);
    }

    preparePanelTop() {
        const panelTop = `<div class="panel__actions">
                            <div class="editor-rte-action editor-icon btn-redo"></div>
                            <div class="editor-rte-action editor-icon btn-undo"></div>
                            <div class="editor-rte-action editor-icon btn-print"></div>
                        </div>
                        <div class="panel__actions">
                            ${this.selectUi([{label: '25%', value: '25'}, {label: '50%', value: '50'}, {label: '75%', value: '75'}, {label: '100%', value: '100'}])}
                        </div>
                        <div class="panel__actions">
                            ${this.selectUi([{label: 'Classic', value: 'classic'}, {label: 'Title 1', value: 'title1', className: 'block_title_1'}, {label: 'Title 2', value: 'title2', className: 'block_title_2'}])}
                        </div>
                        <div class="panel__actions">
                            ${this.selectUi([{label: 'Arial', value: 'arial'}, {label: 'Tahoma, sans-serif', value: 'tahoma', className: 'block_font_tahoma'},])}
                        </div>
                        <div class="panel__actions">
                            <div class="editor-rte-action editor-icon btn-bold" id="bold"></div>
                            <div class="editor-rte-action editor-icon btn-italic" id="italic"></div>
                            <div class="editor-rte-action editor-icon btn-underline" id="underline"></div>
                            <div class="editor-rte-action editor-icon btn-text-color" id="textColor">
                                <input type="text" style="position: absolute; width: 1px; height: 1px; left: 0; top: 0; border: 0; background: inherit" id="text-color-choose" />
                                <div id="choosen-color" style="position:absolute; width: 19px; height: 3px; background-color: black; left: 0; right: 0; margin: auto; bottom: 6px;"></div>
                            </div>
                        </div>
                        <div class="panel__actions">
                            <div class="editor-rte-action editor-icon btn-link" id="link"></div>
                        </div>
                        <div class="panel__actions">
                            <div class="editor-rte-action editor-icon btn-left-align" id="leftAlign"></div>
                            <div class="editor-rte-action editor-icon btn-center-align" id="centerAlign"></div>
                            <div class="editor-rte-action editor-icon btn-right-align" id="rightAlign"></div>
                        </div>
                        <div class="components_menu" style="margin-left: auto; display: flex;">
                            <div class="panel__devices"></div>
                            
                            <div class="panel__actions components_manager">
                                <div class="editor-rte-action with_text editor-icon btn-style-manager active" id="styles">Design</div>
                            </div>
                            <div class="panel__actions components_manager">
                                <div class="editor-rte-action editor-icon btn-traits" id="traits"></div>
                            </div>
                            <div class="panel__actions components_manager">
                                <div class="editor-rte-action editor-icon btn-settings" id="settings"></div>
                            </div>
                            <div class="panel__actions components_manager">
                                <div class="editor-rte-action editor-icon btn-layers" id="layers"></div>
                            </div>
                        </div>
                        `;

        $('.panel__top').html(panelTop);
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

    selectUi(dataSource) {
        let ui = `<div class="dropdown">
                    <button class="btn dropdown-toggle editor-dropdown editor-rte-action" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ${dataSource[0]['label']}
                    </button>
                    <ul class="dropdown-menu">`;
        for(let i=0; i<dataSource.length; i++) {
            const item = dataSource[i];
            const itemClassName = item['className'] ?? '';
            ui += `<li><a class="dropdown-item ${itemClassName}" href="#">${item['label']}</a></li>`;
        }

        ui += `</ul></div>`;
        return ui;
    }

    onSubmit(event) {
        event.preventDefault();
        let self = this;

        const form = self.element;

        // Crée un FormData à partir du formulaire (inclut les fichiers automatiquement)
        const formData = new FormData(form);

        // Ajoute les données custom (éditeur, HTML, CSS, etc.)
        formData.append('entity_id', self.entityIdValue);
        formData.append('title', $('input[name=editor_title]').val());
        formData.append('data', JSON.stringify(self.editor.getProjectData()));
        formData.append('html', self.editor.getHtml());
        formData.append('css', self.editor.getCss());

        const eavFields = document.querySelectorAll('#eavAttributes input, #eavAttributes select, #eavAttributes textarea');
        eavFields.forEach(field => {
            if (field.name) {
                if (field.type === 'file') {
                    for (let i = 0; i < field.files.length; i++) {
                        formData.append(field.name, field.files[i]);
                    }
                } else {
                    formData.append(field.name, field.value);
                }
            }
        });

        // Si tu veux merger aussi du JSON existant
        if (this.jsonValue) {
            const jsonData = JSON.parse(this.jsonValue);
            for (const [key, value] of Object.entries(jsonData)) {
                formData.append(key, value);
            }
        }

        $.ajax({
            url: self.saveEndpointValue,
            method: 'post',
            data: formData,
            processData: false, // Important pour envoyer des fichiers !
            contentType: false, // Important pour laisser le navigateur gérer le type
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
                        setTimeout(() => $('.editor_message').fadeOut(), 3000);
                    }
                }
            },
            complete: function () {
                Loader.stopLoader();
            }
        });
    }

    onPreview() {
        this.editor.runCommand('core:preview'); // Enable preview mode
    }

    /**
     * Load Project
     * @param editor
     */
    loadProjectData(editor) {
        // Load Project Data
        let self = this;
        $.ajax({
            url: self.loadEndpointValue,
            method: 'post',
            beforeSend: function () {
                console.log(Loader);
                Loader.startLoader();
            },
            success: function (result) {
                if (result.edit) {
                    let data = JSON.parse(result.data);
                    $('.editor_title').val(result.title);
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
                        *::-webkit-scrollbar {width: 1px;}
                        html, body {
                            font-family: Arial;
                            line-height: 24px;
                            font-size: 16px;
                            color: #000000;
                        }
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

    getRandomIntInclusive(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
});