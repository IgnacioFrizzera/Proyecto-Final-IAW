var categoryItemsHTML = null;
var categoryItemsIndex = 1;

var brandItemsHTML = null;
var brandItemsIndex = 1;

var sizeItemsHTML = null;
var sizeItemsIndex = 1;

function setBackgroundAndDisable(disableElement, enableElement) {
    disableElement.readOnly = true;
    disableElement.style.backgroundColor = "#566573";
    disableElement.value = 0;
    enableElement.readOnly = false;
    enableElement.style.backgroundColor = "white";
}

function disabledOnReceiptType(valueType) {
    const paid = document.getElementById("paid_input");
    const due = document.getElementById("due_input");
    if (valueType == "FC" || valueType == "FCC") {
        setBackgroundAndDisable(paid, due);
        if (valueType == "FC") {
            document.getElementById("payment_type").disabled = false;
        }
        else {
            document.getElementById("payment_type").disabled = true;
        }
    }
    else {
        document.getElementById("payment_type").disabled = true;
        setBackgroundAndDisable(due, paid);
    }
}

function disableClientCreationOnClientSelect(valueType) {
    const clientName = document.getElementById("client_name");
    const clientLastName = document.getElementById("client_last_name");
    if (valueType == "") {
        clientName.disabled = false;
        clientLastName.disabled = false;
    }
    else {
        clientName.disabled = true;
        clientLastName.disabled = true;
    }
}

function disableClientSelectionOnClientCreation() {
    const clientName = document.getElementById("client_name");
    const clientLastName = document.getElementById("client_last_name");
    const clientSelect = document.getElementById("client_id");

    if (clientName.value == "" & clientLastName.value == "") {
        clientSelect.disabled = false;
    }
    else {
        clientSelect.disabled = true;
    }
}

function createItemsHTML(items) {
    var html = '';
    for (let item of items) {
        html += `<option value="` + item.id + '">';
        html += item.name;
        html += '</option>';
    }
    return html;
}

function createSelect(nameAndId, itemsHTML) {
    var html = `<select class="form-select" aria-label="Default select example" name="` + nameAndId + '" id="' + nameAndId  + '">';
    html += itemsHTML + '</select>';
    return html
}

function createCategoryHTML() {
    if (categoryItemsHTML == null) {
        categoryItemsHTML = createItemsHTML(ChartNamespace.categories);
    }
    nameAndId = "category" + categoryItemsIndex.toString();
    categoryItemsIndex += 1;
    return createSelect(nameAndId, categoryItemsHTML);
}

function createBrandHTML() {
    if (brandItemsHTML == null) {
        brandItemsHTML = createItemsHTML(ChartNamespace.brands);
    }
    nameAndId = "brand" + brandItemsIndex.toString();
    brandItemsIndex += 1;
    return createSelect(nameAndId, brandItemsHTML);
}

function createSizeHTML() {
    if (sizeItemsHTML == null) {
        sizeItemsHTML = createItemsHTML(ChartNamespace.sizes);
    }
    nameAndId = "size" + sizeItemsIndex.toString();
    sizeItemsIndex += 1;
    return createSelect(nameAndId, sizeItemsHTML);
}

function deleteItemsTableRow(index) {
    document.getElementById("items_table").deleteRow(index);
    if (index - 1 == 1) {
        document.getElementById("delete_labels").innerHTML = "";
    }
}

function appendNewItem() {
    document.getElementById("delete_labels").innerHTML = "Eliminar";

    const itemsTable = document.getElementById("items_table");
    const newRow = itemsTable.insertRow();

    const categoryCell = newRow.insertCell();
    categoryCell.innerHTML = createCategoryHTML();
    
    const brandCell = newRow.insertCell();
    brandCell.innerHTML = createBrandHTML();
    
    const sizeCell = newRow.insertCell();
    sizeCell.innerHTML = createSizeHTML();
    
    const deleteButton = newRow.insertCell();
    deleteButton.innerHTML = '<button type="button" title="Eliminar item" onclick="deleteItemsTableRow('+newRow.rowIndex+')"><i class="fa fa-minus-circle" style="font-size:24px"></i></button>'
}