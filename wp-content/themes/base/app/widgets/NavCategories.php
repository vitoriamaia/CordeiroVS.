<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class NavCategories extends WP_Widget
{

    public function __construct()
    {

        parent::__construct(
            'categories',
            'Categorias ( Barra Lateral - Blog )',
            array(
                'classname' => 'categories',
                'description' => 'CAtegorias do blog.'
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
        <!-- Categorias Blog -->
        <nav class="categories-nav">

            <header class="categories-header">
                <h4 class="tit tit__4 tit__4--blackone">Categorias</h4>
            </header>

            <ul class="cateogies-ul">
                <?php
                $params = array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => 0,
                    'hierarchical' => 'false'
                );

                $categories = get_terms('category',$params);

                foreach($categories as $category):
                    ?>
                    <li class="cateogies-ul__item">
                        <a href="<?php echo get_category_link($category)?>" title="<?php echo $category->name; ?>">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i> <?php echo $category->name; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </nav>
        <!--/ Categorias Blog -->
        <?php
    }


}


/* Register the widget */
add_action('widgets_init', function(){return register_widget("NavCategories");});