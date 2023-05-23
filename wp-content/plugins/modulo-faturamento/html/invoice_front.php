<div class="invoice_wrap">
	
	<h3 class="title_invoice">
		Faturamento Anual de <?php echo date('Y'); ?>:
	</h3>
	
	<canvas id="GraficoBarra" style="width:100%;"></canvas>
	
	<form action="<?php echo get_home_url() ?>/relatorio" method="post" accept-charset="utf-8">
		<?php

			$authorid = get_current_user_id();
			$authorid = $authorid * 1000;
			$authorid = base64_encode($authorid);

		?>

		<input type="hidden" name="user" value="<?php echo $authorid; ?>">
		<h3 class="title_invoice top30">Criar Relatório por Período:</h3>
		<p>Data Inicial: <br /><input type="text" id="calendario-init" class="datas" name="data_init" /></p>
		<p>Data Final: <br /><input type="text" id="calendario-finish" class="datas" name="data_finish" /></p>
		<p>Enviar Consulta: <br /><input type="submit" id="push" value="Enviar" class="enviar" /></p>
		<div class="top30">&nbsp;</div>
	</form>
	
</div>