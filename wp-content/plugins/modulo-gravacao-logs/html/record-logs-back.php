<?php

add_action('admin_menu','options_admin');

function options_admin () { 
    add_menu_page(
    'Estatísticas',             
    'Estatísticas',
    'administrator',
    'record-logs',
    'opcoes',
    'dashicons-chart-bar',
    50
    );
}

function opcoes() { ?>
	
    <div class="wrap">
    	
    	<div class="record">
    		
    		<h2>Estatísticas sobre consultas nos restaurantes</h2>
			
    	</div>
        
        
        <?php
        
        if(isset($_GET['id'])) :

        	global $wpdb;
			$tabela = Record_Logs::table_logs();
        	$id = $_GET['id'];

	        $select = $wpdb->get_results( "SELECT DISTINCT YEAR(data) as Ano FROM $tabela WHERE restaurante = '$id' ORDER BY Ano DESC" );

			if ($select) : ?>
				
					<h2 id="titulo-fatura">
						Consultas Ordenadas por Per&iacute;odo
						<br />
						<?php 
							$resto = get_post($_GET['id'], object);
							echo "(" . $resto->post_title . ")" 
						?>
					</h2>
				
	        		<?php 
	        			foreach ($select as $result) { 
	        			$ano = $result->Ano;
	        		?>
	        		
		        		<div class="fatura">
		        			
							<div class="titulo-fatura">
								<strong>Ano de <?php echo $ano; ?></strong>
							</div>
							
							<div class="body_fatura ano<?php echo $ano; ?>">
								
								<?php $result_per_year = $wpdb->get_results( "SELECT DISTINCT MONTH(data) as Mes FROM $tabela WHERE YEAR(data)='$ano' AND restaurante = '$id' ORDER BY Mes ASC" ); ?>
							
								<div class="descr-fatura">
									<div class="item-descr">Mês</div>
					            	<div class="item-descr">A&ccedil;&atilde;o</div>
								</div>
								
								<?php $i = 0; foreach ($result_per_year as $result_month) : ?>
							
								<div class="group-descr <?php echo $i%2 == 0 ? 'linha-preta' : 'linha-branca'; ?>">
									<div class="result-descr"><?php echo TK_Convert::month2Nom($result_month->Mes); ?></div>
						        	<div class="result-descr">
						        		<a href="<?php echo admin_url('admin-ajax.php?action=exportMysqlToCsv'); ?>&id=<?php echo $_GET['id'] ?>" class="button">Download</a>
						        	</div>
								</div>
								
								<?php $i++; endforeach; ?>
								
							</div>
							
						</div>	
	        		
				    <?php }
					 		
				else : ?>
	        	
	        	<p>Nenhuma Consulta Registrada</p>
	        	
	        <?php endif;

	    else : ?>

			<table class="billing-table">
			
				<thead>
					<tr>
						<td class="top-billing-table"> <strong>ID</strong> </td>
						<td class="top-billing-table"> <strong>Restaurante</strong> </td>
						<td class="top-billing-table"> <strong>CNPJ</strong> </td>
						<td class="top-billing-table"> <strong>A&ccedil;&atilde;o</strong> </td>
					</tr>
				</thead>
				
				<tbody>
					
					<?php

						$args = array(
							'posts_per_page'   => -1,
							'post_type'        => 'post',
							'post_status'      => 'publish',
						);

						$resto = get_posts($args);

						foreach ($resto as $result) : 

						global $wpdb;
						$tabela = Record_Logs::table_logs();
						$id = $result->ID;
						$cnpj = get_post_meta($id, 'cnpj');
						$ano = date('Y');
						$mes = date('m');

						$count = count($wpdb->get_results( "SELECT MONTH(data) as Mes FROM $tabela WHERE YEAR(data) = '$ano' AND MONTH(data) = '$mes' AND restaurante = '$id'" ));

					?>
					
						<tr>
						
							<?php
								echo "<td> $result->ID </td>";
								echo "<td> $result->post_title</td>";
								echo "<td> $cnpj[0]</td>";
								echo 
									 "<td>
										<a href='" . get_home_url() . "/wp-admin/admin.php?page=". $_GET["page"] ."&id=" . $result->ID . "' class='button'> VER </a>
										- $count
									 </td>";
							?>

						</tr>						

					<?php endforeach; ?>

				</tbody>
					
			</table>

	    <?php endif; ?>
        
    </div>
    
<?php } ?>