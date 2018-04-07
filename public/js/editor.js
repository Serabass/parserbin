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

    $('textarea.script').each(function () {
        window.scriptEditor = applyEditor(this);
    });

    $('#evaluate').click(function (e) {
        e.preventDefault();
        var input = $('#input').html(),
            scripts = [scriptEditor.getValue()];

        scripts.reduce(function (val, script) {
            var fn = new Function('input', script);
            val = Promise.resolve(val);
            return val.then(fn);
        }, input).then(function (output) {
            $('#output').html(output);
        });
    });

    $('#toggle-code').click(function () {
        $('.full-height').toggleClass('nocode');
    });

    $('#save').click(function () {
        var $saveform = $('#saveform');
        var input = $('#input').html();
        var script = scriptEditor.getValue();
        var name = $('#parser-name').val();
        var json = JSON.stringify({
            input: input,
            script: script,
            name: name
        });
        $saveform.find('[name="data"]').val(json);
        $saveform.submit();
    });
});