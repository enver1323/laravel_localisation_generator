var form = document.getElementById('transForm');
var select = document.getElementById('transLangs');
var selectContainer = document.getElementById('selectContainer');

function addEntry() {
    var option = select.options[select.selectedIndex];
    document.getElementById('entriesHeader').setAttribute('class', 'row mb-4');


    if(isEntryNotCreated(option))
        addEntryField(option);
}

function isEntryNotCreated(option){
    var list = document.getElementsByClassName('entryInput');
    for(var i = 0; i < list.length; i++){
        if(list[i].name.split('[')[1] === (option.value + ']')){
            select.removeChild(option);
            return false;
        }
    }

    return true;
}

function addEntryField(option){
    var row = document.createElement('div');
    setAttributes(row, {'class' : 'row mb-4',});

    var col = document.createElement('div');
    setAttributes(col, {'class' : 'col-md-3 col-lg-2',});
    row.appendChild(col);

    var label = document.createElement('label');
    setAttributes(label, {'for' : "transEntry" + option.innerHTML});
    label.innerHTML = option.innerHTML + " language entry";
    col.appendChild(label);

    col = document.createElement('div');
    setAttributes(col, {'class' : 'col-md-9 col-lg-10',});
    row.appendChild(col);

    var input = document.createElement('input');
    setAttributes(input, {
        'class' : 'form-control col-md-8 col-lg-6 entryInput',
        'id' : "transEntry" + option.innerHTML,
        'type' : 'text',
        'name' : 'entries[' + option.value + ']',
        'required' : ''
    });
    col.appendChild(input);

    form.appendChild(row);
    form.insertBefore(row, selectContainer);

    select.removeChild(option);
}

function setAttributes(elem, attrs){
    for (var key in attrs){
        elem.setAttribute(key, attrs[key]);
    }
}
