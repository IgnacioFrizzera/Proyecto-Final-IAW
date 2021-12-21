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
    if (valueType == "FACTURA") {
        setBackgroundAndDisable(paid, due);
    }
    else {
        setBackgroundAndDisable(due, paid);
    }
}