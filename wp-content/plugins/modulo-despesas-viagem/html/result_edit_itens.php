<?php

global $wpdb;
$table = $wpdb->prefix."despesas_gastos";
$table_despesa = $wpdb->prefix."despesas_viagem";
$id_item = $_GET['id'];

$despesas = $wpdb->get_results( "SELECT * FROM $table_despesa WHERE id='".$id_item."'", OBJECT );
foreach ($despesas as $despesa){ $adiantamento = $despesa->adiantamento; ?>
	
	<h2 id="titulo-despesa">Dados Cadastrados da Viagem</h2>
	
	<div class="itens_despesa_title">
		<form action="<?php echo admin_url('admin-ajax.php?action=save_expense'); ?>" method="post" accept-charset="utf-8">
			<div class="item_despesa">
				<strong>Identificador:</strong> 
				<input type="text" value="<?php echo $despesa->identificador; ?>" class="item_despesa readonly" readonly="readonly" /> 
			</div>
			<div class="item_despesa">
				<strong>Funcionário:</strong> 
				<input type="text" value="<?php echo Despesas::user_by_id($despesa->funcionario); ?>" class="item_despesa readonly" readonly="readonly" /> 
			</div>
			<div class="item_despesa">
				<strong>Destino:</strong> 
				<input type="text" value="<?php echo $despesa->destino; ?>" name="destino" class="item_despesa" readonly="readonly" /> 
			</div>
			<div class="item_despesa">
				<strong>Data Ida:</strong> 
				<input type="text" value="<?php echo TK_Convert::sql2Date($despesa->data_ida, "/") ?>" name="data_ida" class="item_despesa" readonly="readonly" /> 
				<br />
				<strong>Data Volta:</strong>
				<input type="text" value="<?php echo TK_Convert::sql2Date($despesa->data_volta, "/"); ?>" name="data_volta" class="item_despesa" readonly="readonly" /></div>
			<div class="item_despesa">
				<strong>Assunto:</strong> 
				<input type="text" value="<?php echo $despesa->assunto; ?>" name="assunto" class="item_despesa" readonly="readonly" />
			</div>
			<div class="item_despesa">
				<strong>Empresa:</strong> 
				<input type="text" value="<?php echo $despesa->empresa; ?>" name="empresa" class="item_despesa" readonly="readonly" /> 
			</div>
			<div class="item_despesa no-print">
				<strong>Adiantamento:</strong> 
				<input type="text" value="<?php echo TK_Convert::val_am2br($adiantamento); ?>" name="adiantamento" class="item_despesa moeda validar-campo required" minlength="3" prefixo="R$ " decimal="," msn_validacao="Preencha esse campo." readonly="readonly" /> 
			</div>
			<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
			<a href="#" class="button edit">editar</a>
			<a href="#" class="button salvar">salvar</a>
			<a href="#" class="button printer">imprimir</a>
		</form>
	</div>
	
<?php }

$select = $wpdb->get_results( "SELECT DISTINCT id_cat FROM $table WHERE id_viagem='".$id_item."'", OBJECT );
if($select) {
	
?>

<h2 id="titulo-despesa">Despesas Ordenadas por Categorias</h2>

		<?php
		
		foreach ($select as $result){
		$id_cat = $result->id_cat;
		
		?>

		<div class="despesa">
			
			<div class="titulo-despesa">
				<strong><?php echo Despesas::cat_by_id($id_cat); ?></strong>
			</div>
			
			<div class="body_despesa">
				
				<?php $result_cat = $wpdb->get_results( "SELECT * FROM $table WHERE id_cat='$id_cat' AND id_viagem='$id_item' ORDER BY MONTH(data_despesa) DESC, DAY(data_despesa) DESC", OBJECT ); ?>
			
				<div class="descr-despesa">
					<div class="item-descr">Data</div>
		        	<div class="item-descr">Tipo Doc</div>
		        	<div class="item-descr">NR Doc</div>
		        	<div class="item-descr">Forma Pagto</div>
		        	<div class="item-descr historico">Histórico</div>
		        	<div class="item-descr">Valor</div>
		        	<div class="item-descr no-print">A&ccedil;&atilde;o</div>
				</div>
				
				<?php
					$i = 0;
					$sum_invoice = array();
					foreach ($result_cat as $result_month) :
					$sum_invoice[] = $result_month->valor;
					$sum_invoice_all [] = $result_month->valor;
				?>
			
				<div class="group-descr <?php echo $i%2 == 0 ? 'linha-preta' : 'linha-branca'; ?>">
					<div class="result-descr"><?php echo TK_Convert::sql2Date($result_month->data_despesa, "/"); ?></div>
					<div class="result-descr"><?php echo $result_month->doc; ?></div>
		        	<div class="result-descr"><?php echo $result_month->nr_doc; ?></div>
		        	<div class="result-descr"><?php echo $result_month->pagamento; ?></div>
		        	<div class="result-descr historico"><?php echo $result_month->historico; ?></div>
		        	<div class="result-descr">R$ <?php echo TK_Convert::val_am2br($result_month->valor); ?></div>
		        	<div class="result-descr no-print"><a href="<?php echo admin_url("admin-ajax.php?action=delete_reg&table=gastos&id=$result_month->id&id_item=$id_item") ?>" class="delete" onclick="return confirm('Deseja realmente Excluir este registro?')">Deletar</a></div>
				</div>
				
				<?php $i++; endforeach; ?>
				
				<div class="group-descr">
					<div class="result-descr total">Total</div>
		        	<div class="result-descr total">R$ <?php echo TK_Convert::val_am2br(array_sum($sum_invoice)); ?></div>
				</div>
				
			</div>
			
		</div>
		
	<?php } ?>
	
		<div class="despesa">
			
			<div class="body_despesa">
								
				<div class="group-descr">
					<div class="result-descr total"><strong>ADIANTAMENTO</strong></div>
		        	<div class="result-descr total">R$ <?php echo TK_Convert::val_am2br($adiantamento); ?></div>
		        	
		        	<br />
					<div class="result-descr total"><strong>GASTOS GERAIS</strong></div>
		        	<div class="result-descr total">R$ <?php echo TK_Convert::val_am2br(array_sum($sum_invoice_all)); ?></div>
		        	<br />
		        	
		        	<div class="result-descr total">
		        		<strong>A DEVOLVER</strong>
		        	</div>
		        	<div class="result-descr total">R$ <?php echo TK_Convert::val_am2br($adiantamento-array_sum($sum_invoice_all)); ?></div>
		        	<div class="print rodape">
		        		<p class="data">
		        			Fortaleza-CE, <?php echo date('d/m/Y') ?>
		        		</p>
		        		<div class="signature">
		        			<strong>Marcus Vinicius F. Carneiro</strong>
		        		</div>
		        		<div class="importancia">
		        			Recebi a importância Acima: <span class="line">&nbsp;</span>
		        			<div class="data">
		        				Em ____/____/______
		        			</div>
		        		</div>
		        	</div>
				</div>
				
			</div>
			
		</div>
		 		
	<?php } else { ?>
	
		<p>Nenhuma Dispesa Registrada</p>
	
<?php } ?>