<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Short_Code_Popup
{

    public static function init()
    {
        add_action('wp_footer', array(__CLASS__, 'popup_html'));
    }

    public static function popup_html()
    {
        $args = array(
            'post_type' => 'popup',
            'showposts' => 1
        );

        $popups = get_posts($args);

        if (!empty($popups)) {

            foreach ($popups as $popup) { ?>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $popup->post_title; ?></h4>
                            </div>
                            <div class="modal-body">
                                <?php echo apply_filters('the_content', $popup->post_content); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var cookie = document.cookie;
                    cookie = cookie.indexOf('popup');

                    if(cookie == -1){
                        jQuery(window).load(function () {
                            jQuery('#myModal').modal('show');
                        });
                        document.cookie = "popup";
                    }
                </script>

            <?php }

        }

    }

}

Short_Code_Popup::init();

?>