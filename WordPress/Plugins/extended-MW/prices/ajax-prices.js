jQuery(document).ready(function($) {
var pcase = $('#pcase').val();
	var price;
		switch (pcase) {
			case 'ml': case 'wp': price = 450; break;
			case 'seo': price = 390; break; }

		
$( "#ini-mp" ).html( "Basic price: &pound;" + price ); 
	
$('.fms').on('submit', function(e) {
		e.preventDefault();
$( "#ini-cp" ).html('Calculating...');
 
		var $form = $(this);
 
		$.post($form.attr('action'), $form.serialize(), function(response) {
			
			var data = JSON.parse(response);
				if (data['error'] == false) {
					$( "#ini-cp" ).html( "Current price: &pound;<mark>" + data['price'] + "</mark>"); }
			else
			alert(data['error_message'])
		}, 'json');
	});
 
});