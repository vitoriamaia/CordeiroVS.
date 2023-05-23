<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Webservice_View_Base
 */
class Webservice_View_Base {

    private $html;

    /**
     * @param $file
     * @return string
     */
    private function render( $file ) {

        $file = dirname( __FILE__ ) . '/' . $file . '.phtml';

        if ( file_exists( $file ) ) :

            ob_start();

            require_once( $file );
            $this->html = ob_get_clean();

        else :

            $this->html = "O arquivo $file não existe";

        endif;

        return $this->html;

    }

    protected function form( $form ) {
        return $this->render( 'form/' . $form );
    }

    protected function html( $file ) {
        return $this->render( 'html/' . $file );
    }

}