
function enlarge(){
    var contaier = document.getElementById("enlarge");
    var windowH = window.innerHeight;
    var bodyH = document.getElementsByTagName("body")[0].clientHeight;
    if(windowH-bodyH>0){
        contaier.setAttribute("style","padding-bottom:"+(windowH-bodyH+30)+"px");
    }
}
enlarge();
