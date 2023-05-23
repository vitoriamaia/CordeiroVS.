<?php

	$msg = array("Você não preencheu as informações de datas", "Você não inseriu a data inicial");
	
	if(empty($_POST)) {

		$msg = $msg[0];	

	} else if(empty($_POST["data_init"])) {

		$msg = $msg[1];

	} else {

		$msg = "";

	}
	
	if(!empty($msg)) : echo "<p class='errormsg'>".$msg."</p>"; else :
		
		$dataInit = $_POST["data_init"];
		
		if(!empty($_POST["data_finish"])){
			$dataFinish = $_POST["data_finish"];
		} else {
			$dataFinish = date('d/m/Y');
		}
		
		$dataInit = TK_Convert::date2Sql($dataInit);
		$dataFinish = TK_Convert::date2Sql($dataFinish);

		$user = $_POST["user"];
		$user = base64_decode($user)/1000;
		
		global $wpdb;
		$table = Faturamento::table();
		$result = $wpdb->get_results("SELECT MONTH(data) as Mes, YEAR(data) as Ano, Fatura FROM $table WHERE data BETWEEN $dataInit AND $dataFinish AND empresa = '$user' ORDER BY Ano, Mes ASC", OBJECT);

?>

		<div class="head_invoice">
			<div class="head_invoice_title company">Empresa: <?php $meta = get_user_meta($user, 'empresa'); echo $meta[0]; ?> <span class="printer">&nbsp;</span></div>
			<div class="head_invoice_title cnpj">CNPJ: <?php $meta = get_user_meta($user, 'cnpj'); echo $meta[0]; ?> </div>
		</div>
		
		<div class="body_invoice">
							
			<div class="descr-invoice group-descr">
				<div class="item-descr result-descr total mes">Mês</div>
            	<div class="item-descr result-descr total valor">Faturamento</div>
			</div>
			
			<?php
				$sum_invoice = array();
				foreach($result as $result_month) :
				$sum_invoice[] = $result_month->Fatura;
			?>
		
			<div class="group-descr">
				<div class="result-descr mes"><?php echo TK_Convert::month2Nom($result_month->Mes)." de ".$result_month->Ano; ?></div>
	        	<div class="result-descr valor">R$ <?php echo TK_Convert::val_am2br($result_month->Fatura); ?></div>
			</div>
			
			<?php endforeach; ?>
			
			<div class="group-descr">
				<div class="result-descr mes total">Total</div>
	        	<div class="result-descr valor total">R$ <?php echo TK_Convert::val_am2br(array_sum($sum_invoice)); ?></div>
			</div>
			
			<div class="group-signature no-screen">
				<div class="local">
					Fortaleza, <?php echo date('d')." de ". TK_Convert::month2Nom(date('n')) ." de ". date('Y'); ?>
				</div>

				<div class="signature accountant">
					<!--img src="<?php '\images\assinatura.jpg'; ?>" alt="Assinatura" class="assinatura" /-->
					<span class="span">Contador</span>
				</div>

	        	<div class="signature customer">
	        		<span class="span">Responsável</span>
	        	</div>
			</div>
			
		</div>
		
		<script type="text/javascript" charset="utf-8">
			printer();
			
			jQuery('.head_invoice_title .printer').on('click', function(){
				printer();
			});
			
			function printer(){
				window.print();
			}
		</script>
		
<?php endif; ?>
	