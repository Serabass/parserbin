$(function () {
    function applyEditor(element) {
        var mode = $(element).data('mode');
        return CodeMirror.fromTextArea(element, {
            lineNumbers: true,
            lineWrapping: true,
            mode:  mode,
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

        execTimeSpan.text('[Last execution time:' + execTime + 'ms]');
    }

    $('textarea.codemirror').each(function () {
        var editor = applyEditor(this);
        editor.on("change", _.debounce(function() {
            if ( ! $('#auto-update').prop('checked'))
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

    $('#input').on("keyup", _.debounce(function() {
        if ( ! $('#auto-update').prop('checked'))
            return;

        evalScript();
    }, 500));

    $('#new').click(function () {
        location.href = '/';
    });

    $('#save').click(function () {
        var $saveform = $('#saveform');
        var input = $('#input').data('editor').getValue();
        var script = $('.codemirror.script').data('editor').getValue();
        var title = $('#parser-title').val();
        var json = JSON.stringify({
            input: input,
            script: script,
            title: title
        });
        $saveform.find('[name="data"]').val(json);
        $saveform.submit();
    });

    $('#logout').click(function (e) {
        e.preventDefault();
        $('#logout-form').submit();
    });
});