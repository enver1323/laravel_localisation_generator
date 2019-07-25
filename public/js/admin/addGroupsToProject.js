var form = document.forms['projectForm'];
var translations = document.getElementsByClassName('groupId');

function selectAll(state) {
    for (var key in translations)
        translations[key].checked = state;
}

function submitForm() {
    for (var key in translations){
        if(translations[key].checked && createInput(translations[key].value) !== undefined)
            form.appendChild(createInput(translations[key].value));
    }

    form.submit();
}

function createInput(data) {
    if(data === undefined)
        return;

    var input = document.createElement('input');
    input.setAttribute('name', 'groups[]');
    input.setAttribute('value', data);
    input.setAttribute('hidden', '');

    return input;
}
