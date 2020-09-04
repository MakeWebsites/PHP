<?php
/*
Plugin Name: Mdcuba-understrap
Description: Extensions to Understrap Builder WordPress theme (Español)
Version: 1.0
Author: Angel Utset
License: GPLv2
*/

//* Enqueue Lato Google font
/*add_action( 'wp_enqueue_scripts', 'cr_load_google_fonts' );
function cr_load_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}*/

//Registering bootstrap
function mdc_registers () {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('mdc-js', plugin_dir_url( __FILE__ ).'js/mdc.js');
		//wp_register_script('vue-js', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js');
}
add_action('wp_enqueue_scripts', 'mdc_registers');

//Change post orders to ascendent
//function to modify default WordPress query
function mdc_custom_query( $query ) {
 
// Make sure we only modify the main query on the homepage  
    if( /*$query->is_main_query() &&*/ ! is_admin() ) {
 
        // Set parameters to modify the query
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'ASC' );
		//$query->set( 'posts_per_page', 1 );
        $query->set( 'suppress_filters', 'true' );
		
    }
}
// Hook our custom query function to the pre_get_posts 
add_action( 'pre_get_posts', 'mdc_custom_query' );

//Adding to the content
function mdc_after_post_content($content){
if (is_single()) {  
$ppost = '';
$npost = '';
$post_tags = get_the_tags();
 
if ( $post_tags ) {
	$content .= '<b>Etiquetas:</b> <div class=".btn-group-justified" role="group" aria-label="Basic example">';
	$etiquetas = '';
    foreach( $post_tags as $tag ) {
		$tagn = $tag->name;
		//$etiquetas.= '<a class="btn btn-info btn-sm" href="'.get_tag_link( $tag ).'" title="Etiqueta: '.$tagn.'">'.$tagn.'</a>   ';
		$etiquetas.= '<button type="button" class="btn btn-outline-secondary btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Etiqueta: '.$tagn.'"><i>'.$tagn.'</i></button>';
    }
	$content .= $etiquetas.'</div><div class="divider"></div>';
}
// Next post
$next_post = get_next_post();
if (!empty($next_post)) {
    
	$npostt = get_the_title( $next_post->ID );
	$npostl = str_replace(' ', '-', get_permalink( $next_post->ID )); 
	$npost = '<a class="btn btn-primary btn-sm float-right" href="'.$npostl.'" title="'.$npostt.'">Siguiente entrada</a>';
}
//  Previous post 
$pre_post = get_previous_post();
if (!empty($pre_post)) {
    
	$ppostt = get_the_title( $pre_post->ID );
	$ppostl = str_replace(' ', '-', get_permalink( $pre_post->ID )); 
	$ppost = '<a class="btn btn-primary btn-sm" href="'.$ppostl.'" title="'.$ppostt.'">Entrada anterior</a>';
}


    $content .= '<div class="row"><div class="col-6">'.$ppost.'</div><div class="col-6">'.$npost.'</div></div>';
}
return $content; 
}
add_filter( "the_content", "mdc_after_post_content" ); 


//Change logo
function mdc_login_logo() { 
?> 
<style type="text/css"> 
body.login div#login h1 a {
 background-image: url(https://memoriasdecuba.blog/wp-content/uploads/2020/04/memorias-de-cuba-icon.png);  
padding-bottom: 30px; 
} 
</style>
 <?php 
} add_action( 'login_enqueue_scripts', 'mdc_login_logo' );

/*function mdc_blog_page_title() {
	// if the current entry's ID matches with that of the Posts page..
    if ( $id == $posts_page ) {
        // set your new title here.
		//if (has_post_thumbnail()) {
        $title = 'Memoria: '.the_title();
		//}
    }

    return $title;
}
add_filter( 'the_title', 'mdc_blog_page_title');*/
 

// Shortcodes

function mdc_divider() {
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'mdc_divider');

function c_bmodal ($attr, $content) {

$divm = $attr['divm']; //Name of the modal div - Compulsory
$hrefr = get_permalink()."#$divm";
$mtitle = $attr['mtitle']; // Modal title
//$content = esc_html($content);
$ppim = plugin_dir_url( __FILE__ ).'images/icon_info.gif';
	if (isset($attr['mtitle'])) {
$bmh = <<<bmht
<div class="modal-header btn-primary">
<h4 class="modal-title">$mtitle</h4>
<button class="close" aria-hidden="true" style="color:white" type="btn btn-lg btn-filled" data-dismiss="modal">×</button>
</div>
bmht;
	}
	else
$bmh = null;

if (isset($attr['divm'])) {
$bmd = <<<bdivm
<img class="align-top" data-toggle="modal" data-target="#$divm" src="$ppim" title="Click para mas informacion">
<div class="modal fade" id="$divm">
<div class="modal-dialog">
<div class="modal-content">
$bmh
<div class="modal-body text-justify">
$content
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
bdivm;
}
else
	$bmd = null;
return $bmd;

}

add_shortcode('bmodal', 'c_bmodal');


/// Includes additional PHP file
function mdc_include_func( $atts ) {
  extract( shortcode_atts( array(
    'include' => ''
  ), $atts ) );
  
  
  
  $include = $atts['include'];
  if ($include!='') { // Algo a incluir
    
      $ppi = plugin_dir_path( __FILE__ ) .'mdc-includes/'.$include.'/';
      $file = $ppi.$include.'.php';
      ob_start(); // turn on output buffering
      include_once($file);
      $res = ob_get_contents(); 
      ob_end_clean(); 	  
	}
  return $res;
 }
 
add_shortcode( 'mdc_include', 'mdc_include_func' );

//Widgets

// Creating the widget 
class wpb_widget extends WP_Widget {
  
    function __construct() {
    parent::__construct(
      
    // Base ID of your widget
    'cforecast', 
      
    // Widget name will appear in UI
   'City Forecast', 
      
    // Widget description
    array( 'description' => "Tomorrow's forecast for the selected city") //__( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
    );
    }
      
    // Creating widget front-end
      
    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
      
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
      
    // This is where you run the code and display the output
    echo "<h5>Pronóstico para mañana en <b>La Habana</b></h5>";
    include_once (plugin_dir_path( __FILE__ ).'mdc-widgets/met-habana/met-habana.php');
    echo $args['after_widget'];
    }
              
    // Widget Backend 
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    }
    /*else {
    $title = //__( 'New title', 'wpb_widget_domain' );
    }*/
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
    }
          
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
    }
     
    // Class wpb_widget ends here
    } 
     
     
    // Register and load the widget
    function wpb_load_widget() {
        register_widget( 'wpb_widget' );
    }
    add_action( 'widgets_init', 'wpb_load_widget' );
?>