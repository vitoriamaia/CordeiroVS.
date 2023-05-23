<?php

add_action('admin_menu','options_admin');

function options_admin () { 
    add_menu_page(
    'Faturamento',             
    'Faturamento',
    'invoice',
    'faturamento',
    'opcoes',
    'dashicons-chart-bar',
    50
    );
}

function opcoes() { ?>
	
    <div class="wrap">
    	
    	<div class="form_save">
    		
    		<h2>Faturamento Empresarial</h2>
			
			<?php

				$users = get_users();

				if(isset($_GET['msg'])){
					if($_GET['msg']=='ok'){

						echo "
							<div class='msg updated'>
								<p> Faturamento cadastrado com sucesso! </p>
							</div>
						";

					} else if($_GET['msg']=='erro') {

						echo "
							<div class='msg error'>
								<p> Você não preencheu todos os campos solicitados! </p>
							</div>
						";

					} else if($_GET['msg']=='delete') {

						echo "
							<div class='msg updated'>
								<p> Faturamento deletado com sucesso! </p>
							</div>
						";

					} else if($_GET['msg']=='dataexist') {

						echo "
							<div class='msg error'>
								<p> Mês e Ano já cadastrados! </p>
							</div>
						";

					}
				}			
			?>

			<?php if(isset($_GET['id'])) : ?>

			<a href="#" class="cadastrar">Cadastrar Novo Faturamento</a>
			
	        <form action="<?php echo admin_url('admin-ajax.php?action=save_fatura'); ?>" method="post" accept-charset="utf-8" class="form-cadastro">
	        	<input type="hidden" name="cliente" value="<?php echo $_GET['id']; ?>">
				<p> 
					<label for="data">Insira a data do Faturamento</label> <br />
					<input type="text" name="data" id="data" class="data" separador="/" msn_validacao="Preencha a data corretamente." />
				</p>

				<p>
					<label for="faturamento">Insira o valor do Faturamento</label> <br />
					<input type="text" name="faturamento" id="faturamento" class="moeda validar-campo required" minlength="2" prefixo="R$ " decimal="," msn_validacao="Preencha esse campo." />
				</p>

				<p>
					<label for="name_cliente">Cliente Selecionado</label> <br />
					<input type="text" name="name_cliente" id="cliente" readonly="readonly" value="<?php $user = get_user_by('id', $_GET['id']); echo $user->display_name; ?>" />
				</p>

				<p>
					<input type="submit" id="incluir_reg" value="Incluir Novo Faturamento" />
				</p>
	        </form>

	    	<?php endif; ?>
    		
    	</div>
        
        
        <?php
        
        if(isset($_GET['id'])) :

        	global $wpdb;
			$tabela = Faturamento::table();
        	$id = $_GET['id'];

	        $select = $wpdb->get_results( "SELECT DISTINCT YEAR(data) as Ano FROM $tabela WHERE empresa = '$id' ORDER BY Ano DESC" );

			if ($select) { ?>
				
					<h2 id="titulo-fatura">
						Faturamento Ordenado por Per&iacute;odo
						<br />
						<?php $user = get_user_by('id', $_GET['id']); echo "(" . $user->display_name . ")" ?>
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
								
								<?php $result_per_year = $wpdb->get_results( "SELECT id, MONTH(data) as Mes, Fatura FROM $tabela WHERE YEAR(data)='$ano' AND empresa = '$id' ORDER BY Mes ASC" ); ?>
							
								<div class="descr-fatura">
									<div class="item-descr">Mês</div>
					            	<div class="item-descr">Faturamento</div>
					            	<div class="item-descr">A&ccedil;&atilde;o</div>
								</div>
								
								<?php
									$i = 0;
									foreach ($result_per_year as $result_month) :
									$sum_invoice[] = $result_month->Fatura;
								?>
							
								<div class="group-descr <?php echo $i%2 == 0 ? 'linha-preta' : 'linha-branca'; ?>">
									<div class="result-descr"><?php echo TK_Convert::month2Nom($result_month->Mes); ?></div>
						        	<div class="result-descr">R$ <?php echo TK_Convert::val_am2br($result_month->Fatura); ?></div>
						        	<div class="result-descr"><a href="<?php echo admin_url('admin-ajax.php?action=delete_fatura'); ?>&ID=<?php echo $result_month->id; ?>&user=<?php echo $_GET['id'] ?>" class="delete" onclick="return confirm('Deseja realmente Excluir este registro?')">Deletar</a></div>
								</div>
								
								<?php $i++; endforeach; ?>
								
								<div class="group-descr">
									<div class="result-descr total">Total</div>
						        	<div class="result-descr total">R$ <?php echo TK_Convert::val_am2br(array_sum($sum_invoice)); ?></div>
								</div>
								
								<?php $sum_invoice = array(); ?>
								
							</div>
							
						</div>	
	        		
				    <?php }
					 		
				} else { ?>
	        	
	        	<p>Nenhum Faturamento Registrado</p>
	        	
	        <?php } 

	    else : ?>

			<table class="billing-table">
			
				<thead>
					<tr>
						<td class="top-billing-table"> <strong>Empresa</strong> </td>
						<td class="top-billing-table"> <strong>CNPJ</strong> </td>
						<td class="top-billing-table no-print"> <strong>A&ccedil;&atilde;o</strong> </td>
					</tr>
				</thead>
				
				<tbody>
					
					<?php 
						foreach ($users as $result) : 
						$cnpj = get_user_meta($result->ID, 'cnpj')
					?>
					
					<tr>
					
					<?php
						echo "<td> $result->display_name </td>";
						echo "<td> $cnpj[0]</td>";
						echo "<td class='no-print'>";
							echo "<a href='" . get_home_url() . "/wp-admin/admin.php?page=faturamento&id=" . $result->ID . "' class='button'> VER </a>";
						echo "</td></tr>";

					endforeach; ?>
				</tbody>
					
			</table>

	    <?php endif; ?>
        
    </div>
    
<?php } ?>