<?php
/*
Plugin Name: Extended-CR_es
Description: Extensions to ClimaRisk Genesis sites
Version: 1.0
Author: Angel Utset
License: GPLv2
*/

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'cr_load_google_fonts' );
function cr_load_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}


//* Customize the Genesis credits
add_filter( 'genesis_footer_creds_text', 'cr_footer_creds_text' );
function cr_footer_creds_text() {
	echo '<div class="creds" style="margin-top:-2%;float:left">';
	
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://climarisk.com" title="Estimación, análisis y gestión de riesgos climáticos">ClimaRisk</a>';
	echo '</div>';
	echo '<img src="'.site_url().'/wp-content/uploads/2016/08/climarisk-logo-texto-h3.gif" width="15%" style="float:left;margin-top:-1%;margin-left:0%" alt="Gestión de riesgos climáticos" 
	title="Gestión de riesgos climáticos">';
}

/** Load custom favicon to header 

add_filter( 'genesis_pre_load_favicon', 'custom_favicon_filter' );

function custom_favicon_filter( $favicon_url ) {

return get_stylesheet_directory_uri().'/images/mw_favicon.png';

}*/

function cr_login_logo() { // Customize login logo ?> 
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/climarisk-logo.gif);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'cr_login_logo' );

function cr_login_logo_url_title() {
    return 'ClimaRisk - Entrada al Backend del sitio';
}
add_filter( 'login_headertitle', 'cr_login_logo_url_title' );

function cr_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'cr_login_logo_url' );


// HTML5
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'mwe_breadcrumb_args' );
function mwe_breadcrumb_args( $args ) {
	$args['home'] = 'Inicio';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = 'Est&aacute; aqu&iacute;: ';
	$args['labels']['author'] = 'Archivos de ';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = 'Archivos de  ';
	$args['labels']['date'] = 'Archivos de  ';
	$args['labels']['search'] = 'B&uacute;squeda para ';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'No se encuentra: '; // Genesis 1.5 and later
return $args;
}

add_action( 'get_header', 'remove_titles_from_pages' );
function remove_titles_from_pages() {
    if ( is_page(array(Inicio, Contacto) ) ) {
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'cr_post_meta_filter' );
function cr_post_meta_filter($post_meta) {
if ( !is_page() ) {
	$post_meta = '[post_categories before="Archivado en: "] [post_tags before="Etiquetado en: "]';
	return $post_meta;
}}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'cr_excerpt_length' );
function cr_excerpt_length( $length ) {
	return 15; // pull first 15 words
}

/*add_filter( 'genesis_post_info', 'cr_post_info_filter' );
function cr_post_info_filter($post_info) {
	$post_info = '[post_categories sep=", " before="Archivado en: "]<span style="float:right;padding-right:1%"><a class="button" href="'.site_url().'" style="padding-left,padding-right:10%;padding-bottom:0%;padding-top:0%">Inicio</a></span>';
	return $post_info;
}

//* Customize the entry meta in the entry footer (requires HTML5 theme support)
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
	$post_meta = '[post_tags sep=", " before="Etiquetas: "]';
	return $post_meta;
}*/

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'cr_read_more_link' );
function cr_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">[Continuar leyendo...]</a>';
}

// Para usar shortcodes en descripciones de categoria y en widgets
//add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'genesis_term_intro_text_output', 'do_shortcode' );


add_action( 'pre_get_posts', 'prefix_reverse_post_order' );
function prefix_reverse_post_order( $query ) {
	// Only change the query for post archives.
	if ( $query->is_main_query() && is_archive() && ! is_post_type_archive() ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'ASC' );
	}
}

// Enable PHP in widgets
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'cr_next_page_link' );
function cr_next_page_link ( $text ) {
    return 'Siguiente &#x000BB;';
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'cr_previous_page_link' );
function cr_previous_page_link ( $text ) {
    return '&#x000AB; Anterior';
}


function cr_custom_tag_cloud_widget($args) {
	$args['number'] = 20; //adding a 0 will display all tags
	$args['largest'] = 150; //largest tag
	$args['smallest'] = 120; //smallest tag
	$args['unit'] = '%'; //tag font unit
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'cr_custom_tag_cloud_widget' );

//* Customize search form input box text
add_filter( 'genesis_search_text', 'cr_search_text' );
function cr_search_text( $text ) {
	return esc_attr( 'Buscar en ClimaRisk...' );
}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Customize the author box title
add_filter( 'genesis_author_box_title', 'custom_author_box_title' );
function custom_author_box_title() {
	//return '<strong>Sobre el autor:</strong>';
	$linea = do_shortcode('[post_author_link before="Autor: <em>" after="</em></br>"]');
	//$linea .= do_shortcode('[post_author_posts_link before = "</br>Otras contribuciones de " after=" en ClimaRisk"]');
	return $linea;
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'cr_author_box_gravatar_size' );
function cr_author_box_gravatar_size( $size ) {
	return '80';
}



?>