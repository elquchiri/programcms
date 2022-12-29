/**
 * Copyright © ElectroForums, Inc. All rights reserved.
 * See LICENSE for license details.
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
                e.preventDefault();

                let urlTitle = $('input[name=url_title]').val();
                let url = $('input[name=url]').val();

                var a = document.createElement("a");
                a.href = url;
                a.innerText = urlTitle;

                range.insertNode(a);

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

                range.insertNode(div);

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
            $('.ef-forum-view').slideUp('fast');

            $('.ef-post-title input')
                .css({paddingTop: '11px'})
                .animate({
                    paddingBottom: '11px'
                }, 500);
        }
    };

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
                    var a = document.createElement('a');
                    a.setAttribute('href', '#');
                    a.setAttribute('data-ef-code', settings.components[componentGroup][component]);
                    var img = document.createElement('img');
                    img.src = window.location.origin + '/efEditor/images/' + settings.components[componentGroup][component] + '.png';

                    a.appendChild(img);
                    li.appendChild(a);
                    ul.appendChild(li);
                }

                editorToolbarElement.appendChild(ul);
            }

            efEditorElement.append($(editorToolbarElement));
            efEditorElement.append($(efContent));
            efEditorElement.append($(htmlView));

            efContent = $(efContent);
            htmlView = $(htmlView);

            efContent.focusout(function() {
                var element = $(this);
                if (!element.text().replace(" ", "").length) {
                    element.empty();
                }

                range = window.getSelection().getRangeAt(0);

            });

            efEditorElement.find('.ef-toolbar ul li a').click(function(e) {
                e.preventDefault();

                var code = $(this).data('ef-code');
                switch(code) {
                    case 'bold':
                        components._addEventEditionButton('fontWeight', 'bold');
                        break;
                    case 'italic':
                        components._addEventEditionButton('fontStyle', 'italic');
                        break;
                    case 'underline':
                        components._addEventEditionButton('fontStyle', 'underline');
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


// function getCaretIndex() {
//     var element = efContent[0];
//     let position = 0;
//     const isSupported = typeof window.getSelection !== "undefined";
//     if (isSupported) {
//         const selection = window.getSelection();
//         if (selection.rangeCount !== 0) {
//             const range = window.getSelection().getRangeAt(0);
//             const preCaretRange = range.cloneRange();
//             preCaretRange.selectNodeContents(element);
//             preCaretRange.setEnd(range.endContainer, range.endOffset);
//             position = preCaretRange.toString().length;
//         }
//     }
//     return position;
// }

// function getCaretPosition() {
//     if (window.getSelection && window.getSelection().getRangeAt) {
//         var range = window.getSelection().getRangeAt(0);
//         var selectedObj = window.getSelection();
//         var rangeCount = 0;
//         var childNodes = selectedObj.anchorNode.parentNode.childNodes;
//         for (var i = 0; i < childNodes.length; i++) {
//             if (childNodes[i] == selectedObj.anchorNode) {
//                 break;
//             }
//             if (childNodes[i].outerHTML)
//                 rangeCount += childNodes[i].outerHTML.length;
//             else if (childNodes[i].nodeType == 3) {
//                 rangeCount += childNodes[i].textContent.length;
//             }
//         }
//         console.log(range.startOffset + rangeCount);
//         return range.startOffset + rangeCount;
//     }
//     return -1;
// }