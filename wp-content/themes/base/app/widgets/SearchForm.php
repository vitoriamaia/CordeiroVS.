<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SearchForm extends WP_Widget
{

    public function __construct()
    {

        parent::__construct(
            'searchform',
            'Pesquisa (Barra Lateral - Blog)',
            array(
                'classname' => 'searchform',
                'description' => 'Formulário de pesquisa.'
            )
        );

    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        ?>
        <!-- Pesquisa de Post -->
        <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="form-search">
            <div class="input-group">
                <input type="search" class="form-control" placeholder="Pesquisar no blog" value="<?php echo get_search_query(); ?>" name="s" id="s" title="Pesquisar"  />
                <input type="hidden" name="post_type" value="post" />
                <span class="input-group-btn" ><button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </form>
        <!--/ Pesquisa de Post -->
        <?php
    }


}


/* Register the widget */
add_action('widgets_init', function(){return register_widget("SearchForm");});