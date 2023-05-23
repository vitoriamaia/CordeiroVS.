<?php

/**
 * Plugin Name: WP ToolKit
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Esse projeto é um conjunto de pacotes JS e CSS
 * Version: 0.0.5
 * Author: taotiago
 * Author URI: https://www.facebook.com/tao.pires
 */
class WP_ToolKit
{

    public static function init()
    {
        // URL do Plugin
        define('PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

        // Registra os scripts e estilos
        add_action('wp_enqueue_scripts', array(__CLASS__, 'starter'));
    }

    # Registra Scripts e Estilos
    public static function starter()
    {
        // Starter
        wp_register_script("starter", PLUGIN_DIR_URL . "build/starter/starter.js", array(), "1.0.0", false);
        wp_register_script("element-exists-jquery", PLUGIN_DIR_URL . "build/starter/element_exists_jquery.js", array('jquery'), "1.0.0", false);

        // Font-Awesome
        wp_register_style("font-awesome", PLUGIN_DIR_URL . "build/font-awesome/css/font-awesome.min.css");

        // Bootstrap
        wp_register_script("bootstrap", PLUGIN_DIR_URL . "build/bootstrap/js/bootstrap.min.js", array("jquery"), '4.1.3', true);
        
		// Select2
        wp_register_script("select2", PLUGIN_DIR_URL . "build/select2/js/select2.min.js", array("jquery"), '3.3.1', true);
		
		// formzin
        wp_register_script( "formzin" , plugin_dir_url( __FILE__ ) . "build/formzin/formzin.min.js", array( "jquery" ), false, true);
		
        // Lazyload
        wp_register_script("lazy-load", PLUGIN_DIR_URL . "build/lazy/js/lazy.js", array("jquery"), '1.9.3', true);

        // Fancybox
        wp_register_style("fancybox", PLUGIN_DIR_URL . "build/fancybox/css/jquery.fancybox.css");
        wp_register_script("fancybox", PLUGIN_DIR_URL . "build/fancybox/js/jquery.fancybox.js", array('jquery'), '3.1.5', true);

        // Swipe
        wp_register_script("swiper", PLUGIN_DIR_URL . "build/swiper/js/swiper.min.js", array("jquery"), '3.3.1', true);

        // WOW Animate
        wp_register_style("wow", PLUGIN_DIR_URL . "build/wow/css/animate.css");
        wp_register_script("wow", PLUGIN_DIR_URL . "build/wow/js/wow.min.js", array("jquery"), '1.1.2', true);
        wp_add_inline_script("wow", "new WOW().init();");

        // Owl-Carousel
        wp_register_style("owl-carousel", PLUGIN_DIR_URL . "build/owl-carousel/css/owl.carousel.css");
        wp_register_script("owl-carousel", PLUGIN_DIR_URL . "build/owl-carousel/js/owl.carousel.min.js", array("jquery"), false, true);

        // DatePicker pt-BR
        wp_register_style("datepicker-pt-br", PLUGIN_DIR_URL . "build/datepicker-pt-br/css/datepicker-pt-br.css");
        wp_register_script("datepicker-pt-br", PLUGIN_DIR_URL . "build/datepicker-pt-br/js/datepicker-pt-br.js", array('jquery', 'jquery-ui-datepicker'), false, true);

        // jMask
        wp_register_script("jmask", PLUGIN_DIR_URL . "build/jmask/js/jquery.mask.min.js", array('jquery'), '1.7.7', true);

        // Cidades-Estados
        wp_register_script("cidades-estados", PLUGIN_DIR_URL . "build/cidades-estados/js/cidades-estados-1.4.js", array(), false, true);

    }

}

WP_ToolKit::init();