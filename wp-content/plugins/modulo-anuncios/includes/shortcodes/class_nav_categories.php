<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Nav_Categories
{

    public static function init()
    {
        add_shortcode('nav_categories', array(__CLASS__, 'nav_categories_list'));
    }

    public static function nav_categories_list()
    { ?>

        <nav class="categories-main">
            <ul class="list-categories">

                <?php
                $params = array(
                    'orderby' => 'ID',
                    'order' => 'ASC',
                    'hide_empty' => 0,
                    'hierarchical' => 'false',
                    'parent' => 0
                );
                $categories = get_terms('categoria', $params);

                $category_get = isset($_GET['category']) ? esc_attr((int)$_GET['category']) : '';

                foreach ($categories as $category):
                    $icon_cat = get_field('imagem_destacada', $category); ?>

                    <li class="list-categories__item <?php echo ($category_get == $category->term_id) ? 'active' : ''; ?>">
                        <a href="<?php echo get_home_url() . '/listagem/?category=' . $category->term_id; ?>"
                           title="<?php echo $category->name; ?>">
                            <img src="<?php echo $icon_cat['sizes']['thumbnail']; ?>" alt="icon categories"
                                 width="<?php echo $icon_cat['sizes']['thumbnail-width']; ?>"
                                 height="<?php echo $icon_cat['sizes']['thumbnail_height']; ?>"/>
                            <span><?php echo $category->name; ?></span>
                        </a>
                    </li>

                <?php endforeach; ?>

            </ul>
        </nav>

        <?php
    }

}

Nav_Categories::init();