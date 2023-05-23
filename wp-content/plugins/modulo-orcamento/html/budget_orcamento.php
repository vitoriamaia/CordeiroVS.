<div class="wrap">

    <div class="form_expense">

        <h2>Or&ccedil;amento por período</h2>

        <h3 class="nav-tab-wrapper">
            <?php
            foreach( $tabs as $tab_n => $name ){
                $class = ( $tab_n == $tab ) ? 'nav-tab-active' : '';
                echo "<a class='nav-tab $class' href='?page=despesas&tab=$tab_n'>$name</a>";
            }
            ?>
        </h3>

    </div>

</div>