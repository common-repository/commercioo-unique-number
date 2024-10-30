<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.0.1
 *
 */

/**
 * The public-facing functionality of the plugin.
 *
 *
 * @author     Your Name <email@example.com>
 */
class Commercioo_Unique_Number_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $commercioo_unique_number    The ID of this plugin.
	 */
	private $commercioo_unique_number;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $commercioo_unique_number       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $commercioo_unique_number, $version ) {

		$this->commercioo_unique_number = $commercioo_unique_number;
		$this->version = $version;

	}

    /**
     * @param string $cart
     * @param string $view
     * Add Unique to Order Summary at Checkout or Cart
     */
    public function commercioo_unique_number($cart=''){
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            return;
        }
        $comm_unique_number_visibility = get_option('comm_unique_number_visibility');
        if($comm_unique_number_visibility == 'inactive') {
            return;
        }
        /**
         * Check if subtotal is below 0, than return false;
         */
        if ( Commercioo\Cart::get_total() <= 0) {
            return;
        }
        if ( Commercioo\Cart::is_empty() ) {
            return;
        }
        global $comm_options;

        if($cart){
            if(array_key_exists("unique_code",$cart)){
                $unique_number = $this->commercioo_check_get_uqcodes();
                Commercioo\Cart::set_unique_number($unique_number);
            }else{
                $unique_number = $this->commercioo_check_get_uqcodes();
                Commercioo\Cart::set_unique_number($unique_number);
            }
        }
    }
    /**
     * Display unique number on checkout order summary
     */
    public function commercioo_view_unique_number(){
        $comm_unique_number_visibility = get_option('comm_unique_number_visibility');
        if($comm_unique_number_visibility == 'inactive') {
            return;
        }
        include_once COMMERCIOO_UNIQUE_NUMBER_PATH .'public/partials/content_view_checkout_page.php';
        ob_start();
        $content = ob_get_clean();
        echo $content;
    }
    /**
     * Generate Unique Number.
     *
     * @since    0.0.1
     */
    public function commercioo_check_get_uqcodes(){
        global $wpdb;
        $comm_unique_number_type = (!empty(get_option('comm_unique_number_type')))?get_option('comm_unique_number_type'):"increase";
        $cart = Commercioo\Cart::get_carts();
        $uqMin =  1;
        $uqMax = 999;

        $sql ="
SELECT p.`ID`, oim.`meta_value` `unique_code`
FROM `{$wpdb->prefix}posts` p
LEFT JOIN `{$wpdb->prefix}postmeta` oim
  ON (
    p.`ID` = oim.`post_id`
    AND oim.`meta_key` = '_unique_code'
  )
WHERE `post_type`='comm_order'
  AND `post_status` IN (
    'comm_pending', 'comm_processing'
  )
  AND `post_date` = DATE(NOW())
LIMIT 0, {$uqMax}";

        $unique = null;
        $results = $wpdb->get_results($sql, OBJECT);
        $uqCodes = [];
        $loopCount = 0;
        if($results) {
            foreach ($results as $meta) {
                if (empty($meta->unique_code) && $meta->unique_code != '0') continue;
                $uqCodes[] = $meta->unique_code;
            }
            while (empty($unique) && ++$loopCount <= count($uqCodes)) {
                if ($comm_unique_number_type == 'decrease') {
                    if(isset($cart['unique_code']['amount'])){
                        $unique = $cart['unique_code']['amount'];
                    }else{
                        $unique = mt_rand($uqMin, $uqMax);
                    }
                    if(in_array($unique,$uqCodes)){
                        $unique = mt_rand($uqMin, $uqMax);
                    }
                }else{
                    if(isset($cart['unique_code']['amount'])){
                        $unique = $cart['unique_code']['amount'];
                    }else{
                        $unique = mt_rand($uqMin, $uqMax);
                    }

                    if(in_array($unique,$uqCodes)){
                        $unique = mt_rand($uqMin, $uqMax);
                    }
                }

                $unique = !empty($uqCodes) && in_array($unique, $uqCodes) ? null : $unique;
            }
        }
        if($unique == 0 || $unique == null) {
            if ($comm_unique_number_type == 'decrease') {
                if (isset($cart['unique_code']['amount'])) {
                    $unique = $cart['unique_code']['amount'];
                } else {
                    $unique = mt_rand($uqMin, $uqMax);
                }
                if (in_array($unique, $uqCodes)) {
                    $unique = mt_rand($uqMin, $uqMax);
                }
            } else {
                if (isset($cart['unique_code']['amount'])) {
                    $unique = $cart['unique_code']['amount'];
                } else {
                    $unique = mt_rand($uqMin, $uqMax);
                }
                if (in_array($unique, $uqCodes)) {
                    $unique = mt_rand($uqMin, $uqMax);
                }
            }
        }
        return $unique;
    }
    /**
     * Save datas into post_meta table.
     *
     * @param  array $args value with columns key.
     * @param int  $order_id  order_id.
     */
    public function commercioo_update_post_meta($args=array(),$order_id=0){
        if($order_id !=0) {
            if(class_exists("\Commercioo\Cart")) {
                $comm_unique_number_visibility = get_option('comm_unique_number_visibility');
                if (\Commercioo\Cart::has_unique_number() && $comm_unique_number_visibility == 'active') {
                    $cart = \Commercioo\Cart::get_data_unique_number();
                    $unique = $cart['amount'];
                    $type = $cart['type'];
                    $label = $cart['name'];
                    update_post_meta($order_id, '_unique_code', $unique);
                    update_post_meta($order_id, '_unique_type_code', $type);
                    update_post_meta($order_id, '_unique_label_code', $label);
                }
            }
        }
    }
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Commercioo_Unique_Number_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Commercioo_Unique_Number_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->commercioo_unique_number, plugin_dir_url( __FILE__ ) . 'css/commercioo-unique-number-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Commercioo_Unique_Number_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Commercioo_Unique_Number_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->commercioo_unique_number, plugin_dir_url( __FILE__ ) . 'js/commercioo-unique-number-public.js', array( 'jquery' ), $this->version, false );

	}

}
