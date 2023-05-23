<a href="#" class="cadastrar no-print">Cadastrar Nova Despesa</a>
			
<form action="<?php echo admin_url('admin-ajax.php?action=save_expense_item'); ?>" method="post" accept-charset="utf-8" class="form-expense no-print">
	<p>
		<label for="categoria">Categoria</label> <br />
		<select name="categoria" id="categoria" class="input-expense categoria required">
			<option value="">Selecione a Categoria</option>
			<?php
				global $wpdb;
				$select = Despesas::select_table('cat');
				if($select) :
					foreach ($select as $value) : 
						echo "<option value='$value->id'>$value->categoria</option>"; 
					endforeach; 
				endif;
			?>
		</select> 
	</p>
	<p>
		<label for="data_cat">Data da Despesa</label> <br />
		<input type="text" name="data_cat" value="" id="data_cat" class="input-expense data_cat required" /> 
	</p>
	<p>
		<label for="tipo_doc">Tipo de DOC</label> <br />
		<input type="text" name="tipo_doc" value="" id="tipo_doc" class="input-expense tipo_doc required" /> 
	</p>
	<p>
		<label for="nr_doc">NR DOC</label> <br />
		<input type="text" name="nr_doc" value="" id="nr_doc" class="input-expense nr_doc required" /> 
	</p>
	<p>
		<label for="forma_pagamento">Forma de Pagamento</label> <br />
		<input type="text" name="forma_pagamento" value="" id="forma_pagamento" class="input-expense forma_pagamento required" /> 
	</p>
	<p>
		<label for="historico">Hist&oacute;rico</label> <br />
		<input type="text" name="historico" value="" id="historico" class="input-expense historico required" /> 
	</p>
	<p>
		<label for="valor_item">Valor</label> <br />
		<input type="text" name="valor_item" id="valor_item" class="input-expense valor_item moeda validar-campo required" minlength="3" prefixo="R$ " decimal="," msn_validacao="Preencha esse campo." />
	</p>
	<p> 
		<input type="submit" id="incluir_reg" class="button" value="Incluir Nova Despesa" />
	</p>
	<input type="hidden" name="id_viagem" value="<?php echo $_GET['id'] ?>" id="id_viagem"/>
</form>