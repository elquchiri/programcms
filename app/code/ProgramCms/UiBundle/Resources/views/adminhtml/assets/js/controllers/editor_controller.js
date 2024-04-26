/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import EditorJS from '@editorjs/editorjs';
import Underline from '@editorjs/underline';
import ChangeCase from 'editorjs-change-case';
import Strikethrough from '@sotaproject/strikethrough';
import Header from '@editorjs/header';
import ImageTool from '@editorjs/image';
import editorjsColumns from '@calumk/editorjs-columns';
const ColorPlugin = require('editorjs-text-color-plugin');
import Tooltip from 'editorjs-tooltip';
import DragDrop from 'editorjs-drag-drop';
import Undo from 'editorjs-undo';
import InlineCode from '@editorjs/inline-code';
import CodeTool from '@editorjs/code';
import Table from '@editorjs/table'
import RawTool from '@editorjs/raw';
const MermaidTool = require('editorjs-mermaid');
import NestedList from '@editorjs/nested-list';
//import SimpleImage from "@editorjs/simple-image";
import AttachesTool from '@editorjs/attaches';

application.register('editor', class extends Controller {
    /**
     * @type {{placeholder: StringConstructor}}
     */
    static values = {
        placeholder: String,
    };

    connect() {
        const editorId = $(this.element).attr('id');
        const self = this;
        // first define the tools to be made avaliable in the columns
        let column_tools = {
            header: Header
        }

        const editor = new EditorJS({
            holder: editorId,
            placeholder: self.placeholderValue ?? '',
            onReady: () => {
                new DragDrop(editor);
                new Undo({editor});
                MermaidTool.config({ 'theme': 'neutral' });
            },
            tools: {
                underline: Underline,
                strikethrough: Strikethrough,
                changeCase: {
                    class: ChangeCase,
                    config: {
                        showLocaleOption: true, // enable locale case options
                        locale: 'tr' // or ['tr', 'TR', 'tr-TR']
                    }
                },
                header: Header,
                list: {
                    class: NestedList,
                    inlineToolbar: true,
                    config: {
                        defaultStyle: 'unordered'
                    },
                },
                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: 'http://localhost:8008/uploadFile', // Your backend file uploader endpoint
                            byUrl: 'http://localhost:8008/fetchUrl', // Your endpoint that provides uploading by Url
                        }
                    }
                },
                //simpleImage: SimpleImage,
                columns: {
                    class: editorjsColumns,
                    config: {
                        EditorJsLibrary: EditorJS, // Pass the library instance to the columns instance.
                        tools: column_tools // IMPORTANT! ref the column_tools
                    }
                },
                Color: {
                    class: ColorPlugin, // if load from CDN, please try: window.ColorPlugin
                    config: {
                        colorCollections: ['#EC7878','#9C27B0','#673AB7','#3F51B5','#0070FF','#03A9F4','#00BCD4','#4CAF50','#8BC34A','#CDDC39', '#FFF'],
                        defaultColor: '#FF1300',
                        type: 'text',
                        customPicker: true // add a button to allow selecting any colour
                    }
                },
                Marker: {
                    class: ColorPlugin, // if load from CDN, please try: window.ColorPlugin
                    config: {
                        defaultColor: '#FFBF00',
                        type: 'marker',
                        icon: `<svg fill="#000000" height="200px" width="200px" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M17.6,6L6.9,16.7c-0.2,0.2-0.3,0.4-0.3,0.6L6,23.9c0,0.3,0.1,0.6,0.3,0.8C6.5,24.9,6.7,25,7,25c0,0,0.1,0,0.1,0l6.6-0.6 c0.2,0,0.5-0.1,0.6-0.3L25,13.4L17.6,6z"></path> <path d="M26.4,12l1.4-1.4c1.2-1.2,1.1-3.1-0.1-4.3l-3-3c-0.6-0.6-1.3-0.9-2.2-0.9c-0.8,0-1.6,0.3-2.2,0.9L19,4.6L26.4,12z"></path> </g> <g> <path d="M28,29H4c-0.6,0-1-0.4-1-1s0.4-1,1-1h24c0.6,0,1,0.4,1,1S28.6,29,28,29z"></path> </g> </g></svg>`
                    }
                },
                tooltip: {
                    class: Tooltip,
                    config: {
                        location: 'left',
                        underline: true,
                        placeholder: 'Enter a tooltip',
                        highlightColor: '#FFEFD5',
                        backgroundColor: '#154360',
                        textColor: '#FDFEFE',
                        holder: editorId,
                    }
                },
                inlineCode: {
                    class: InlineCode,
                    shortcut: 'CMD+SHIFT+M',
                },
                code: CodeTool,
                table: Table,
                raw: RawTool,
                mermaid: MermaidTool,
                attaches: {
                    class: AttachesTool,
                    config: {
                        endpoint: 'http://localhost:8008/uploadFile'
                    }
                }
            }
        });
    }
});