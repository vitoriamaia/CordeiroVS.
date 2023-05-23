<?php

$select = Despesas::select_table('viagem');
if ($select) { ?>
	
	<h2 id="titulo-despesa">Viagens Registradas</h2>

	<div class="expense">
		
		<table class="expense-table">
			
			<thead>
				<tr>
					<td class="top-table-expense"> <strong>Identificador</strong> </td>
					<td class="top-table-expense"> <strong>Destino</strong> </td>
					<td class="top-table-expense"> <strong>Assunto</strong> </td>
					<td class="top-table-expense"> <strong>Empresa</strong> </td>
					<td class="top-table-expense"> <strong>Funcionário</strong> </td>
					<td class="top-table-expense no-print"> <strong>A&ccedil;&atilde;o</strong> </td>
				</tr>
			</thead>
			
			<tbody>
				<?php $i = 0; foreach ($select as $result) : ?>
				
				<tr class="<?php echo $i%2 == 0 ? 'linha-preta' : 'linha-branca'; ?>">
				
					<?php
					echo "<td> $result->identificador </td>";
					echo "<td> $result->destino </td>";
					echo "<td> $result->assunto </td>";
					echo "<td> $result->empresa </td>";
					echo "<td>" . Despesas::user_by_id($result->funcionario) . "</td>";
					echo "<td class='no-print'>";
					?>
						<a href="?page=despesas&tab=edit_itens&id=<?php echo $result->id; ?>" class="button edit-viagem">editar</a>
						<a href="<?php echo admin_url("admin-ajax.php?action=delete_reg&table=".$_GET['tab']."&id=$result->id") ?>" class="button delete" onclick="return confirm('Deseja realmente Excluir este registro?')">delete</a>			
					<?php 
				
				echo "</td></tr>";

				$i++; endforeach; ?>
			</tbody>
				
		</table>

	</div>	

    <?php } else { ?>

	<p class="no-found">Nenhum Registrado Encontrado.</p>
	
<?php } ?>