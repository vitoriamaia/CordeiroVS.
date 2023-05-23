<?php
add_action('admin_menu','options_admin');

function options_admin () { 
    add_menu_page(
    'Exportar Contatos',             
    'Exportar Contatos',
    'administrator',
    'export_contact',
    'opcoes'
    );
}

function opcoes() { ?>
	
    <div class="wrap">

        <h2>Exportar Formul&aacute;rio de Cadastro</h2>

            <h3>Voc&ecirc; possue <strong><?php echo Tao_Form::reg_num(); ?></strong> registro(s)</h3>

            <?php if(isset($_GET['m']) == 'del' ) : ?>

                <div id="message" class="updated below-h2">
                    <p>Registros deletados com sucesso.</p>
                </div>
            
            <?php endif; ?>

            <p class="link delete_contact">
                <a href="<?php echo admin_url('admin-ajax.php?action=exportMysqlToCsv'); ?>" class="button"> Exportar Dados </a>
            </p>

            <p class="link delete_contact">
                <a href="<?php echo admin_url('admin-ajax.php?action=delete_mails'); ?>" class="button" onclick="return confirm('Deseja realmente deletar os registros?');"> Deletar Registros </a>
            </p>

    </div>

<?php } ?>