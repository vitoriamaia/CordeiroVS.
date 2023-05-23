<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Query_Result
{

    public static function result_search()
    {

        // Captura Local
        $local = isset($_GET['local']) ? esc_attr((int)$_GET['local']) : '';

        // Captura Estabelecimento
        $establishment = isset($_GET['establishment']) ? esc_attr($_GET['establishment']) : '';

        // Captura Categoria
        $category = isset($_GET['category']) ? esc_attr($_GET['category']) : '';

        // Busca no Banco de Dados
        $establishment_result = Query_Result::establishment($local, $establishment, $category);

        if (!empty($local)) {
            $local = get_term($local, 'local');
            $local = $local->name;
        }

        if (empty($local) && empty($establishment)) {
            $title_display = 'Resultado geral';
        } else if (empty($local)) {
            $title_display = 'Resultado da busca para: ' . $establishment;
        } else if (empty($establishment)) {
            $title_display = 'Estabelecimentos em: ' . $local;
        } else {
            $title_display = 'Resultado da busca para: ' . $establishment . ' em ' . $local;
        }

        ?>

        <header class="header-content">
            <h3>
                <?php echo $title_display; ?>
            </h3>
        </header>

        <section>
            <ul class="list-anuncios">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                query_posts(
                    array(
                        'post__in' => $establishment_result,
                        'post_type' => 'anuncios',
                        'paged' => $paged,
                        'orderby' => 'post__in'
                    )
                );
                if (have_posts()) : while (have_posts()): the_post();
                    $plano = get_the_terms(get_the_ID(), 'plano');
                    $plano = $plano[0]->slug;
                    ?>

                    <li class="col-md-10 list-anuncios__item plano-<?php echo $plano; ?>">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <div>
                                <figure>
                                    <?php
                                    if (has_post_thumbnail()) :
                                        the_post_thumbnail('thumbnail');
                                    else : ?>
                                        <img src="<?php echo WP_IMAGES; ?>/icon-anuncio.png"
                                             alt="imagem anuncio" title="<?php the_title(); ?>"
                                             width="81" height="81"/>
                                    <?php endif; ?>
                                </figure>
                                <article>
                                    <h4><?php the_title(); ?></h4>
                                    <p>
                                        <?php if (get_field('endereco'))
                                            echo get_field('endereco') . ", " . get_field('numero'); ?>
                                    </p>
                                    <ul class="phones">
                                        <?php if (have_rows('telefones')) : while (have_rows('telefones')) : the_row(); ?>
                                            <li class="phones__item">
                                                <?php the_sub_field('telefone'); ?>
                                            </li>
                                            <?php break; endwhile; endif; ?>
                                    </ul>
                                    <ul class="category">
                                        <?php
                                        $categories = get_the_terms('', 'categoria');
                                        foreach ($categories as $category) :
                                            $icon_cat = get_field('imagem_destacada', $category);
                                            ?>
                                            <li class="categories__item"><?php echo $category->name; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </article>
                            </div>
                        </a>
                    </li>

                <?php endwhile;
                else : ?>

                    <li>
                        <h4 class="notfound">Nada encontrado.</h4>
                    </li>

                <?php endif; ?>

            </ul>
        </section>

        <section class="row">
            <div class="col-md-12">
                <?php echo wp_bootstrap_pagination(); ?>
            </div>
        </section>

        <?php
    }

    public static function establishment($local, $establishment, $category)
    {

        global $wpdb;

        $posts = $wpdb->prefix . "posts";
        $relations = $wpdb->prefix . "term_relationships";
        $terms = $wpdb->prefix . "terms";

        $establishment = (!empty($establishment)) ? "
            AND (p.post_title LIKE '%$establishment%' 
            OR p.post_content LIKE '%$establishment%')" : "";

        $category = (!empty($category)) ? "
            AND p.ID IN (SELECT p.ID FROM gui_posts as p
            INNER JOIN gui_term_relationships as r
            INNER JOIN gui_terms as t
            ON p.ID = r.object_id
            AND r.term_taxonomy_id = t.term_id
            AND t.term_id = $category)" : "";

        if (!empty($local)) {
            $posts = "
            (SELECT pin.ID, pin.post_title, pin.post_content FROM $posts as pin
            INNER JOIN $relations as rin
            INNER JOIN $terms as tin
            ON pin.ID = rin.object_id
            AND rin.term_taxonomy_id = tin.term_id
            AND tin.term_id = $local)";
        }

        $query = "(SELECT p.ID as ID FROM $posts as p
            INNER JOIN $relations as r
            INNER JOIN $terms as t 
            ON p.ID = r.object_id
            AND r.term_taxonomy_id = t.term_id
            AND t.term_id = 22
            $establishment
            $category
            ORDER BY rand())
            
            UNION
            
            (SELECT p.ID as ID FROM $posts as p
            INNER JOIN $relations as r
            INNER JOIN $terms as t 
            ON p.ID = r.object_id
            AND r.term_taxonomy_id = t.term_id
            AND t.term_id = 21
            $establishment
            $category)
            
            UNION
            
            (SELECT p.ID as ID FROM $posts as p
            INNER JOIN $relations as r
            INNER JOIN $terms as t 
            ON p.ID = r.object_id
            AND r.term_taxonomy_id = t.term_id
            AND t.term_id = 20
            $establishment
            $category)
            ";

        $results = $wpdb->get_results($query);

        if (empty($results)) return array(0);

        $return_ids = array();
        foreach ($results as $result) {
            $return_ids[] = $result->ID;
        }

        return $return_ids;

    }

}