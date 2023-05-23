<?php

class View_Budget_Request
{
    
    public function calls_front()
    {
        // Scripts Gerais
        wp_enqueue_script( "get_json_Budget_Request", BUILD . "/js/get_json.js", array(), "1.0", true);
        // json regiões e unidades
        wp_localize_script( "get_json_Budget_Request", "json_mattress", array(
            'mattress_mark' => admin_url( 'admin-ajax.php?action=mattress_mark' ),
            'mattress' => admin_url( 'admin-ajax.php?action=mattress' )
        ));
    }

}