<?php

/*
Plugin Name: Módulo Arquivos
Plugin URI: http://www.bindigital.com.br
Description: Tao Archives Customers BinDigital
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

define('ClassNameArchive','Tao_Archives_Customers');

class Tao_Archives_Customers
{

	// Checa se Existe Página Central de Arquivos
	public static function install()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='central-arquivos'", ARRAY_N);
		if(empty($pageRel)){
			$arg = array(
				'post_name'=>'central-arquivos',
				'post_title' => 'Central de Arquivos',
				'post_status' => 'private',
				'post_type' => 'page',
				'menu_order' => 100,
				'post_content' => '[tao_loop_paste_archives]',
				'page_template' => 'padrao-restrito.php'
			);
			wp_insert_post( $arg );
		}
    }

    // Checa se Existe Página Central de Arquivos e Deleta
	public static function uninstall()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='central-arquivos'", ARRAY_N);

		if(!empty($pageRel)){
			$pageRel = $pageRel[0][0];
			$wpdb->query("DELETE FROM $wpdb->posts WHERE ID = $pageRel");
		}
    }

    // Post_Type Arquivos
	public static function post_type_archives()
	{
		$labels = array(
			'name'                => 'Arquivos',
			'singular_name'       => 'Arquivo',
			'menu_name'           => 'Arquivos',
			'parent_item_colon'   => 'Arquivo Superior:',
			'all_items'           => 'Todos os Arquivos',
			'view_item'           => 'Ver Arquivo',
			'add_new_item'        => 'Adicionar Novo Arquivo',
			'add_new'             => 'Novo Arquivo',
			'edit_item'           => 'Editar Arquivo',
			'update_item'         => 'Atualizar Arquivo',
			'search_items'        => 'Buscar Arquivo',
			'not_found'           => 'Nenhum Arquivo Encontrado',
			'not_found_in_trash'  => 'Nenhum Arquivo Encontrado na Lixeira',
		);
		$rewrite = array(
			'slug'                => 'arquivos',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => false,
		);
		$args = array(
			'label'               => 'Arquivos',
			'description'         => 'Arquivos Gerais',
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => "dashicons-portfolio",
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => 'arquivos',
			'rewrite'             => $rewrite,
			'capability_type'	  => 'post'
		);
		register_post_type( 'arquivos', $args );
	}


	// Taxonomia Arquivos
	public static function paste_archives()
	{
		$labels = array(
			'name'                       => 'Pastas',
			'singular_name'              => 'Pasta',
			'menu_name'                  => 'Pastas',
			'add_new_item'               => 'Adicionar Nova Pasta',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
		);
		register_taxonomy( 'pasta', array( 'arquivos' ), $args );
	}


	// Metabox Arquivos
	public static function arch_register_meta_boxes( $meta_boxes )
	{
	    $prefix = 'arch_';
	    
	    $meta_boxes[] = array(
	        'id'       => 'file_laudos',
	        'title'    => 'Arquivos Empresariais',
	        'pages'    => array( 'arquivos' ),
	        'context'  => 'normal',
	        'priority' => 'low',
	        'fields' => array(
	            array(
	            	'name'	=> 'Empresa',
	                'id'    => $prefix . 'empresa',
	                'desc'  => 'Empresa a Receber o Arquivo',
	                'type'  => 'user',
	                'class' => 'empresa',
	                'label'	=> '',
	                'placeholder' => '',
	                'value' => ''
	            ),
	            array(
	                'id'    => $prefix . 'div1',
	                'type'  => 'divider',
	            ),
	            array(
	            	'name'	=> 'Arquivo',
	                'id'    => $prefix . 'arquivo',
	                'desc'  => 'Arquivo a ser Enviado',
	                'type'  => 'file_input',
	                'class' => 'arquivo',
	            )
	        )
	    );

	    return $meta_boxes;
	}


	// Save Archive in Model Private
	public static function save_archive_restrict( $post_id ) 
	{

		$post_type = get_post_type( $post_id );

		if($post_type!="arquivos"){

			return;

		}

		$status = get_post_status($post_id);

		if(isset($_GET['action']) != 'trash' && $status != 'auto-draft'){

			remove_action('save_post', array(ClassNameArchive, 'save_archive_restrict'));

			$args_archive = array(
			  'ID'          => $post_id,
			  'post_status' => 'private',
			);

			wp_update_post( $args_archive );

		}

	}


	// Loop Archives
	public static function tao_loop_archives($query)
	{

		if ( is_tax('pasta') ) {
        	$query->set(
        		'meta_query', array(
					array(
						'key'     => 'arch_empresa',
						'value'   => get_current_user_id(),
						'compare' => '==',
					)
				)
        	);
    	}

	}


	// Tornando Taxonomia Pasta Restrita
	public static function restrict_tax()
	{

		if ( is_tax('pasta') && !is_user_logged_in() ) {
        	wp_die("Área Restrita. Favor faça login para acessar sua área.", "Área Restrita");
    	}

    	if ( is_tax('pasta') && !is_user_logged_in() ) {

			$protocol = $_SERVER['REQUEST_SCHEME'];
			$host = $_SERVER['HTTP_HOST'];
			$uri = $_SERVER['REQUEST_URI'];

			$url = $protocol.'://'.$host.$uri;

        	wp_redirect( wp_login_url( $url ) );
        	exit;
        	
    	}

	}


	// Loop Paste Archives
	public static function tao_loop_paste_archives()
	{

		?>

		<h4 class="tit-nivel3">Central de Arquivos</h4>
    
        <ul class="servicos">

        	<?php

        	$args = array(
			    'orderby'           => 'name', 
			    'order'             => 'ASC',
			    'hide_empty'        => false,
			    'fields'            => 'all', 
			    'hierarchical'      => false,
			); 

        	$taxonomias = get_terms('pasta', $args);

        	if(!empty($taxonomias)) : 

        		foreach ($taxonomias as $taxonomia) : 

	        		$term = $taxonomia->term_id;

		        	$posts = get_posts(
		        		array(
							'post_type' => 'arquivos',
						    'post_status' => 'private',
						    'meta_query' => array(
								array(
									'key'     => 'arch_empresa',
									'value'   => get_current_user_id(),
								)
							),
						    'tax_query' => array(
						        array(
						            'taxonomy' => 'pasta',
						            'field'    => 'term_id',
						            'terms'    => $term
						    	)  
							),
						)
		        	);

		        	if(!empty($posts)) :

        	?>

				<li class="serv-item pure-u-sm-10-24 pure-u-md-10-24">
	                <a href="<?php echo get_home_url() ."/pasta/". $taxonomia->slug; ?>" title="<?php echo $taxonomia->name; ?>" class="">
		                <div class="img pure-u-md-7-24">
		                    <img src="<?php echo get_template_directory_uri(); ?>/build/images/icon-pessoa.jpg">
		                </div>

		                <div class="pure-u-md-15-24">
		                	<h5 class="tit-nivel4"><?php echo $taxonomia->name; ?></h5>
		                	<span class="saiba-mais">saiba mais</span>
		                </div>
	                </a>
	            </li>
        		
        	<?php endif; endforeach; else: ?>

				<li>Nenhum Arquivo Encontrado</li>

        	<?php endif; ?>

        </ul>

	<?php }

}

// Chama Método Instalação
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array( ClassNameArchive, 'install'));

// Chama Método de Desinstalação
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array( ClassNameArchive, 'uninstall'));

// Post_Type Arquivos
add_action( 'init', array(ClassNameArchive, 'post_type_archives') );

// Taxonomia Pasta Arquivos
add_action( 'init', array(ClassNameArchive, 'paste_archives') );

// Metabox Post_Type Arquivos
add_filter( 'rwmb_meta_boxes', array( ClassNameArchive, 'arch_register_meta_boxes' ));

// Restrição nos singles Arquivos
add_action( 'save_post', array( ClassNameArchive, 'save_archive_restrict' ));

// Pre Query Single Archive
add_action('pre_get_posts', array( ClassNameArchive, 'tao_loop_archives' ));

// Tornando Taxonomia Pasta Restrita
add_action( 'wp_head', array( ClassNameArchive, 'restrict_tax' ));

// Inserir em uma página o seguinte código shortcode [tao_loop_paste_archives] para que seja exibido o formulário
add_shortcode('tao_loop_paste_archives', array( ClassNameArchive, 'tao_loop_paste_archives' ));