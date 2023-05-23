<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Form_Search_Ads
{

    public static function init()
    {
        add_shortcode('form_search_ads', array(__CLASS__, 'form_search'));
    }

    public static function form_search()
    { ?>

        <form role="search" method="get" action="<?php echo home_url('/'); ?>/listagem/" class="form-search-main">
            <div class="row">
                <div class="col-md-2">
                    &nbsp
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="input-group input-group-district">
                        <span class="input-group-addon btn-district" id="basic-addon3">
                            <strong>Bairro: </strong>
                        </span>
                        <select name="local" class="form-control" id="district-select" aria-describedby="basic-addon3">
                            <?php

                            $args = array(
                                'taxonomy' => array('local'),
                                'parent'   => 13
                            );

                            $term_query = new WP_Term_Query($args);

                            $term_find = (isset($_GET['local'])) ? (int) $_GET['local'] : '';

                            $selected = (empty($term_find)) ? 'selected="selected"' : '';
                            echo "<option value='' $selected>-- Todos --</option>";

                            foreach ($term_query->terms as $local) {
                                $selected = ($term_find == $local->term_id) ? 'selected="selected"' : '';
                                echo "<option value='$local->term_id' $selected>$local->name</option>";
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <div class="input-group">
                        <?php $val_search = (isset($_GET['establishment'])) ? $_GET['establishment'] : ''; ?>
                        <input type="search" class="form-control" name="establishment" id="s" title="Pesquisar"
                               placeholder="Encontre os melhores locais pertinho de você"
                               value="<?php echo $val_search ?>" />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-send">Procurar</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-2">
                    &nbsp
                </div>
            </div>
        </form>

        <?php
    }

}

Form_Search_Ads::init();