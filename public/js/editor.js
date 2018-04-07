$(function () {
    function applyEditor(element) {
        return CodeMirror.fromTextArea(element, {
            lineNumbers: true,
            lineWrapping: true,
            extraKeys: {
                "Ctrl-Q": function (cm) {
                    cm.foldCode(cm.getCursor());
                }
            },
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
        })
    }

    $('textarea.script').each(function () {
        window.scriptEditor = applyEditor(this);
    });
    $('#input').each(function () {
        window.inputEditor = applyEditor(this);
    });

    $('#evaluate').click(function (e) {
        e.preventDefault();
        debugger;
        var input = inputEditor.getValue(),
            scripts = [scriptEditor.getValue()];

        scripts.reduce(function (val, script) {
            var fn = new Function('input', script);
            val = Promise.resolve(val);
            return val.then(fn);
        }, input).then(function (output) {
            $('#output').html(output);
        });
    });
});