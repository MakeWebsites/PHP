jQuery(document).ready(function() {
	var $j = jQuery.noConflict();
/*Change of styles
$("nav").css({'background-color' : '#f5f5f5'});
$(".module-group.right").append('<span style="float:right"><a href="https://climarisk.com/" title="ClimaRisk in English">EN <img style="vertical-align:baseline" src="https://climarisk.com/images/gb.png"></a></span>');
$("#social").css("background-color", "#0e1015");
$('.shapely-social-links').css('margin-top', '-30%');
$(".page-title").css({'font-weight' : 'bold',  'text-align' : 'left' });*/

$j('#reply-title').html('<div class="divider"></div>Dejar una respuesta '); 
$j("label[for='comment']").text("Comentario*");
$j("label[for='author']").text("Nombre*");
$j("label[for='wp-comment-cookies-consent']").text("Guardar mi nombre, email y sitio web para la próxima vez que haga un comentario aquí");
$j('input[name="submit"]').val("Enviar");
$j('.page-header h2').text("Memorias:");
$j('.framed-box a').css('color','#00FFFF');
//$j('.attachment-full').css('width','300px');
$j('.framed-box a').hover(function() { $j(this).css("color", "yellow"); }, function() { $j(this).css("color", "#00FFFF")}); 
$j('#us_b_search input').attr("placeholder", "Buscar...");
//$j('.us_b_archive_post').prepend('<img class="img-fluid float-left pr-2 align-bottom" src="https://memoriasdecuba.blog/wp-content/uploads/2020/03/memorias-de-cuba-icon.png" style="width:5%">');
$j('.navbar-brand').append('<a href="https://memoriasdecuba.blog/"><img class="img-fluid pl-2" src="https://memoriasdecuba.blog/wp-content/uploads/2020/04/memorias-de-cuba-icon.png"  style="height: 45px;"></a>');
$j("img").hover(function () { $j(this).animate({ opacity: 0.7 }, "fast"); }, function () {$j(this).animate({ opacity: 1.0 }, "fast"); } );
//$j('.site-main').css('margin-top', '70px');
$j('.wrapper').css('padding', 0);
$j('#wrapper-footer').prepend('<div class="jumbotron"><h1>Bootstrap Tutorial</h1><p>Bootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile-first projects on the web.</p></div>');
})