$(function($) {

    // This is the DOM representation for all elements inside Editor
    var editorTree = {
        'body': {

        }
    };

    // Save last cursor position when focusing out
    var cursorPosition = 0;

    let htmlView = $('.html-view');
    let efContent = $('.ef-content');

    // Used to switch between Editor / HTML-code View
    var currentViewMode = 0;

    $(".ef-content").focusout(function() {
        var element = $(this);
        if (!element.text().replace(" ", "").length) {
            element.empty();
        }

        cursorPosition = getCaretPosition();
    });

    $('#url-form').submit(function(e) {
        e.preventDefault();

        let urlTitle = $('input[name=url_title]').val();
        let url = $('input[name=url]').val();

        var content = efContent.html();
        var beforeLink = content.slice(0, cursorPosition);
        var afterLink = content.slice(cursorPosition, content.length);

        var a = document.createElement("a");
        a.href = url;
        a.innerText = urlTitle;

        let newContent = beforeLink + a.outerHTML + afterLink;
        efContent.html(newContent);

        $('.modal').modal('hide');
    });

    $('.ef-editor .ef-toolbar ul li a').click(function(e) {
        e.preventDefault();

        var code = $(this).data('ef-code');
        switch(code) {
            case 'bold':
                addEventEditionButton('fontWeight', 'bold');
                break;
            case 'italic':
                addEventEditionButton('fontStyle', 'italic');
                break;
            case 'underline':
                addEventEditionButton('fontStyle', 'underline');
                break;
            case 'code':
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
                break;
            case 'url':
                $('.modal').modal('show');
                break;
        }
    });

    /**
     *
     * @param cssProperty
     * @param cssPropertieValy
     */
    function addEventEditionButton(cssProperty, cssPropertieValy) {
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
    }

    function getCaretCharacterOffsetWithin() {
        let element = efContent[0];
        var caretOffset = 0;
        var doc = element.ownerDocument || element.document;
        var win = doc.defaultView || doc.parentWindow;
        var sel;
        if (typeof win.getSelection != "undefined") {
            sel = win.getSelection();
            if (sel.rangeCount > 0) {
                var range = win.getSelection().getRangeAt(0);
                var preCaretRange = range.cloneRange();
                preCaretRange.selectNodeContents(element);
                preCaretRange.setEnd(range.endContainer, range.endOffset);
                caretOffset = preCaretRange.toString().length;
            }
        } else if ((sel = doc.selection) && sel.type != "Control") {
            var textRange = sel.createRange();
            var preCaretTextRange = doc.body.createTextRange();
            preCaretTextRange.moveToElementText(element);
            preCaretTextRange.setEndPoint("EndToEnd", textRange);
            caretOffset = preCaretTextRange.text.length;
        }

        return caretOffset;
    }

    function getCaretIndex() {
        var element = efContent[0];
        let position = 0;
        const isSupported = typeof window.getSelection !== "undefined";
        if (isSupported) {
            const selection = window.getSelection();
            if (selection.rangeCount !== 0) {
                const range = window.getSelection().getRangeAt(0);
                const preCaretRange = range.cloneRange();
                preCaretRange.selectNodeContents(element);
                preCaretRange.setEnd(range.endContainer, range.endOffset);
                position = preCaretRange.toString().length;
            }
        }
        return position;
    }

    function getCaretPosition() {
        if (window.getSelection && window.getSelection().getRangeAt) {
            var range = window.getSelection().getRangeAt(0);
            var selectedObj = window.getSelection();
            var rangeCount = 0;
            var childNodes = selectedObj.anchorNode.parentNode.childNodes;
            for (var i = 0; i < childNodes.length; i++) {
                if (childNodes[i] == selectedObj.anchorNode) {
                    break;
                }
                if (childNodes[i].outerHTML)
                    rangeCount += childNodes[i].outerHTML.length;
                else if (childNodes[i].nodeType == 3) {
                    rangeCount += childNodes[i].textContent.length;
                }
            }
            console.log(range.startOffset);
            return range.startOffset + rangeCount;
        }
        return -1;
    }
});