var categoryItemsHTML = null;
var brandItemsHTML = null;
var sizeItemsHTML = null;

var totalItemsIndex = 1;

function markMovementAsPayment(event) {
    descriptionItem = document.getElementById("description");
    descriptionItem.disabled = !descriptionItem.disabled;
    if (event.target.checked) {
        descriptionItem.innerHTML = "ENTREGA";
    } else {
        descriptionItem.innerHTML = "";
    }
}

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
    due.value = 0;
    paid.value = 0;
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
    const clientBalanceHeader = document.getElementById("client_balance");

    if (valueType == "") {
        clientName.disabled = false;
        clientLastName.disabled = false;
        clientBalanceHeader.innerHTML = "";
    }
    else {
        clientName.disabled = true;
        clientLastName.disabled = true;
        const clientId = document.getElementById("client_id").value;
        for(let client of ChartNamespace.clients) {
            if (client.id == clientId) {
                clientBalanceHeader.innerHTML = "Saldo: $" + client.current_balance;
                break;
            }
        }
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
    nameAndId = "category" + totalItemsIndex.toString();
    return createSelect(nameAndId, categoryItemsHTML);
}

function createBrandHTML() {
    if (brandItemsHTML == null) {
        brandItemsHTML = createItemsHTML(ChartNamespace.brands);
    }
    nameAndId = "brand" + totalItemsIndex.toString();
    return createSelect(nameAndId, brandItemsHTML);
}

function createSizeHTML() {
    if (sizeItemsHTML == null) {
        sizeItemsHTML = createItemsHTML(ChartNamespace.sizes);
    }
    nameAndId = "size" + totalItemsIndex.toString();
    return createSelect(nameAndId, sizeItemsHTML);
}

function deleteItemsTableRow(index) {
    const itemsTable = document.getElementById("items_table");

    for (let i = 0; i < itemsTable.rows.length; i++) {
        if (itemsTable.rows[i].id == index) {
            itemsTable.deleteRow(i);
            break;
        }
    }

    recalculateSum();

    if (itemsTable.rows.length == 2) {
        document.getElementById("delete_labels").innerHTML = "";
    }
}

function recalculateSum() {
    var newSum = 0;
    for (let i = 0; i < totalItemsIndex + 1; i++) {
        let currentIndex = 'priceItem' + i.toString();
        let currentElement = document.getElementById(currentIndex);
        if (currentElement != null) {
            newSum += parseFloat(currentElement.value);
        }
    }
    const totalSumValueElement = document.getElementById("total_sum_value");
    totalSumValueElement.innerHTML = '$' + newSum;
}

function appendNewItem() {
    document.getElementById("delete_labels").innerHTML = "Eliminar";

    const itemsTable = document.getElementById("items_table");
    const newRow = itemsTable.insertRow();
    newRow.id = newRow.rowIndex;

    const categoryCell = newRow.insertCell();
    categoryCell.innerHTML = createCategoryHTML();
    
    const brandCell = newRow.insertCell();
    brandCell.innerHTML = createBrandHTML();
    
    const sizeCell = newRow.insertCell();
    sizeCell.innerHTML = createSizeHTML();
    
    const priceBox = newRow.insertCell();
    const priceNameAndId = 'priceItem' + newRow.rowIndex.toString();
    priceBox.innerHTML = '<input class="form-control"required type="number" name="'+priceNameAndId+'" id="'+priceNameAndId+'" onchange="recalculateSum()" step=".01" value="0" min="0" style="text-align:right;">';

    const deleteButton = newRow.insertCell();
    deleteButton.innerHTML = '<button type="button" title="Eliminar item" onclick="deleteItemsTableRow('+newRow.rowIndex+')"><i class="fa fa-minus-circle" style="font-size:24px"></i></button>';

    totalItemsIndex += 1;
}