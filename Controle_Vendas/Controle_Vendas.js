function verifcar(idCheckbox, idQuantidade){
    const checkbox = document.getElementById(idCheckbox);
    const campoQuantidadde = document.getElementById(idQuantidade);

    if(checkbox.checked) {
        campoQuantidade.disabled = false;
        campoQuantidade.value = 1;
    }
    else{
        campoQuantidade.disabled = true;
        campoQuantidade.value = "";
    }
}

function 