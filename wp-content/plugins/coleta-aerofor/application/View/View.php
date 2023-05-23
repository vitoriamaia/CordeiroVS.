<?php

class View_Collect
{

    private $html;

    public function render($file)
    {

        $file = dirname(__FILE__) . '/' . $file . '.phtml';

        if (file_exists($file)) :

            ob_start();

            require_once($file);
            $this->html = ob_get_clean();

        else :

            $this->html = "O arquivo $file não existe";

        endif;

        return $this->html;

    }
    
}