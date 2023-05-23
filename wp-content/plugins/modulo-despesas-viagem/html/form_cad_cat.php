<a href="#" class="cadastrar">Cadastrar Nova Categoria</a>
			
<form action="<?php echo admin_url('admin-ajax.php?action=save_category'); ?>" method="post" accept-charset="utf-8" class="form-expense">
	<p>
		<label for="categoria">Insira o Nome da Categoria</label> <br />
		<input type="text" name="categoria" value="" id="categoria" class="input-expense required" msn_validacao="Preencha esse campo." />
	</p>
	<p> 
		<input type="submit" id="incluir_reg" class="button" value="Incluir Nova Categoria" />
	</p>
</form>