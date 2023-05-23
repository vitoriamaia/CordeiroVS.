<?php

/**
 * Converte os Meses em Formato Numérico p/ Formato em Extenso (Brasileiro).
 * @param int $month
 * @return string Mês por Extenso Formato Brasileiro
 */
if (!function_exists('month2Ext')) {
    function month2Ext($month)
    {
        $monthArr = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
        return $monthArr[$month];
    }
}

/**
 * Converte os Dias da Semana em Formato Numérico p/ Formato em Extenso (Brasileiro).
 * @param int $week
 * @return string Semana por Extenso Formato Brasileiro
 */
if (!function_exists('week2Ext')) {
    function week2Ext($week)
    {
        $weekArr = array(1 => "Domingo", 2 => "Segunda", 3 => "Terça", 4 => "Quarta", 5 => "Quinta", 6 => "Sexta", 7 => "Sábado");
        return $weekArr[$week];
    }
}

/**
 * Converte a Entrada de Data Formato (dd/mm/yyyy) p/ Entrada SQL.
 * @param string $date
 * @param string $separator
 * @return string Data Formato SQL
 */
if (!function_exists('date2Sql')) {
    function date2Sql($date, $separator = "/")
    {
        $dataArr = explode($separator, $date);
        $dataArr = array_reverse($dataArr);
        return implode('', $dataArr);
    }
}

/**
 * Converte a Entrada de Data Formato (yyyy-mm-dd -> SQL) p/ Saída Personalizada.
 * @param string $date
 * @param string $separator (opcional)
 * @return string Data Formato Personalizado
 */
if (!function_exists('sql2Date')) {
    function sql2Date($date, $separator = "/")
    {
        $dataArr = explode('-', $date);
        $dataArr = array_reverse($dataArr);
        return implode($separator, $dataArr);
    }
}

/**
 * Vídeos Embed.
 * @param string $url Link do Vídeo
 * @param bool $full Tipo Tamanho do Thumb do Vídeo
 * @param int $width_video Largura do Vídeo
 * @param int $height_video Altura do Vídeo
 * @return array Embed e Thumb do Vídeo
 */
if (!function_exists('get_video')) {
    function get_video($url, $full = false, $width_video = 500, $height_video = 300)
    {
        if (strpos($url, 'youtube.com') !== false) {
            $data = get_meta_tags($url);
            parse_str(parse_url($url, PHP_URL_QUERY), $parameter);
            $size = ($full) ? "sddefault" : 0;
            $embed = '<iframe width="' . $width_video . '" height="' . $height_video . '" class="dt-youtube video-embed" src="//www.youtube.com/embed/' . $parameter['v'] . '?rel=0&amp;showinfo=0" frameborder="0" webkitAllowFullScreen mozallowFullScreen allowFullScreen></iframe>';
            $thumb = 'http://img.youtube.com/vi/' . $parameter['v'] . '/' . $size . '.jpg';
            return array("embed" => $embed, "thumb" => $thumb, "title" => $data['title'], "description" => $data['description']);
        }
        if (strpos($url, 'vimeo.com') !== false) {
            preg_match('/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/', $url, $matches);
            $data = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $matches[2] . ".php"));
            $size = ($full) ? "thumbnail_large" : "thumbnail_medium";
            $embed = '<iframe width="' . $width_video . '" height="' . $height_video . '" class="dt-vimeo video-embed" src="http://player.vimeo.com/video/' . $data[0]['id'] . '?rel=0&amp;title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
            $thumb = $data[0][$size];
            return array("embed" => $embed, "thumb" => $thumb, "title" => $data[0]['title'], "description" => $data[0]['description']);
        }
    }
}

/**
 * Atributos de Imagens.
 * @param int $id_thumb ID da Imagem Destaque
 * @param string $size Tamanho da Imagem Destaque
 * @return array Todos os Parâmentros da Imagem Destaque
 */
if (!function_exists('get_thumb')) {
    function get_thumb($id_thumb = null, $size = "")
    {
        if ($id_thumb === null) return false;

        $attach = get_post($id_thumb);
        $attr_thumb['title'] = $attach->post_title;
        $attr_thumb['description'] = $attach->post_content;
        $attr_thumb['legend'] = $attach->post_excerpt;

        $alt = get_post_meta($id_thumb, '_wp_attachment_image_alt');
        $attr_thumb['alt'] = (!empty($alt)) ? $alt[0] : "";

        $attr_thumb['url'] = $attach->guid;

        if (!empty($size)) {
            $src = wp_get_attachment_image_src($id_thumb, $size);
            $attr_thumb['url_thumb'] = $src[0];
            $attr_thumb['url_thumb_width'] = $src[1];
            $attr_thumb['url_thumb_height'] = $src[2];
        }

        return $attr_thumb;
    }
}

/**
 * Paginação.
 * @param array $args Argumentos de Paginação
 * @return string Paginação
 */
