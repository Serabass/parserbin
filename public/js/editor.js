$(function () {
    function applyEditor(element) {
        return CodeMirror.fromTextArea(element, {
            lineNumbers: true,
            lineWrapping: true,
            mode:  "javascript",
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
        var input = $('#input').text(),
            scripts = [scriptEditor.getValue()];

        scripts.reduce(function (val, script) {
            var fn = new Function('input', script);
            val = Promise.resolve(val);
            return val.then(fn);
        }, input).then(function (output) {
            $('#output').html(output);
        });
    }

    $('textarea.script').each(function () {
        window.scriptEditor = applyEditor(this);
        scriptEditor.on("change", _.debounce(function() {
            if ( ! $('#auto-update').prop('checked'))
                return;

            evalScript();
        }, 500));
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
        var input = $('#input').html();
        var script = scriptEditor.getValue();
        var title = $('#parser-title').val();
        var json = JSON.stringify({
            input: input,
            script: script,
            title: title
        });
        $saveform.find('[name="data"]').val(json);
        $saveform.submit();
    });
});