var months = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var DEFAULT_MIN = 0;
var DEFAULT_MAX = 60;
var START_MIN = 30;
var START_MAX = 60;
var currentDate = new Date();
var maxDate = new Date(currentDate.getFullYear(), (currentDate.getMonth()+1)%12, 1);
maxDate = new Date(maxDate -1);
var constDate = [(maxDate.getFullYear()-(DEFAULT_MAX/12)),(maxDate.getMonth()-(DEFAULT_MAX%12))];
var minDate = new Date(constDate[0],constDate[1]);	

function convert  (min, max) {
	minDate.setFullYear(constDate[0]+min/12);
	minDate.setMonth(constDate[1]+min%12);

  let aux = new Date(constDate[0]+max/12, constDate[1]+max%12+1, 1);
  maxDate = new Date(aux-1);
}

console.log(minDate.getMonth()+' '+minDate.getFullYear());

function getVals(){
  	// Get slider values
  	var parent = this.parentNode.parentNode;
  	var slides = parent.getElementsByTagName("input");
    var slide1 = parseFloat( slides[0].value );
    var slide2 = parseFloat( slides[1].value );
    console.log(minDate.getMonth()+' '+minDate.getFullYear()+'da');
  	// Neither slider will clip the other, so make sure we determine which is larger
  	if( slide1 > slide2 ){
      var tmp = slide2; 
      slide2 = slide1; 
      slide1 = tmp;
    }
  	var bounds = this.getBoundingClientRect();
  	var startPos = Math.floor(bounds.width/DEFAULT_MAX*slide1+3);
  	var width = Math.floor(bounds.width/DEFAULT_MAX*slide2 - startPos);
  	var pretty = parent.getElementsByClassName('pretty')[0];
  	pretty.style.left = startPos+'px';
  	pretty.style.width=width+'px';
  	var displayElement = parent.getElementsByClassName("amount")[0];
  	convert(slide1, slide2);
    eventManager.loadEvents(minDate, maxDate, {animation: false});
    
    displayElement.innerHTML=(months[minDate.getMonth()])+' '+minDate.getFullYear() + " - " +(months[maxDate.getMonth()]) +' '+maxDate.getFullYear();
    console.log(minDate.getMonth()+' '+minDate.getFullYear());
}

window.onload = function(){
  // Initialize Sliders
  var sliderSections = document.getElementsByClassName("slider-range");
      for( var x = 0; x < sliderSections.length; x++ ){
        var sliders = sliderSections[x].getElementsByTagName("input");
        for( var y = 0; y < sliders.length; y++ ){
          if( sliders[y].type ==="range" ){
            sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
          }
        }
      }
}
