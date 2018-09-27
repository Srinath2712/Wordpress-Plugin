<?php 

/*
*   Plugin Name: NY Times Plugin(SMNYT)
*   Version: 1.0 
*   Author: Srinath Mupparsi
*   License: GPL2
*   Description:  Provides both widgets and shortcodes to help     display NY times articles on the web page. 

*/


/* Add options Function is referenced form wordpress.org/functions */

$plugin_url = WP_PLUGIN_URL . '/smnyt_articles';
$options = array();

function smnyt_articles_menu(){
    
    add_options_page(
        'Srinath Mupparsi NY Times Plugin',
        'NY Times Articles',
        'manage_options',
        'smnyt-articles',
        'smnyt_articles_options_page'
    ); 
}

/*

$page_title
The text to be displayed in the title tags of the page when the menu is selected.

$menu_title
The text to be used for the menu.

$capability
The capability required for this menu to be displayed to the user.

$menu_slug
The slug name to refer to this menu by (should be unique for this menu).

$function
The function to be called to output the content for this page.

Default value: ''

*/

add_action('admin_menu','smnyt_articles_menu');

function smnyt_articles_options_page(){
    
    if (!current_user_can('manage_options')){
        
        wp_die('You Dont have Access ');
    }
     
    global $plugin_url;
    global $options;
    
    if (isset($_POST['smnyt_form_submitted'])){
        $hidden_field = esc_html($_POST['smnyt_form_submitted']);
        
        if($hidden_field == 'Y') {
            $smnyt_search = esc_html($_POST['smnyt_search']);
            $smnyt_apikey = esc_html($_POST['smnyt_apikey']);
            
            $smnyt_results = smnyt_articles_get_results($smnyt_search, $smnyt_apikey);

			$options['smnyt_search'] = $smnyt_search;
			$options['smnyt_apikey'] = $smnyt_apikey;
			$options['last_updated'] = time();

			$options['smnyt_results'] = $smnyt_results;

			update_option('smnyt_articles', $options);

        }
    }
    
    	$options = get_option('smnyt_articles');

	if ($options != ''){
		$smnyt_search = $options['smnyt_search'];
		$smnyt_apikey = $options['smnyt_apikey'];
		$smnyt_results = $options['smnyt_results'];

	}

    
    //echo '<p>Welcome to My First plugin Page....! </p>';

    
    require('inc/options-page-wrapper.php');

}


class Smnyt_Articles_Widget extends WP_Widget {
 
    /**
     * Constructs the new widget.
     *
     * @see WP_Widget::__construct()
     */
    function __construct() {
        // Instantiate the parent object.
        parent::__construct( false, __( 'NYT Articles Widget', 'textdomain' ) );
    }
 
    /**
     * The widget's HTML output.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Display arguments including before_title, after_title,
     *                        before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget.
     */
    function widget( $args, $instance ) {

    	extract($args);
    	$title = apply_filters('widget_title', $instance['title'] );  
        
        /* Title is something which is created by Wordpress. */
    	
        $num_articles = $instance['num_articles'];
    	$display_image = $instance['display_image'];

    	$options = get_option('smnyt_articles');
    	$smnyt_results = $options['smnyt_results'];

    	require ('inc/front-end.php');
    }
 
    /**
     * The widget update handler.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance The new instance of the widget.
     * @param array $old_instance The old instance of the widget.
     * @return array The updated instance of the widget.
     */
    function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);  
        
        /* Strip tags basically strips all the tags such as HTML, XML, and PHP tags and cleans everything clean*/
        
        $instance['display_image'] = strip_tags($new_instance['display_image']);
        $instance['num_articles'] = strip_tags($new_instance['num_articles']);

        return $instance;
    }
 
    /**
     * TO fetch all the attributes which are already existing from the database.
     
     Form Creation by using the wedgets-fields.php file. 
     */
    function form( $instance ) {

    	$title = esc_attr($instance['title']);
    	$display_image = esc_attr($instance['display_image']);
    	$num_articles = esc_attr($instance['num_articles']);

    	$options = get_option('smnyt_articles');
    	$smnyt_results = $options['smnyt_results'];

    	require ('inc/widget-fields.php');

    }
}
 
add_action( 'widgets_init', 'smnyt_articles_register_widgets' );
 
/**
 * Register the new widget.
 *
 * @see 'widgets_init'
 */
function smnyt_articles_register_widgets() {
    register_widget( 'Smnyt_Articles_Widget' );
}

function smnyt_articles_shortcode($atts, $content = null){

	global $post;

	extract(shortcode_atts(array(
		'num_articles' => '5',
		'display_image' => 'on'
		), $atts ) );

	if ($display_image == 'on') $display_image = 1;
	if ($display_image == 'off') $display_image = 0;

    $options = get_option('smnyt_articles');
   	$smnyt_results = $options['smnyt_results'];

   	ob_start();

   	require ('inc/front-end.php');

   	$content = ob_get_clean();

   	return $content;

}

add_shortcode('smnyt_articles', 'smnyt_articles_shortcode' );



function smnyt_articles_get_results($smnyt_search, $smnyt_apikey){

	$json_feed_url = 'http://api.nytimes.com/svc/search/v2/articlesearch.json?q=' . $smnyt_search . '&api-key=' . $smnyt_apikey;

	$json_feed = wp_remote_get($json_feed_url);

	$smnyt_results = json_decode($json_feed['body']);

	return $smnyt_results;
}


function smnyt_articles_backend_styles(){
    
    wp_enqueue_style('smnyt_articles_backend_css', plugins_url('smnyt_articles/smnyt-articles.css'));
}

add_action('admin_head','smnyt_articles_backend_styles');


function smnyt_articles_frontend_styles(){
    
    wp_enqueue_style('smnyt_articles_frontend_css', plugins_url('smnyt_articles/smnyt-articles.css'));
}

add_action('wp_enqueue_scripts','smnyt_articles_frontend_styles');

?>