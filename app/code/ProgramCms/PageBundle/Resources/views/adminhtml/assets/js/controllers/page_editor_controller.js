/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import grapesjs from 'grapesjs';
import pagePlugin from 'grapesjs-preset-webpage';

application.register('page-editor', class extends Controller {

    connect() {
        const editorId = $(this.element).attr('id');

        const editor = grapesjs.init({
            container: '#' + editorId,
            plugins: [
                editor => pagePlugin(editor, {
                    height: 'auto',
                    width: 'auto',
                }),
            ],
        });
        editor.Panels.getPanel('options').buttons.add([
            {
                id: 'visibility',
                active: false,
                className: 'btn-save-template',
                label: '<button class="btn btn-primary btn-sm mt-1 fw-bold" style="font-size: 12px;">Save Page</button>',
                command: 'sw-visibility', // Built-in command
            }
        ]);
    }
});