navigator.sayswho= (function(){
    var ua= navigator.userAgent, tem, 
    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();
let browser = navigator.sayswho.split(' ')[0].toLowerCase();
document.getElementsByTagName('body')[0].classList.add(browser);

document.getElementById('nav-trigger').addEventListener("click", function(){
	document.getElementById('nav-menu').classList.toggle('visible');
	document.getElementById('nav-trigger').classList.toggle('triggered');
});

if(document.getElementsByClassName('hasSub')[0]){
	var subNav = document.getElementsByClassName('sub-nav')[0];
	var trigger = document.querySelector('li.hasSub span');
	trigger.addEventListener('click', function(){
		this.parentNode.classList.toggle('expanded');
		subNav.classList.toggle('visible');
	});

}

if(document.getElementById('current-date')){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth(); //January is 0!
	var yyyy = today.getFullYear();

	if(dd<10) {
	    dd = '0'+dd
	} 

	var months = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Nov',];
	today = dd + '-' +months[mm]+'-' + yyyy;
document.getElementById('current-date').innerHTML=today;
}