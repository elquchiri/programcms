/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import grapesjs from 'grapesjs';
import emailPlugin from 'grapesjs-preset-newsletter';

application.register('email-editor', class extends Controller {

    connect() {
        const editorId = $(this.element).attr('id');

        const editor = grapesjs.init({
            container: '#' + editorId,
            plugins: [
                editor => emailPlugin(editor, {
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
                label: '<button class="btn btn-primary btn-sm mt-1 fw-bold" style="font-size: 12px;">Save Template</button>',
                command: 'sw-visibility', // Built-in command
            }
        ]);
    }
});