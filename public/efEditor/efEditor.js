/**
 * Copyright © ProgramCMS, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

(function ($) {
    // Used to switch between Editor / HTML-code View
    var currentViewMode = 0;

    // Last selected Range when editor's focus is out
    var range = null;

    let components = {
        /**
         * Process selection's style (font-weight, font-style, color, background-color, ...)
         * @param cssProperty
         * @param cssPropertieValy
         */
        _addEventEditionButton: function(cssProperty, cssPropertieValy) {
            let selection = window.getSelection().getRangeAt(0);
            let selectedText = selection.extractContents();
            let span = document.createElement("span");

            try {
                span.style[cssProperty] = cssPropertieValy;
            } catch (e) {
                console.trace(e);
            }

            span.appendChild(selectedText);
            selection.insertNode(span);
        },
        /**
         * Editor's view Switcher (HTML, Editable)
         */
        _export: function(efContent, htmlView) {
            // If we're in editor mode 'default view'
            if(currentViewMode == 0) {
                const options = {
                    indent_size: 4,
                    indent_inner_html: false
                };

                var beautifyContent = html_beautify("<!DOCTYPE html><html><head></head><body>" + efContent.html() + "</body></html>", options);

                htmlView.text(beautifyContent);
                $('pre').each(function(i, e) {
                    hljs.configure({languages: ['xml']});
                    hljs.highlightElement(e);
                });

                efContent.hide();
                htmlView.show();
                currentViewMode = 1;
            }else{
                efContent.show();
                htmlView.hide();
                currentViewMode = 0;
            }
        },
        /**
         * Add URLs
         */
        _url: function() {
            $('.url-modal').modal('show');

            $('#url-form').submit(function(e) {
                helpers.restoreSelection();
                e.preventDefault();

                let urlTitle = $('input[name=url_title]').val();
                let url = $('input[name=url]').val();

                var a = document.createElement("a");
                a.href = url;
                a.innerText = urlTitle;

                // var range = window.getSelection().getRangeAt(0);
                window.getSelection().getRangeAt(0).insertNode(a);

                $('.url-modal').modal('hide');
            });
        },
        /**
         * Add Images
         */
        _image: function() {
            $('#image_upload').trigger('click');
        },
        /**
         * Add Videos
         */
        _video: function() {
            $('.video-modal').modal('show');

            $('#video-form').submit(function(e) {
                helpers.restoreSelection();
                e.preventDefault();

                let videoProvider = $(this).find('select[name=video_provider]').val();
                let url = $(this).find('input[name=url]').val();

                var div = document.createElement("div");
                div.setAttribute('class', 'embed-responsive embed-responsive-16by9');

                var iframe = document.createElement('iframe');
                iframe.setAttribute('class', 'embed-responsive-item');
                iframe.src = url;
                iframe.setAttribute('allowfullscreen', 'true');

                div.appendChild(iframe);

                window.getSelection().getRangeAt(0).insertNode(div);

                $('.video-modal').modal('hide');
            });
        },
        /**
         * Add & Format Code
         */
        _code: function() {
            var div = document.createElement('div');
            div.style['backgroundColor'] = '#888';

            var preCode = document.createElement('pre');
            preCode.setAttribute('class', 'language-xml');
            preCode.setAttribute('data-lang', 'xml');
            preCode.setAttribute('contenteditable', 'true');
            preCode.innerText = 'Your Code here ..';

            div.appendChild(preCode);

            range.insertNode(div);
            hljs.configure({languages: ['xml']});
            hljs.highlightElement(e);
        },
        /**
         * FullScreen Mode
         */
        _fullScreen: function() {
            $('.ef-forum-view').removeClass('d-flex');
            $('.ef-forum-view').hide();

            $('.ef-post-title input')
                .css({paddingTop: '11px'})
                .animate({
                    paddingBottom: '11px'
                }, 300);
        },
        _textAlign: function(direction) {
            let selection = window.getSelection().getRangeAt(0);
            let selectedText = selection.extractContents();
            let div = document.createElement("div");

            try {
                div.style['textAlign'] = direction;
            } catch (e) {
                console.trace(e);
            }

            div.appendChild(selectedText);
            selection.insertNode(div);
        }
    };

    let helpers = {
        saveSelection: function() {
            if(window.getSelection) {
                sel = window.getSelection();
                if(sel.getRangeAt && sel.rangeCount) {
                    let ranges = [];
                    for(var i = 0, len = sel.rangeCount; i < len; ++i) {
                        ranges.push(sel.getRangeAt(i));
                    }
                    return ranges;
                }
            } else if (document.selection && document.selection.createRange) {
                return document.selection.createRange();
            }
            return null;
        },
        restoreSelection: function() {
            savedSel = range;
            if(savedSel) {
                if(window.getSelection) {
                    sel = window.getSelection();
                    sel.removeAllRanges();
                    for(var i = 0, len = savedSel.length; i < len; ++i) {
                        sel.addRange(savedSel[i]);
                    }
                } else if(document.selection && savedSel.select) {
                    savedSel.select();
                }
            }
            return window.getSelection().getRangeAt(0).extractContents();
        },
        headStyle: function() {
            let sizes = [14, 20, 30, 40];
            var select = document.createElement('select');
            for(var i=0; i<sizes.length; i++) {
                var option = document.createElement('option');
                option.innerText = 'Title ' + (i + 1);
                option.setAttribute('value', sizes[i]);
                option.style['fontSize'] = sizes[i];
                select.appendChild(option);
            }

            $(select).on('change', function() {
                let titleSize = $(this).val();
                let selectedText = helpers.restoreSelection();
                let selection = window.getSelection().getRangeAt(0);
                let span = document.createElement("span");

                try {
                    span.style['fontSize'] = titleSize + 'px';
                } catch (e) {
                    console.trace(e);
                }

                span.appendChild(selectedText);
                selection.insertNode(span);
            });

            return select;
        },
        fontFamily: function() {
            let sizes = ['Arial', 'Tahoma', 'sans-serif'];
            var select = document.createElement('select');
            for(var i=0; i<sizes.length; i++) {
                var option = document.createElement('option');
                option.innerText = sizes[i];
                option.style['fontFamily'] = sizes[i];
                select.appendChild(option);
            }
            return select;
        },
        fontSize: function() {
            var select = document.createElement('select');
            for(var i=11; i<=30; i++) {
                var option = document.createElement('option');
                option.innerText = i;
                option.setAttribute('value', i);
                select.appendChild(option);
            }

            $(select).on('change', function() {
                let fontSize = $(this).val();
                let selectedText = helpers.restoreSelection();
                let selection = window.getSelection().getRangeAt(0);
                let span = document.createElement("span");

                try {
                    span.style['fontSize'] = fontSize + 'px';
                } catch (e) {
                    console.trace(e);
                }

                span.appendChild(selectedText);
                selection.insertNode(span);
            });

            return select;
        },
        table: function(li) {
            let tableModel = [10, 10];
            li.setAttribute('class', 'nav-item dropdown');

            var a = document.createElement('a');
            a.setAttribute('href', '#');
            a.setAttribute('class', 'nav-link');
            a.setAttribute('role', 'button');
            a.setAttribute('data-bs-toggle', 'dropdown');
            a.setAttribute('aria-haspopup', 'true');
            a.setAttribute('aria-expanded', 'false');

            var img = document.createElement('img');
            img.src = window.location.origin + '/efEditor/images/' + 'table.png';
            a.appendChild(img);
            // Append menu item
            li.appendChild(a);

            var dropdown = document.createElement('div');
            dropdown.setAttribute('class', 'dropdown-menu ef-dropdown-items');

            var tbl = document.createElement('table');
            tbl.setAttribute('class', 'ef-component-table');

            for(var i=0; i<tableModel[0]; i++) {
                var tr = document.createElement('tr');
                for(var j=0; j<tableModel[1]; j++) {
                    var td = document.createElement('td');
                    td.setAttribute('id', i+'f'+j);
                    tr.appendChild(td);
                }
                tbl.appendChild(tr);
            }

            dropdown.appendChild(tbl);

            var a = document.createElement('a');
            a.setAttribute('class', 'dropdown-item');
            a.setAttribute('href', '#');
            a.innerText = 'Customize Cells';
            dropdown.appendChild(a);
            // Append dropdown menu item
            li.appendChild(dropdown);

            $(tbl).find('td').on('mouseover', function(e) {
                let coords = $(this).attr('id');
                let column = coords.split('f')[0];
                let row = coords.split('f')[1];

                $('td').removeClass('selected');
                for(var i=0; i<=column; i++) {
                    for(var j=0; j<=row; j++) {
                        $('td#' + i + 'f' + j).addClass('selected');
                    }
                }
            });
            $(tbl).on('mouseout', function() {
                $(this).find('td').removeClass('selected');
            });

            $(tbl).find('td').on('click', function(e) {
                helpers.restoreSelection();
                e.preventDefault();

                let coords = $(this).attr('id');
                let column = coords.split('f')[0];
                let row = coords.split('f')[1];

                var table = document.createElement('table');
                table.setAttribute('class', 'ef-editor-table');
                for(var i=0; i<=column; i++) {
                    var tr = document.createElement('tr');
                    for(var j=0; j<=row; j++) {
                        var td = document.createElement('td');
                        tr.appendChild(td);
                        $('td#' + i + 'f' + j).addClass('selected');
                    }
                    table.appendChild(tr);
                }
                window.getSelection().getRangeAt(0).insertNode(table);
            });
        },
        textColor: function(li) {
            li.setAttribute('class', 'nav-item dropdown');

            var a = document.createElement('a');
            a.setAttribute('href', '#');
            a.setAttribute('class', 'nav-link');
            a.setAttribute('role', 'button');
            a.setAttribute('data-bs-toggle', 'dropdown');
            a.setAttribute('aria-haspopup', 'true');
            a.setAttribute('data-bs-auto-close', 'outside');
            a.setAttribute('aria-expanded', 'false');

            var img = document.createElement('img');
            img.src = window.location.origin + '/efEditor/images/' + 'textColor.png';
            a.appendChild(img);
            // Append menu item
            li.appendChild(a);

            var dropdown = document.createElement('div');
            dropdown.setAttribute('class', 'dropdown-menu ef-dropdown-colorpicker-container');

            var colorCanvas = document.createElement('canvas');
            colorCanvas.setAttribute('class', 'ef-component-colorpicker');
            colorCanvas.setAttribute('width', '200px');
            colorCanvas.setAttribute('height', '200px');

            var sliderCanvas = document.createElement('canvas');
            sliderCanvas.setAttribute('class', 'ef-component-slider-colorpicker');
            sliderCanvas.setAttribute('width', '40px');
            sliderCanvas.setAttribute('height', '200px');

            var sliderCanvasMarker = document.createElement('div');
            sliderCanvasMarker.setAttribute('class', 'ef-component-slider-colorpicker-marker');

            dropdown.appendChild(colorCanvas);
            dropdown.appendChild(sliderCanvas);
            dropdown.appendChild(sliderCanvasMarker);

            var tbl = document.createElement('table');
            tbl.setAttribute('class', 'ef-component-table');
            var tr = document.createElement('tr');
            tbl.appendChild(tr);
            var tableModel = ['#000000', '#81c91c', '', '', '', '', '', '', '', ''];
            for (var j = 0; j < tableModel.length; j++) {
                var td = document.createElement('td');
                td.style['backgroundColor'] = tableModel[j];
                td.style['border'] = '1px solid #CCC';
                tr.appendChild(td);
            }
            dropdown.appendChild(tbl);

            // Append dropdown menu item
            li.appendChild(dropdown);

            var ColorCtx = colorCanvas.getContext('2d');  // This create a 2D context for the canvas
            // Create a horizontal gradient
            let gradientH = ColorCtx.createLinearGradient(0, 0, ColorCtx.canvas.width, 0);
            gradientH.addColorStop(0, '#ffffff');
            gradientH.addColorStop(1, '#fa0606');
            ColorCtx.fillStyle = gradientH;
            ColorCtx.fillRect(0, 0, ColorCtx.canvas.width, ColorCtx.canvas.height);
            // Create a Vertical Gradient(white to black)
            let gradientV = ColorCtx.createLinearGradient(0, 0, 0, 200);
            gradientV.addColorStop(0, 'rgba(0,0,0,0)');
            gradientV.addColorStop(1, '#000');
            ColorCtx.fillStyle = gradientV;
            ColorCtx.fillRect(0, 0, ColorCtx.canvas.width, ColorCtx.canvas.height);
            colorCanvas.addEventListener('click', function (event) {
                let x = event.clientX;  // Get X coordinate
                let y = event.clientY;  // Get Y coordinate
                pixel = ColorCtx.getImageData(0, y-140, 1, 1)['data'];   // Read pixel Color
                rgb = `rgb(${pixel[0]},${pixel[1]},${pixel[2]})`;

                // document.body.style.background = rgb;    // Set this color to body of the document
                let selectedText = helpers.restoreSelection();
                var span = document.createElement('span');
                span.style['color'] = rgb;
                span.appendChild(selectedText);
                window.getSelection().getRangeAt(0).insertNode(span);
            });

            var SliderCtx = sliderCanvas.getContext('2d');  // This create a 2D context for the canvas

            // Create a horizontal gradient
            let gradientH2 = SliderCtx.createLinearGradient(0, 0, SliderCtx.canvas.width, 0);
            gradientH2.addColorStop(0, '#fff');
            gradientH2.addColorStop(1, '#000');
            SliderCtx.fillStyle = gradientH2;
            SliderCtx.fillRect(0, 0, SliderCtx.canvas.width, SliderCtx.canvas.height);

            // Create a Vertical Gradient(white to black)
            let gradientV2 = SliderCtx.createLinearGradient(0, 0, 0, 200);
            gradientV2.addColorStop(0.1, '#ff0000');
            gradientV2.addColorStop(0.2, '#ff5500');
            gradientV2.addColorStop(0.4, '#eeff00');
            gradientV2.addColorStop(0.6, '#00ff00');
            gradientV2.addColorStop(0.8, '#0000ff');
            gradientV2.addColorStop(0.9, '#e600ff');
            gradientV2.addColorStop(1, '#ff0000');
            SliderCtx.fillStyle = gradientV2;
            SliderCtx.fillRect(0, 0, SliderCtx.canvas.width, SliderCtx.canvas.height);

            sliderCanvas.addEventListener('click', function (event) {
                let x = event.clientX;  // Get X coordinate
                let y = event.clientY;  // Get Y coordinate

                pixel = SliderCtx.getImageData(0, y-140, 1, 1)['data'];   // Read pixel Color
                rgb = `rgb(${pixel[0]},${pixel[1]},${pixel[2]})`;

                sliderCanvasMarker.style['top'] = y - 140;
                sliderCanvasMarker.style['left'] = 200 - 2.5;

                // Create a horizontal gradient
                var gradientH = ColorCtx.createLinearGradient(0, 0, ColorCtx.canvas.width, 0);
                gradientH.addColorStop(0, '#ffffff');
                gradientH.addColorStop(1, rgb);
                ColorCtx.fillStyle = gradientH;
                ColorCtx.fillRect(0, 0, ColorCtx.canvas.width, ColorCtx.canvas.height);
                // Create a Vertical Gradient(white to black)
                var gradientV = ColorCtx.createLinearGradient(0, 0, 0, 200);
                gradientV.addColorStop(0, 'rgba(0,0,0,0)');
                gradientV.addColorStop(1, '#000');
                ColorCtx.fillStyle = gradientV;
                ColorCtx.fillRect(0, 0, ColorCtx.canvas.width, ColorCtx.canvas.height);
            });
        }
    }

    $.fn.efEditor = function (options) {

        var settings = $.extend({
            components: [
                ['bold', 'italic', 'underline'],
                ['headStyle', 'fontFamily', 'fontSize'],
                ['textColor', 'backgroundColor'],
                ['leftAlign', 'centerAlign', 'rightAlign'],
                ['url', 'image', 'video'],
                ['orderedList', 'numberedList', 'checkboxList'],
                ['table', 'separator', 'code'],
                ['widget', 'emoji', 'export', 'fullscreen']
            ],
        }, options);

        return this.each(function() {
            let efEditorElement = $(this);

            var editorToolbarElement = document.createElement('div');
            editorToolbarElement.setAttribute('class', 'ef-toolbar');

            var efContent = document.createElement('div');
            efContent.setAttribute('class', 'ef-content');
            efContent.setAttribute('placeholder', 'Write @ to tag community users');
            efContent.setAttribute('contenteditable', 'true');
            efContent.setAttribute('autofocus', 'true');

            var htmlView = document.createElement('pre');
            htmlView.setAttribute('class', 'html-view language-xml');
            htmlView.setAttribute('data-lang', 'xml');

            for(var componentGroup=0; componentGroup < settings.components.length; componentGroup++) {
                var ul = document.createElement('ul');

                for(var component=0; component < settings.components[componentGroup].length; component++) {
                    var li = document.createElement('li');

                    if(
                        settings.components[1].includes(settings.components[componentGroup][component]) ||
                        settings.components[componentGroup][component] == 'table' ||
                        settings.components[componentGroup][component] == 'textColor'
                    ) {
                        switch (settings.components[componentGroup][component]) {
                            case 'headStyle':
                                li.appendChild(helpers.headStyle());
                                break;
                            case 'fontFamily':
                                li.appendChild(helpers.fontFamily());
                                break;
                            case 'fontSize':
                                li.appendChild(helpers.fontSize());
                                break;
                            case 'table':
                                helpers['table'].apply(this, [li]);
                                break;
                            case 'textColor':
                                helpers['textColor'].apply(this, [li]);
                                break;
                        }

                    }else{
                        var a = document.createElement('a');
                        a.setAttribute('href', '#');
                        a.setAttribute('data-ef-code', settings.components[componentGroup][component]);
                        var img = document.createElement('img');
                        img.src = window.location.origin + '/efEditor/images/' + settings.components[componentGroup][component] + '.png';

                        a.appendChild(img);
                        li.appendChild(a);
                    }

                    ul.appendChild(li);
                }

                editorToolbarElement.appendChild(ul);
            }

            efEditorElement.append($(editorToolbarElement));
            efEditorElement.append($(efContent));
            efEditorElement.append($(htmlView));

            efContent = $(efContent);
            htmlView = $(htmlView);

            efEditorElement.find('.ef-toolbar ul li a').click(function(e) {
                e.preventDefault();
                // Save selection when focus is out.
                range = helpers.saveSelection();

                let code = $(this).data('ef-code');
                switch(code) {
                    case 'bold':
                        components._addEventEditionButton('fontWeight', 'bold');
                        break;
                    case 'italic':
                        components._addEventEditionButton('fontStyle', 'italic');
                        break;
                    case 'underline':
                        components._addEventEditionButton('textDecoration', 'underline');
                        break;
                    case 'export':
                        components._export(efContent, htmlView);
                        break;
                    case 'url':
                        components._url();
                        break;
                    case 'image':
                        components._image();
                        break;
                    case 'video':
                        components._video();
                        break;
                    case 'code':
                        components._code();
                        break;
                    case 'fullscreen':
                        components._fullScreen();
                        break;
                    case 'leftAlign':
                        components._textAlign('left');
                        break;
                    case 'rightAlign':
                        components._textAlign('right');
                        break;
                    case 'centerAlign':
                        components._textAlign('center');
                        break;
                }
            });

            // Past as Plain Text
            efContent.on('paste', function (e) {
                e.preventDefault();

                // Get the copied text from the clipboard
                const text = e.clipboardData
                    ? (e.originalEvent || e).clipboardData.getData('text/plain')
                    : // For IE
                    window.clipboardData
                        ? window.clipboardData.getData('Text')
                        : '';

                navigator.clipboard.readText().then(
                    (clipText) => {
                        if (document.queryCommandSupported('insertText')) {
                            document.execCommand('insertText', false, clipText);
                        } else {
                            // Insert text at the current position of caret
                            const range = document.getSelection().getRangeAt(0);
                            range.deleteContents();

                            const textNode = document.createTextNode(clipText);
                            range.insertNode(textNode);
                            range.selectNodeContents(textNode);
                            range.collapse(false);

                            const selection = window.getSelection();
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                    }
                );
            });
        });
    }

})(jQuery);