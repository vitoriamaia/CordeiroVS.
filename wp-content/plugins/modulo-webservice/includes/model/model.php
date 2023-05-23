<?php

if (!defined('ABSPATH')) exit;

/**
 * Class Webservice_Model
 */
class Webservice_Model
{

    private $ip;

    public function __construct()
    {
        $this->ip = $this->set_ip();
        add_action('wp_ajax_get_content_json', array($this, 'get_content_json'));
        add_action('wp_ajax_nopriv_get_content_json', array($this, 'get_content_json'));
    }

    private function set_ip()
    {
        global $wpdb;
        $t_access = 'immobile_access';
        return $wpdb->get_results("SELECT ws_address FROM $t_access LIMIT 1");
    }

    public function get_ip()
    {
        return $this->ip;
    }

    public function get_content_json()
    {
        $url = $_POST['url'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
        exit;
    }

}