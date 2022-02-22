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