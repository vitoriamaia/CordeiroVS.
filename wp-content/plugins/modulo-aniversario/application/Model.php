<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Model_Birthday
{

    public function birthday_all()
    {

        if (false === get_transient('birthday')) {
            // Argumentos
            $args = array(
                'post_type' => 'municipios',
                'showposts' => -1,
            );

            $birthday = get_posts($args);
            set_transient('birthday', $birthday, 60 * 60 * 15);
        }

        $content_general = array();
        $cities = get_transient('birthday');

        if(!empty($cities)) : foreach ($cities as $city) :

            /**
             * Municípios
             */
            $date = get_field('data_fundacao', $city->ID);
            $timestamp = strtotime(str_replace('/', '-', $date));
            $day = date('j', $timestamp);
            $month = date('n', $timestamp);

            $link = get_permalink($city->ID);
            $content = "<p><strong>" . str_pad($day, 2, '0', STR_PAD_LEFT) . "/" . str_pad($month, 2, '0', STR_PAD_LEFT) . "</strong> - <a href='$link'>" . $city->post_title . "</a></p>";

            $content_general['main']['content_city'][$month][$day]['content'][] = $content;

            /**
             * Prefeitos
             */
            $obj_major = get_field('prefeito', $city->ID);

            $date = get_field('data_nascimento', $obj_major->ID);
            $timestamp = strtotime(substr($date, 0, 2) . "-" . substr($date, 2, 2) . "-" . substr($date, 4, 4));
            $day = date('j', $timestamp);
            $month = date('n', $timestamp);

            $title_major = get_the_title($obj_major->ID);
            $title_city = "<a href='" . get_permalink($city->ID) . "'>" . $city->post_title . "</a>";
            $content = "<p><strong>" . str_pad($day, 2, '0', STR_PAD_LEFT) . "/" . str_pad($month, 2, '0', STR_PAD_LEFT) . "</strong> - " . $title_major . " (" . $title_city . ")</p>";
            $content_general['main']['content_major'][$month][$day]['content'][] = $content;

        endforeach;

            echo json_encode($content_general);

        endif;

        exit;

    }

}