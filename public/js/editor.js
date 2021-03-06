$(function () {

    function detectHash() {
        var regex = /^#(.+?)$/,
            match;
        if (location.pathname === '/') {
            if (match = location.hash.match(regex)) {
                var str = match[1];
                var data = decodeURI(str);
                $('#input').data('editor').setValue(data);
                location.hash = '';
                evalScript();
            }
        }
    }

    function getParserHash() {
        return $('meta[name=parser-hash]').attr('content');
    }

    function applyEditor(element) {
        var mode = $(element).data('mode');
        return CodeMirror.fromTextArea(element, {
            lineNumbers: true,
            lineWrapping: true,
            mode: mode,
            extraKeys: {
                "Ctrl-Q": function (cm) {
                    cm.foldCode(cm.getCursor());
                }
            },
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
        });
    }

    function evalScript() {
        var execTimeSpan = $('#execTime');
        var startTime = Date.now();
        var scriptElements = $('.codemirror.script');
        var input = $('#input').data('editor').getValue(),
            scripts = scriptElements.map(function () {
                return $(this).data('editor').getValue();
            }).toArray();

        scripts.reduce(function (val, script) {
            var fn = new Function('input', script);
            val = Promise.resolve(val);
            return val.then(fn);
        }, input).then(function (output) {
            var result;
            switch (typeof output) {
                case 'number':
                case 'string':
                    result = output;
                    break;
                default:
                    result = JSON.stringify(output, null, 4);
            }
            $('#output').data('editor').setValue(result);
        });
        var execTime = Date.now() - startTime;

        if (execTime < 1) {
            execTime = '<1';
        }

        execTimeSpan.text(execTime + 'ms');
    }

    $('textarea.codemirror').each(function () {
        var editor = applyEditor(this);
        editor.on("change", _.debounce(function () {
            if (!$('#auto-update').prop('checked'))
                return;

            evalScript();
        }, 500));
        $(this).data('editor', editor);
    });

    $('#evaluate').click(function (e) {
        e.preventDefault();
        evalScript();
    });

    $('#toggle-code').click(function () {
        $('.full-height').toggleClass('nocode');
    });

    $('#auto-update').change(function () {
        if (this.checked) {
            evalScript();
        }
    });

    $('#input').on("keyup", _.debounce(function () {
        if (!$('#auto-update').prop('checked'))
            return;

        evalScript();
    }, 500));

    $('#new').click(function () {
        location.href = '/';
    });

    $('#fork').click(function () {
        location.href = '/fork/~' + getParserHash();
    });

    $('#embed-code input').focus(function () {
        this.select();
    });

    $('#save').click(function () {
        var $saveform = $('#saveform'),
            input = $('#input').data('editor').getValue(),
            script = $('.codemirror.script').data('editor').getValue(),
            title = $('#parser-title').val(),
            hash = getParserHash(),
            data = {
                input: input,
                script: script,
                title: title
            };
        if (hash) {
            data.hash = hash;
        }
        var json = JSON.stringify(data);
        $saveform.find('[name="data"]').val(json);
        $saveform.submit();
    });

    $('#logout').click(function (e) {
        e.preventDefault();
        $('#logout-form').submit();
    });

    $('#bookmarklet')
        .click(function (e) {
            e.preventDefault();
            alert('Save this link as bookmarklet in your browser (just drag to the toolbar) ' +
                'for creating parsers on-the-fly with selected text of any page');
        })
        .mousedown(function () {
            this.innerHTML = 'Parse it!'
        })
        .mouseup(function () {
            this.innerHTML = 'Save bookmarklet'
        });

    detectHash();

});