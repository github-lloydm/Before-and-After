<?php
/**
 * Plugin Name:       Before and After Comparison
 * Plugin URI:        none
 * Description:       This simple plugin, will just display the before and After photos for comparison.
 * Version:           1.0.0
 * Author:            Lloyd A. Mangin
 * Author URI:        NONE
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-before-After
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class beforeAfter{
    private $before_photo;
    private $after_photo;

    public function __construct(){
        add_action('wp_enqueue_scripts', array($this, 'set_script_styling') );

        /**
         * initialized js beforeAfter plugin
         */
        add_action( 'wp_footer', array($this,'init_js_beforeAfter') );

        /**
         * registering new shortcode 
         */
        add_shortcode( 'beforeAfter', array($this, 'display_beforeAfter_photo') );
    }

    
    /**
     * enqueue script and styling here
     */
    public function set_script_styling(){
        /**
         * enqueue css styling here
         */
        wp_enqueue_style('before-after-comparison-styling', plugin_dir_url( __FILE__ ) . 'css/before-after.css', array(), '1.0');

        /**
         * enqueue custom js / javascript library here
         */
        wp_enqueue_script('before-after-comparison-javascript', plugin_dir_url( __FILE__ ) . 'js/before-after.js', array('jquery'), '1.0' , false);

        
    }

    

    /**
     * initialize beforeAfter js plugin here
     */
    public function init_js_beforeAfter(){
        ob_start();
        ?>
            <script type="text/javascript">
                jQuery(function(){
                    jQuery('.ba-slider').beforeAfter();
                });
            </script>
        <?php

        return ob_get_contents();
    }

    /**
     * this function will make a shortcode for viewing the before and after photo
     */
    public function display_beforeAfter_photo($atts){
        
        
        //echo '<pre>'. print_r($atts, true) .'</pre>';
        
        $html = '';

        $html .= '<div id="beforeAfter--comparison__container" class="ba-slider">';
                
            $html .= '<img src="'.esc_html( $atts['aphoto'] ).'">';
            $html .= '<span class="after--photo">AFTER</span>';
                $html .= '<div class="resize">';
                    $html .= '<span class="before--photo">BEFORE</span>';
                    $html .= '<img src="'.esc_html( $atts['bphoto'] ).'">';
                $html .= '</div>';
                
            $html .= '<span class="handle"></span>';
        
        $html .= '</div>';
        
        return $html;
    }

}   //end of the class

new beforeAfter();