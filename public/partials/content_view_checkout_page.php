<?php
$cart = Commercioo\Cart::get_carts();
$comm_unique_number_label = (!empty(get_option('comm_unique_number_label')))?get_option('comm_unique_number_label'):"Kode Unik";
$comm_unique_number_type = (!empty(get_option('comm_unique_number_type')))?get_option('comm_unique_number_type'):"increase";
$unique = isset( $cart['unique_code']['amount'] )? $cart['unique_code']['amount'] : null;
$unique_number = $unique;
?>
<div class="commercioo-checkout-summary-item-wrapper">
	<div class="commercioo-checkout-summary-item">
		<div class="summary-item-single">
			<div class="unique-label">
				<label class="label-item-product"><?php echo esc_html($comm_unique_number_label); ?></label>
			</div>
			<div class="unique-price">
				<label class="label-item-product">
					<?php echo esc_html($unique_number); ?>
				</label>
			</div>
		</div>
	</div>
</div>