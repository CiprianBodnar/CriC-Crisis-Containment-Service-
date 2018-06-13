function addErrorMessage(idRow,type){
    if(document.getElementById(idRow+"-error")){
        return;
    }
    let newDiv = document.createElement("div");
    newDiv.classList.add("error");
    newDiv.setAttribute("id",idRow+"-error");
    let text = document.createTextNode(type);
    newDiv.appendChild(text);
    let container = document.getElementById(idRow);
    container.appendChild(newDiv);
    container.classList.add("has-error");
}

function removeErrorMessage(idRow){
    
    if(document.getElementById(idRow+"-error")){
        var node = document.getElementById(idRow);
        node.removeChild(node.lastChild);
        node.classList.remove("has-error");
    }
}
