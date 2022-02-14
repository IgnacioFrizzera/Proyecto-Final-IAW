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