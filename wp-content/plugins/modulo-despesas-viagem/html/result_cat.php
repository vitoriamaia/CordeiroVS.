<?php
        
$select = TK_Core::select_table('despesas_categoria');
if ($select) { ?>
	
	<h2 id="titulo-fatura">Categorias Registradas</h2>

	<div class="expense">
		
		<?php foreach ($select as $result) : ?> 
			
			<form action="<?php echo admin_url('admin-ajax.php?action=save_category'); ?>" method="post" accept-charset="utf-8">
				<input type="text" name="id" value="<?php echo $result->id ?>" id="id" class="input-expense-id required" msn_validacao="Preencha esse campo." readonly="readonly" />
				<input type="text" name="categoria" value="<?php echo $result->categoria ?>" id="categoria" class="input-expense required" msn_validacao="Preencha esse campo." readonly="readonly" />
				<a href="#" class="button edit">editar</a>
				<a href="#" class="button salvar">salvar</a>
				<a href="<?php echo admin_url("admin-ajax.php?action=delete_reg&table=".$_GET['tab']."&id=$result->id") ?>" class="button delete" onclick="return confirm('Deseja realmente Excluir este registro?')">delete</a>
			</form>
		
		<?php endforeach; ?>
			
	</div>	

    <?php } else { ?>

	<p class="no-found">Nenhum Registrado Encontrado.</p>
	
<?php } ?>