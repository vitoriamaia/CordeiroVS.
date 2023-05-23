<form method="post" action="<?php echo admin_url('admin-ajax.php?action=coupon_down'); ?>">
    <fieldset>
        <div>
            <input type="text" placeholder="Insira o cupom" name="coupon" class="coupon">
        </div>
        <div>
            <input type="hidden" name="permalink" value="<?php echo get_permalink(); ?>" />
            <input type="submit" value="Dar Baixa em Cupom" class="submit-coupon">
        </div>
    </fieldset>
</form>