<div class="wrap">

    <div class="record">
        <h2>Estatísticas</h2>
    </div>

    <?php

    # Tabs de Estatísticas
    $current = 'subscriber';
    $tabs = array( 'subscriber' => 'Por Assinante', 'provider' => 'Por Estabelecimento', 'category' => 'Por Praça (Categoria)' );

    if(isset($_GET['tab'])) {
        $current = $_GET['tab'];
    }

    ?>

    <!-- Criação das tabs propriamente ditas -->
    <h2 class="nav-tab-wrapper">
        <?php
            foreach( $tabs as $tab => $name ) :
                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                echo "<a class='nav-tab$class' href='?page=record-logs&tab=$tab'>$name</a>";
            endforeach;
        ?>
    </h2>


    <!-- Conteúdo das tabs -->
    <table class="form-table">

        <?php

        switch ( $current ){

            case 'subscriber' : ?>

                <tr>
                    <td>
                        <?php include_once ('includes/statistic-user.php'); ?>
                    </td>
                </tr>

                <?php
                break;

            case 'provider' : ?>

                <tr>
                    <td>
                        <?php include_once ('includes/statistic-provider.php'); ?>
                    </td>
                </tr>

                <?php
                break;

            case 'category' : ?>

                <tr>
                    <td>
                        <?php include_once ('includes/statistic-category.php'); ?>
                    </td>
                </tr>

                <?php
                break;
        }

        ?>

    </table>

</div>
