<a href="#" class="cadastrar">Cadastrar Nova Viagem</a>
			
<form action="<?php echo admin_url('admin-ajax.php?action=save_expense'); ?>" method="post" accept-charset="utf-8" class="form-expense">
	<p>
		<label for="destino">Insira o destino</label> <br />
		<input type="text" name="destino" value="" id="destino" class="input-expense required" msn_validacao="Preencha esse campo." />
	</p>
	<p>
		<label for="data_ida">Data de Ida</label> <br />
		<input type="text" name="data_ida" value="" id="data_ida" class="input-expense data_ida required" /> 
	</p>
	<p>
		<label for="data_volta">Data de Volta</label> <br />
		<input type="text" name="data_volta" value="" id="data_volta" class="input-expense data_volta required" /> 
	</p>
	<p>
		<label for="assunto">Assunto</label> <br />
		<input type="text" name="assunto" value="" id="assunto" class="input-expense assunto required" /> 
	</p>
	<p>
		<label for="empresa">Empresa</label> <br />
		<input type="text" name="empresa" value="" id="empresa" class="input-expense empresa required" /> 
	</p>
	<p>
		<label for="funcionario">Funcionário</label> <br />
		<select name="funcionario" id="funcionario" class="input-expense funcionario required">
			<option value="">Selecione o Funcionário</option>
			<?php echo Despesas::users(); ?>
		</select> 
	</p>
	<p>
		<label for="adiantamento">Adiantamento</label> <br />
		<input type="text" name="adiantamento" id="adiantamento" class="input-expense adiantamento moeda validar-campo required" minlength="3" prefixo="R$ " decimal="," msn_validacao="Preencha esse campo." />
	</p>
	<p> 
		<input type="submit" id="incluir_reg" class="button" value="Incluir Nova Viagem" />
	</p>
	<input type="hidden" name="identificador" value="<?php echo date("Y/dm.His") ?>" id="identificador"/>
</form>