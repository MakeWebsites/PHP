jQuery(document).ready(function($) {
var pcase = $('#pcase').val();
	/*var price;
		switch (pcase) {
			case '450': price = 450; break;
			case '390': price = 390; break; }*/

		
$( "#ini-mp" ).html( "Basic price: &pound;" + pcase ); 
	
$('.fms').on('submit', function(e) {
		e.preventDefault();
$( "#ini-cp" ).html('Calculating...');
 
		var $form = $(this);
 
		$.post($form.attr('action'), $form.serialize(), function(response) {
			
			var data = JSON.parse(response);
				if (data['error'] == false) {
					var price = data['price'];
					if (price > data['pcase'])
						$( "#ini-cp" ).html( "Current price: &pound;<mark>" + price + "</mark>"); 
					else
						$( "#ini-cp" ).html( "" );}
			else
			$( "#ini-cp" ).html( "<img src='../../images/error.gif'>" + data['error_message']);
		}, 'json');
	});
 
});