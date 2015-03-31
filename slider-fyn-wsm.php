<?php
/*
Plugin Name: Slider for WSM FYN
Version: 0.1-alpha
Description: This plugin outputs build slider from featured image posts.
Author: Maxim Seliverstov
Author URI: github.com/seliverstov-maxim
Plugin URI: github.com/seliverstov-maxim/slider-fyn-wsm
Text Domain: slider_for_wsm_fyn
*/

$base = plugin_dir_path(__FILE__);
require_once(join(DIRECTORY_SEPARATOR, array($base, 'lib', 'slider_widget.php')));

add_action('widgets_init', 'register_slider_widget');
function register_slider_widget() {
  if(is_multisite()){
    register_widget('SliderWidget');
  }
}

function include_wsm_slider_scripts() {
  wp_enqueue_style('coda-slider', plugins_url('css/coda-slider.css', __FILE__));
  wp_enqueue_script('coda-slider', plugins_url('js/jquery.coda-slider-3.0.min.js', __FILE__));
  wp_enqueue_script('jquery-easing', plugins_url('js/jquery.easing.1.3.js', __FILE__));
}
add_action('wp_enqueue_scripts', 'include_wsm_slider_scripts', 999);