if (!function_exists('paginate')) {
    function paginate($args = array())
    {
        $defaults = array(
            'echo' => true,
            'query' => $GLOBALS['wp_query'],
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => __('Previous Page', 'enollo'),
            'next_text' => __('Next Page', 'enollo'),
        );

        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);
        // Stop execution if there's only 1 page
        if ($query->max_num_pages <= 1) {
            return;
        }

        $pagination = '';
        $links = array();

        $paged = max(1, absint($query->get('paged')));
        $max = intval($query->max_num_pages);

        if ($show_all) {
            $links = range(1, $max);
        } else {
            // Add the pages before the current page to the array
            if ($paged >= 2 + 1) {
                $links[] = $paged - 2;
                $links[] = $paged - 1;
            }

            // Add current page to the array
            if ($paged >= 1) {
                $links[] = $paged;
            }

            // Add the pages after the current page to the array
            if (($paged + 2) <= $max) {
                $links[] = $paged + 1;
                $links[] = $paged + 2;
            }
        }

        $pagination .= "\n" . '<ul class="pagination">' . "\n";
        // Previous Post Link
        if ($prev_next && get_previous_posts_link()) {
            $pagination .= sprintf('<li class="prev">%s</li>', get_previous_posts_link('&laquo;<span class="sr-only">' . $prev_text . '</span>'));
        }

        $pagination .= "\n";
        // Link to first page, plus ellipses if necessary
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';
            $pagination .= sprintf('<li%s><a href="%s">%s</a></li>', $class, esc_url(get_pagenum_link(1)), '1');
            $pagination .= "\n";
            if (!in_array(2, $links)) {
                $pagination .= '<li class="ellipsis"><span>' . __('&hellip;') . '</span></li>';
            }
            $pagination .= "\n";
        }
        // Link to current page, plus $mid_size pages in either direction if necessary
        sort($links);
        foreach ((array)$links as $link) {
            $class = $paged == $link ? ' class="active"' : '';
            $pagination .= sprintf('<li%s><a href="%s">%s</a></li>', $class, esc_url(get_pagenum_link($link)), $link);
            $pagination .= "\n";
        }
        // Link to last page, plus ellipses if necessary
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links)) {
                $pagination .= '<li class="ellipsis"><span>' . __('&hellip;') . '</span></li>';
                $pagination .= "\n";
            }
            $class = $paged == $max ? ' class="active"' : '';
            $pagination .= sprintf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
            $pagination .= "\n";
        }
        // Next Post Link
        if ($prev_next && get_next_posts_link() && $paged <= $max) {
            $pagination .= sprintf('<li class="next">%s</li>' . "\n", get_next_posts_link('<span class="sr-only">' . $next_text . '</span>&raquo;'));
        }
        $pagination .= "</ul><!-- /.pagination -->\n";

        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }
}

/**
 * Breadcrumbs.
 * @return string Breadcrumbs
 */
if (!function_exists('breadcrumbs')) {
    function breadcrumbs()
    {
        /* === OPTIONS === */
        $text['home'] = 'Home'; // text for the 'Home' link
        $text['category'] = 'Categoria "%s"'; // text for a category page
        $text['tax'] = ''; // text for a taxonomy page
        $text['search'] = '"%s"'; // text for a search results page
        $text['tag'] = 'Tag "%s"'; // text for a tag page
        $text['author'] = 'Autor: %s'; // text for an author page
        $text['404'] = 'Error 404'; // text for the 404 page

        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = '<span class="sep"></span>'; // delimiter between crumbs
        $before = '<span class="text">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb
        /* === END OF OPTIONS === */

        global $post;
        $homeLink = get_bloginfo('url') . '/';
        $linkBefore = '<span typeof="v:Breadcrumb" class="link">';
        $linkAfter = '</span>';
        $linkAttr = ' rel="v:url" property="v:title"';
        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        if (is_home() || is_front_page()) {

            if ($showOnHome == 1) echo '<div id="crumbs" class="breadcrumb-content"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

        } else {

            echo '<div id="crumbs" class="breadcrumb-content" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

            if (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo $cats;
                }
                echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

            } elseif (is_tax()) {
                echo "<span class='text'>" . get_queried_object()->name . "</span>";

            } elseif (is_search()) {
                echo $before . sprintf($text['search'], get_search_query()) . $after;

            } elseif (is_day()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                echo $before . get_the_time('d') . $after;

            } elseif (is_month()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo $before . get_the_time('F') . $after;

            } elseif (is_year()) {
                echo $before . get_the_time('Y') . $after;

            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {

                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;

                    printf($link, $homeLink . $slug['slug'] . '/', $post_type->labels->singular_name);

                    /* Taxonomy */
                    $tax = get_object_taxonomies($post_type->name);

                    if (!empty($tax)) {

                        echo $delimiter;
                        $tax = $tax[0];
                        $terms = get_the_terms(get_the_ID(), $tax);

                        foreach ($terms as $term) {
                            $taxonomy = $term->taxonomy;
                            $slug_tax = $term->slug;
                            $name_tax = $term->name;
                        }

                        printf($link, $homeLink . $taxonomy . "/" . $slug_tax . '/', $name_tax);
                    }

                    /* Nome do Post */
                    if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo $cats;
                    if ($showCurrent == 1) echo $before . get_the_title() . $after;
                }

            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                echo $before . $post_type->labels->singular_name . $after;

            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                printf($link, get_permalink($parent), $parent->post_title);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

            } elseif (is_page() && !$post->post_parent) {
                if ($showCurrent == 1) echo $before . get_the_title() . $after;

            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs) - 1) echo $delimiter;
                }
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

            } elseif (is_tag()) {
                echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo $before . sprintf($text['author'], $userdata->display_name) . $after;

            } elseif (is_404()) {
                echo $before . $text['404'] . $after;
            }

            /*
            if ( get_query_var('paged') ) {
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                echo __('Page') . ' ' . get_query_var('paged');
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
            }
            */

            echo '</div>';

        }
    }
}