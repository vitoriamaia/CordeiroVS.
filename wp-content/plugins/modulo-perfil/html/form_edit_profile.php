<?php

$data = get_the_author_meta('nascimento', $authorid);
$dia = substr($data, 6, 2);
$mes = substr($data, 4, 2);
$ano = substr($data, 0, 4);
$data = $dia.'/'.$mes.'/'.$ano;

?>

<div class="form-edit">

    <div style="width: 100%; height: 30px;">&nbsp;</div>

    <form id="edit_profile" class="form-rev">
        <label class="label">                            
            <strong class="tit">Nome</strong>
            <input type="text" name="nome" class="input nome disabled" value="<?php the_author_meta( 'display_name', $authorid ); ?>" readonly="readonly" />
        </label>                    

        <label class="label">                            
            <strong class="tit">Telefone</strong>
            <input type="text" name="telefone" class="input telefone disabled" maxlength="13" value="<?php the_author_meta( 'telefone', $authorid ) ?>" readonly="readonly" OnKeyPress="formatar('## ####-#####', this)" />
        </label>

        <label class="label">
            <strong class="tit">CPF</strong>
            <input type="text" name="cpf" class="input cpf disabled" maxlength="14" value="<?php the_author_meta( 'cpf', $authorid ) ?>" readonly="readonly" OnKeyPress="formatar('###.###.###-##', this)" />
        </label>

        <label class="label">
            <strong class="tit">Nascimento</strong>
            <input type="text" name="nascimento" class="input nascimento disabled" maxlength="10" value="<?php echo $data; ?>" readonly="readonly" OnKeyPress="formatar('##/##/####', this)" />
        </label>

        <label class="label">
            <strong class="tit">Empresa</strong>
            <input type="text" name="empresa" class="input empresa disabled" maxlength="14" value="<?php the_author_meta( 'empresa', $authorid ) ?>" readonly="readonly" />
        </label>

        <label class="label">                            
            <strong class="tit">E-Mail</strong>
            <input type="text" name="email" class="input email disabled" value="<?php the_author_meta( 'user_email', $authorid ) ?>" readonly="readonly" />
        </label>

        <label class="label">                            
            <strong class="tit">Senha</strong>
            <input type="password" name="password" class="input password disabled" value="" readonly="readonly" />
        </label>                          

        <input type="button" class="update edit bt pull-right" value="EDITAR" style="" />
		<input type="button" class="update save bt pull-right" value="SALVAR" style="" />
		<div class="clr">&nbsp;</div>               
    </form>

</div>