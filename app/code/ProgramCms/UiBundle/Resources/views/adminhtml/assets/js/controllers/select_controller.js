/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import {Controller} from "@hotwired/stimulus";
import 'select2';

application.register('select', class extends Controller {
    /**
     * Targets
     * @type {string[]}
     */
    static targets = ["select2", "selectValue"]

    connect() {
        let self = this;
        let element = $(self.select2Target);

        element.select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder')
        });
        if(self.hasSelectValueTarget) {
            element.on('change', function (e) {
                const valueData = element.select2('data');
                let values = [];
                for (let i = 0; i < valueData.length; i++) {
                    values.push(valueData[i].id);
                }
                self.selectValueTarget.value = values.join();
            });
        }
    }
});