<?php
/**
 * Template for displaying search forms in Twenty Sixteen
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text">Buscar por:</span>
        <input type="search" class="search-field" placeholder="Busca" value="<?php echo get_search_query(); ?>" name="s"/>
    </label>
    <button type="submit" class="search-submit">
        <span class="screen-reader-text">
            Buscar
		</span>
    </button>
</form>
