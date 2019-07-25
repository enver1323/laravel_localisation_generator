var form = document.forms['groupForm'];
var translations = document.getElementsByClassName('translationIds');

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
    input.setAttribute('name', 'translations[]');
    input.setAttribute('value', data);
    input.setAttribute('hidden', '');

    return input;
}
