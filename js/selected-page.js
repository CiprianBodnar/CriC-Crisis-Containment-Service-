function selected(){
    
    var body = document.getElementsByTagName("body")[0];
    var pageId = body.getAttribute("id");
    document.querySelector("li#" +pageId).classList.add("selected");
}

selected();