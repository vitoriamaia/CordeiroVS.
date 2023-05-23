<div class="wrap">
    <h2>Configurações Gerais da Lista</h2>

    <form method="post" action="options.php" novalidate="novalidate">

        <?php settings_fields('options_store_settings'); ?>
        <?php do_settings_sections('options_store_settings'); ?>

        <table class="form-table">
            <tbody>

            <tr>
                <th scope="row">
                    <label for="email_pagseguro">E-mail do PagSeguro</label>
                </th>
                <td>
                    <input name="email_pagseguro"
                           type="text"
                           id="email_pagseguro"
                           value="<?php echo esc_attr(get_option('email_pagseguro')); ?>"
                           class="regular-text"/>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="token_pagseguro">
                        Token do PagSeguro
                    </label>
                </th>
                <td>
                    <input name="token_pagseguro"
                           type="text"
                           id="token_pagseguro"
                           value="<?php echo esc_attr(get_option('token_pagseguro')); ?>"
                           class="regular-text"/>
                    <p class="description">
                        Por favor digite seu token do PagSeguro. É necessário para processar o pagamento e as
                        notificações de status da compra. <br/>
                        É possível gerar um novo token
                        <a href="https://pagseguro.uol.com.br/integracao/token-de-seguranca.jhtml">aqui</a>.
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="message_congratulations">
                        Mensagem após o pagamento
                    </label>
                </th>
                <td>
                    <input name="message_congratulations"
                           type="text"
                           id="message_congratulations"
                           value="<?php echo esc_attr(get_option('message_congratulations')); ?>"
                           class="regular-text"/>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="enable_ratification">
                        Habilitar ambiente de homologação
                    </label>
                </th>
                <td>
                    <?php $option = get_option('enable_ratification'); ?>
                    <input type="checkbox"
                           name="enable_ratification"
                           id="enable_ratification"
                           value="on" <?php echo (!empty($option)) ? "checked=checked" : ""; ?> />
                    <p class="description">Ativar ambiente de homologação</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="token_pagseguro_sendbox">
                        Token do Sendbox PagSeguro (homologa&ccedil;&atilde;o)
                    </label>
                </th>
                <td>
                    <input name="token_pagseguro_sendbox"
                           type="text"
                           id="token_pagseguro_sendbox"
                           value="<?php echo esc_attr(get_option('token_pagseguro_sendbox')); ?>"
                           class="regular-text"/>
                    <p class="description">
                        Por favor digite seu token do sendbox PagSeguro. É necessário para habilitar o ambiente de
                        homologação. <br/>
                        É possível gerar um novo token sendbox
                        <a href="https://sandbox.pagseguro.uol.com.br/vendedor/configuracoes.html">
                            aqui
                        </a>.
                    </p>
                </td>
            </tr>

            </tbody>
        </table>

        <?php submit_button(); ?>

    </form>
</div>