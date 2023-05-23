<?php

add_action('admin_menu','budget_admin_options');

function budget_admin_options() {
    add_menu_page(
    'Orçamento',
    'Orçamento',
    'budget',
    'budget',
    'budget_options',
    'dashicons-chart-bar',
    50
    );
}

function budget_options() {

	$tabs = array(
		'orcamento' => 'Orçamento do Mês',
		'entrada' => 'Lançamentos Orçamentários',
		'cat' => 'Cadastrar Categoria'
	);

	$tab = (isset( $_GET['tab'] )) ? $_GET['tab'] : 'orcamento';

	echo (isset( $_GET['msg'] )) ? Despesas::msgAlert($_GET['msg']) : ""; ?>

	<h2 class="nav-tab-wrapper">
		<?php
		foreach( $tabs as $tab_n => $name ) :
			$class = ( $tab_n == $tab ) ? 'nav-tab-active' : '';
			$page = $_GET['page'];
			echo "<a class='nav-tab $class' href='?page=$page&tab=$tab_n'>$name</a>";
		endforeach;
		?>
	</h2>

	<?php include_once dirname(__FILE__).'/budget_'.$tab.'.php'; ?>
    
<?php } ?>