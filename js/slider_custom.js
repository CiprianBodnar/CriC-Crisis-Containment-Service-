
var months = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var DEFAULT_MIN = 0;
var DEFAULT_MAX = 120;
var START_MIN = 75;
var START_MAX = 120;
var maxDate = new Date();
var constDate = [(maxDate.getFullYear()-120/12),(maxDate.getMonth()-120%12)];
var minDate = new Date(constDate[0],constDate[1]+START_MIN);	
$( "#slider-range" ).slider({
		range: true,
		min: DEFAULT_MIN,
		max: DEFAULT_MAX,
		values: [ 75, 120 ],
		slide: function( event, ui ) {
			convert(ui);
			$( "#amount" ).text( (months[minDate.getMonth()])+' '+minDate.getFullYear() + " - " +(months[maxDate.getMonth()]) +' '+maxDate.getFullYear());
			console.log($( "#amount" ));
			
		}
	
});

$( "#amount" ).text( (months[minDate.getMonth()])+' '+minDate.getFullYear() + " - " +(months[maxDate.getMonth()]) +' '+maxDate.getFullYear());


function convert  (ui) {
	minDate.setFullYear(constDate[0]+ui.values[0]/12);
	minDate.setMonth(constDate[1]+ui.values[0]%12);
	maxDate.setFullYear(constDate[0]+ui.values[1]/12);
	maxDate.setMonth(constDate[1]+ui.values[1]%12);
}


