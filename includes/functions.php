<?php
/**
* Registro de acciones y funciones del plugin
*
* @package    zalemto-editor
* @subpackage zalemto-editor/includes
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
*
*/


$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes');

public function register_shortcodes() {
	add_shortcode('wpc-products', array($this, 'get_products_display'));
	add_shortcode('wpc-editor', array($this, 'get_editor_shortcode_handler'));
	
	add_shortcode('wpd-products', array($this, 'get_products_display'));
	add_shortcode('wpd-editor', array($this, 'get_editor_shortcode_handler'));
}

/**
 * Prueba de funcion que dibuja el boton
 */
function get_products_display($atts) {
	
	extract(shortcode_atts(array(
		'cat' => '',
		'products' => '',
		'cols' => '3'
					), $atts, 'wpc-products'));

	$where = "";
	if (!empty($cat)) {
		$where.=" AND $wpdb->term_relationships.term_taxonomy_id IN ($cat)";
	} else if (!empty($products))
		$where.=" AND p.ID IN ($products)";
	else
		$where = "";
	$search = '"is-customizable";s:1:"1"';

	$products = $wpdb->get_results(
			"
						SELECT distinct p.id
						FROM $wpdb->posts p
						JOIN $wpdb->postmeta pm on pm.post_id = p.id
						INNER JOIN $wpdb->term_relationships ON (p.ID = $wpdb->term_relationships.object_id	) 
						WHERE p.post_type = 'product'
						AND p.post_status = 'publish'
						AND pm.meta_key = 'wpc-metas'
						$where
						AND pm.meta_value like '%$search%'
						");
	ob_start();
	?>
	<div class='container wp-products-container wpc-grid wpc-grid-pad'>
		<?php
		$shop_currency_symbol = get_woocommerce_currency_symbol();
		foreach ($products as $product) {
			$prod = wc_get_product($product->id);
			$url = get_permalink($product->id);
			$wpd_product = new WPD_Product($product->id);
			$wpc_metas = $wpd_product->settings;
			$can_design_from_blank = get_proper_value($wpc_metas, 'can-design-from-blank', "");
			$template_pages_urls = $this->get_template_pages($product->id, $prod, $wpc_metas);
			?>
			<div class='wpc-col-1-<?php echo $cols; ?> cat-item-ctn'>
				<div class='cat-item'>
					<h3><?php echo $prod->get_title(); ?> 
						<span><?php echo $shop_currency_symbol . '' . $prod->get_price() ?></span>
					</h3>
					<?php echo get_the_post_thumbnail($product->id, 'medium'); ?>
					<hr>
					<?php
					if ($prod->get_type() == "simple") {
						if (!empty($can_design_from_blank)) {
							?><a href="<?php echo $wpd_product->get_design_url() ?>" class='btn-choose wpc-customize-product'> <?php _e("Design from blank", "wpd"); ?></a><?php
						}
						if (array_key_exists($product->id, $template_pages_urls)) {
							$templates_page_url = $template_pages_urls[$product->id];
							echo '<a href="' . $templates_page_url . '" class="btn-choose tpl"> ' . __("Browse our templates", "wpd") . '</a>';
						}
					} else {
						?><a href="<?php echo $url; ?>" class='btn-choose wpc-customize-product'> <?php _e("Design from blank", "wpd"); ?></a><?php
						$variations = $prod->get_available_variations();
						foreach ($variations as $variation) {
							$variation_id = $variation['variation_id'];
							if (array_key_exists($variation_id, $template_pages_urls) || array_key_exists($product->id, $template_pages_urls)) {
								echo '<a href="' . $url . '" class="btn-choose tpl" id="btn-tpl"> ' . __("Browse our templates", "wpd") . '</a>';
								break;
							}
						}
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}