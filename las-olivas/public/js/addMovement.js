var categoryItemsHTML = null;
var brandItemsHTML = null;
var sizeItemsHTML = null;

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

function createCategoryHTML() {
    if (categoryItemsHTML == null) {
        console.log('Here');
        categoryItemsHTML = createItemsHTML(ChartNamespace.categories);
    }
    var categoryHTML = `<select class="form-select" aria-label="Default select example" name="category" id="category">`;
    categoryHTML += categoryItemsHTML + '</select>';
    return categoryHTML
}

function createBrandHTML() {
    if (brandItemsHTML == null) {
        brandItemsHTML = createItemsHTML(ChartNamespace.brands);
    }
    var brandHTML = `<select class="form-select" aria-label="Default select example" name="brand" id="brand">`;
    brandHTML += brandItemsHTML + '</select>';
    return brandHTML;
}

function createSizeHTML() {
    if (sizeItemsHTML == null) {
        sizeItemsHTML = createItemsHTML(ChartNamespace.sizes);
    }
    var sizeHTML = `<select class="form-select" aria-label="Default select example" name="size" id="size">`;
    sizeHTML += sizeItemsHTML + '</select>';
    return sizeHTML;
}

function appendNewItem() {
    const itemsTable = document.getElementById("items_table");
    const newRow = itemsTable.insertRow();

    const categoryCell = newRow.insertCell();
    categoryCell.innerHTML = createCategoryHTML();
    
    const brandCell = newRow.insertCell();
    brandCell.innerHTML = createBrandHTML();
    
    const sizeCell = newRow.insertCell();
    sizeCell.innerHTML = createSizeHTML();
    
    const deleteButton = newRow.insertCell();
    deleteButton.innerHTML = 'Delete';
}