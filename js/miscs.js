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