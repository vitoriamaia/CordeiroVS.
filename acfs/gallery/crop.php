/**
 * Adiciona tamanho personalizado as miniaturas
 */
add_image_size( 'my-thumbnail', $width = 825, $height = 510, $crop = true );
add_image_size('capa_persona', 365, 410, true);
add_image_size('capa_servico', 270, 170, true);
add_image_size( 'content-gallery-page', $width = 600, $height = 400, $crop = true );
add_image_size( 'content-gallery-page-small', $width = 200, $height = 200, $crop = true );


// Aqui temos um array com os formatos padrões
    $sizes = array( 'thumbnail', 'medium', 'large' );

    switch( $post_type ):
        case 'my_custom_post_type':
            // É incorporado aos formatos padrões um tamanho previamente criado apenas para o tipo de post personalizado
            array_push( $sizes, 'my-thumbnail' );
            break;
	 case 'servico':
            // É incorporado aos formatos padrões um tamanho previamente criado apenas para o tipo de post personalizado
            array_push( $sizes, 'capa_servico','content-gallery-page', 'content-gallery-page-small' );
            break;
        case 'page':
            // Nenhum redimensionamento é feito para as páginas
            array_push( $sizes, 'content-gallery-page', 'content-gallery-page-small','capa_persona' );
            break;
        default:
            // Por padrão é gerado apenas o thumbnail
            unset($sizes[1], $sizes[2]);
            break;
    endswitch;

    return $sizes;
}
add_filter( 'intermediate_image_sizes', 'filter_size_images' );