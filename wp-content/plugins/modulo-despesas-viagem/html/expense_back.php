<?php

add_action('admin_menu','options_expense');

function options_expense() { 
    add_menu_page(
	    'Despesas de Viagem',             
	    'Despesas de Viagem',
	    'expense',
	    'despesas',
	    'options_expense_callback',
	    'dashicons-calendar',
	    60
    );
}

function options_expense_callback(){
	
	$tabs = array( 'viagem' => 'Cadastrar Viagens', 'cat' => 'Cadastrar Categoria' );
	if ( isset ( $_GET['tab'] ) ) {$tab = $_GET['tab'];} else {$tab = 'viagem';}
	
	?>
	
    <div class="wrap">
    	
    	<div class="form_expense">
    		
    		<h2>Despesas de Viagem da Empresa <?php echo get_option('blogname'); ?></h2>
    		
    		<?php if( isset( $_GET['msg'] ) ){ echo Despesas::msgAlert($_GET['msg']); } ?>
    		
		    <h3 class="nav-tab-wrapper">
			    <?php
			    foreach( $tabs as $tab_n => $name ){
			        $class = ( $tab_n == $tab ) ? 'nav-tab-active' : '';
			        echo "<a class='nav-tab $class' href='?page=despesas&tab=$tab_n'>$name</a>";
			    }
				?>
		    </h3>
			
			<?php include_once dirname(__FILE__).'/form_cad_'.$tab.'.php'; ?>
    		
    	</div>
        
        <?php include_once dirname(__FILE__).'/result_'.$tab.'.php'; ?>
        
    </div>
    
<?php } ?>