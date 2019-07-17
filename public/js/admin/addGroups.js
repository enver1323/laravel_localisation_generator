CKEDITOR.replace('projectDesc');

var container = document.getElementById('groupsContainer');
var field = document.getElementById('searchField');

function getGroupNames(query) {
    if(query.length < 3)
        return;

    var xhr = new XMLHttpRequest();
    var link = window.location.origin + "/api/ajax/groups?name=" + query;

    xhr.open('GET', link);
    xhr.responseType = 'json';
    xhr.send();

    xhr.onload = function () {
        if (xhr.status == 200) {
            data = xhr.response;
            showResults(data.data);
        }
    };
}

function showResults(data) {
    for (var key in data) {
        if (keyNotExists(data[key])) {
            addEntry(data[key]);
        }
    }
}

function keyNotExists(item) {
    var list = document.getElementsByClassName('groupCheckbox');
    for (var key in list) {
        if (list[key].id === ("group-" + item.id))
            return false;
    }

    return true;
}

function addEntry(item){
    var box = document.createElement('div');
    setAttributes(box, {'class' : 'form-check'});

    var input = document.createElement('input');
    setAttributes(input, {
        'class' : 'form-check-input groupCheckbox',
        'id' : "group-" + item.id,
        'type' : 'checkbox',
        'onclick': 'removeItem(this)',
        'name' : 'groups[]',
        'value': item.id
    });
    box.appendChild(input);

    var label = document.createElement('label');
    setAttributes(label, {'for' : "group-" + item.id});
    label.innerHTML = "Group: " + item.name;
    box.appendChild(label);

    container.appendChild(box);
}

function setAttributes(elem, attrs){
    for (var key in attrs){
        elem.setAttribute(key, attrs[key]);
    }
}

function removeItem(item) {
    if(item.checked)
        item.checked = true;
    else
        container.removeChild(item.parentNode);
}
