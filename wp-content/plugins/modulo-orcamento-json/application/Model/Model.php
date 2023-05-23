<?php

class Model_Budget_Request
{

    public function get_mattress_mark()
    {
        $params = array(
            'order' => 'ASC',
            'hide_empty' => 1,
            'parent' => 7
        );

        $categories = get_terms('product_cat', $params);

        foreach ($categories as $category):

            $mattress_mark[] = array(
                'mattress_mark' => array(
                    'id' => $category->term_id,
                    'name' => $category->name
                )
            );

        endforeach;

        echo(json_encode($mattress_mark));
        exit;
    }

    public function get_mattress()
    {
        $mattress = $_GET['mattress'];

        if (!$mattress) return false;

        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $mattress
                )
            )
        );

        $mattress = get_posts($args);

        foreach ($mattress as $single):

            $mattress_content[] = array(
                'mattress' => $single->post_title
            );

        endforeach;

        echo(json_encode($mattress_content));
        exit;
    }

}