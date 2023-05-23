<?php global $post; ?>

<form name="cadastro-de-banda" action="<?php the_permalink(); ?>"
      method="POST" enctype="multipart/form-data" class="insert_post col-md-12">

    <div class="row">

        <?php do_action('mipe-notice'); ?>

        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control required" required id="establishment"
                       placeholder="Nome do estabelecimento" name="establishment">
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-group">
                <input type="text" class="form-control required" required id="establishment_address"
                       placeholder="Endereço" name="establishment_address">
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <input type="number" class="form-control required" required id="establishment_number_address"
                       placeholder="Número" name="establishment_address_number">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <select required="required" name="establishment_local" id="establishment_local"
                        class="form-control required">
                    <?php

                    $args = array(
                        'taxonomy' => 'local',
                        'hide_empty' => 0,
                        'child_of' => 13,
                    );

                    $categories = get_terms($args);

                    echo "<option value=''>Bairro</option>";

                    foreach ($categories as $category) {
                        echo "<option value='" . $category->term_id . "'>" . $category->name . "</option>";
                    }

                    echo "<option value='-1'>Outro</option>";

                    ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <?php

                $args = array(
                    'taxonomy' => 'categoria',
                    'name' => 'establishment_cat',
                    'id' => 'establishment_cat',
                    'class' => 'form-control required',
                    'show_option_none' => 'Categoria do estabelecimento',
                    'option_none_value' => '',
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'value_field' => 'term_id',
                    'hide_empty' => 0,
                    'required' => true,
                );

                wp_dropdown_categories($args);

                ?>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <textarea class="form-control" id="establishment_content" placeholder="Descrição da empresa"
                          name="establishment_content" rows="10"></textarea>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <input type="file" class="btn btn--blue" name="image_logo" id="image_logo"
                       value="Logo da empresa"/>
                <?php wp_nonce_field('image_logo', 'image_logo_nonce'); ?>
                <small style="color: red;">Somente arquivos no formato .jpg, .jpeg ou .png</small>
                <br/><br/>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <input type="submit" class="btn btn--yellow" value="Cadastrar Estabelecimento"/>
        </div>

    </div>

    <input type="hidden" name="action" value="insert_post_external"/>
    <?php wp_nonce_field('new-post'); ?>

</form>