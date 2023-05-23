<?php
/**
 * WordPress Bootstrap Pagination
 */
function wp_bootstrap_pagination( $args = array() ) {

    $defaults = array(
        'echo' => true,
        'query' => $GLOBALS['wp_query'],
        'show_all' => false,
        'prev_next' => true,
        'prev_text' => __('Previous Page', 'enollo'),
        'next_text' => __('Next Page', 'enollo'),
    );

    $args = wp_parse_args( $args, $defaults );
    extract($args, EXTR_SKIP);
    // Stop execution if there's only 1 page
    if( $query->max_num_pages <= 1 ) {
        return;
    }

    $pagination = '';
    $links = array();

    $paged = max( 1, absint( $query->get( 'paged' ) ) );
    $max   = intval( $query->max_num_pages );

    if ( $show_all ) {
        $links = range(1, $max);
    } else {
        // Add the pages before the current page to the array
        if ( $paged >= 2 + 1 ) {
            $links[] = $paged - 2;
            $links[] = $paged - 1;
        }

        // Add current page to the array
        if ( $paged >= 1 ) {
            $links[] = $paged;
        }

        // Add the pages after the current page to the array
        if ( ( $paged + 2 ) <= $max ) {
            $links[] = $paged + 1;
            $links[] = $paged + 2;
        }
    }

    $pagination .= "\n" . '<ul class="pagination">' . "\n";
    // Previous Post Link
    if ( $prev_next && get_previous_posts_link() ) {
        $pagination .= sprintf( '<li class="prev">%s</li>', get_previous_posts_link('&laquo;<span class="sr-only">' . $prev_text . '</span>') );
    }

    $pagination .= "\n";
    // Link to first page, plus ellipses if necessary
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
        $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );
        $pagination .= "\n";
        if ( ! in_array( 2, $links ) ) {
            $pagination .= '<li class="ellipsis"><span>' . __( '&hellip;' ) . '</span></li>';
        }
        $pagination .= "\n";
    }
    // Link to current page, plus $mid_size pages in either direction if necessary
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );
        $pagination .= "\n";
    }
    // Link to last page, plus ellipses if necessary
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) ) {
            $pagination .= '<li class="ellipsis"><span>' . __( '&hellip;' ) . '</span></li>';
            $pagination .= "\n";
        }
        $class = $paged == $max ? ' class="active"' : '';
        $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
        $pagination .= "\n";
    }
    // Next Post Link
    if ( $prev_next && get_next_posts_link() && $paged <= $max ) {
        $pagination .= sprintf( '<li class="next">%s</li>' . "\n", get_next_posts_link('<span class="sr-only">' . $next_text . '</span>&raquo;') );
    }
    $pagination .= "</ul><!-- /.pagination -->\n";

    if ( $echo ) {
        echo $pagination;
    } else {
        return $pagination;
    }
}