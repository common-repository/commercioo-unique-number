<?php
/**
 * The WordPress customizer-specific functionality of the plugin.
 */
class Commercioo_Unique_Number_Customizer {
    /**
     * The ID of this plugin.
     *
     * @since    0.0.1
     * @access   private
     * @var      string $unique_number_customizer The ID of this plugin.
     */
    private $unique_number_customizer;

    /**
     * The version of this plugin.
     *
     * @since    0.0.1
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;
    /**
     * Initialize the class and set its properties.
     *
     * @since    0.0.1
     */
    public function __construct($unique_number_customizer, $version) {
        $this->unique_number_customizer = $unique_number_customizer;
        $this->version 	  = $version;
    }
    /**
     * Set default value settings
     * Customizing ▸ Commercioo Checkout ▸ Unique Number Settings
     */
    public function commercioo_set_default_settings(){
        $comm_unique_number_visibility_value = get_option("comm_unique_number_visibility");
        if(!$comm_unique_number_visibility_value){
            add_option("comm_unique_number_visibility","active");
        }

        $comm_unique_number_type_value = get_option("comm_unique_number_type");
        if(!$comm_unique_number_type_value){
            add_option("comm_unique_number_type","increase");
        }

        $comm_unique_number_label_value = get_option("comm_unique_number_label");
        if(!$comm_unique_number_label_value){
            add_option("comm_unique_number_label","Kode Unik");
        }
    }
    /**
     * Register Unique Number Settings WP Customizer for chckout page
     * only visible on frontend checkout page
     * Customizing ▸ Commercioo Checkout ▸ Unique Number Settings
     */
    public function checkout_customizer( $wp_customize )
    {
        // base commercioo plugin must be installed
        if (!defined("COMMERCIOO_PATH")) return;

        // include text editor custom control
        require_once COMMERCIOO_PATH . 'includes/class-text-editor-custom-control.php';

        do_action("commercioo_set_default_settings");

        // add section
        $wp_customize->add_section( 'commercioo_customize_unique_number_checkout' , array(
            'title'	   => __( 'Unique Number Settings', 'commercioo' ),
            'priority' => 181,
            'panel'	   => 'commercioo_customize_checkout_settings',
        ) );


        // Defined: Type Unique Number (Increase or Decrease)
        $option_key_unique_number_type = 'comm_unique_number_type';
        $wp_customize->add_setting( $option_key_unique_number_type, array(
            'default' 	 => 'increase',
            'type' 		 => 'option', // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, $option_key_unique_number_type, array(
            'label'    => __( 'Increase / Decrease', 'commercioo-unique-number' ),
            'settings' => $option_key_unique_number_type,
            'section'  => 'commercioo_customize_unique_number_checkout',
            'description' => __( 'Increase = Add a unique number to the total price, Decrease = Decrease the total price with a unique number', 'commercioo' ),
            'type'	   => 'select',
            'choices'  => array(
                'increase' => __( 'Increase', 'commercioo-unique-number' ),
                'decrease'  => __( 'Decrease', 'commercioo-unique-number' )
            ),
        ) ) );

        // Defined: Unique Number Visibility (Active or Inactive)
        $option_key_unique_number_visibility = 'comm_unique_number_visibility';
        $wp_customize->add_setting( $option_key_unique_number_visibility, array(
            'default' 	 => 'active',
            'type' 		 => 'option', // you can also use 'theme_mod'
            'capability' => 'edit_theme_options',
        ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, $option_key_unique_number_visibility, array(
            'label'    => __( 'Active / Inactive', 'commercioo-unique-number' ),
            'settings' => $option_key_unique_number_visibility,
            'section'  => 'commercioo_customize_unique_number_checkout',
            'description' => __( 'Active = Show the unique 3 digits number', 'commercioo' ),
            'type'	   => 'select',
            'choices'  => array(
                'active' => __( 'Active', 'commercioo-unique-number' ),
                'inactive'  => __( 'Inactive', 'commercioo-unique-number' )
            ),
        ) ) );

        // Defined: Unique Number Label (Default: Kode Unik)
        $option_key_comm_unique_number_label = 'comm_unique_number_label';
        $wp_customize->add_setting( $option_key_comm_unique_number_label, array(
            'default' 	 => 'Kode Unik',
            'type' 		 => 'option', // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, $option_key_comm_unique_number_label, array(
            'label'       => __( 'Unique Number Label', 'commercioo' ),
            'settings'    => $option_key_comm_unique_number_label,
            'section'     => 'commercioo_customize_unique_number_checkout',
            'type'        => 'text',
            'input_attrs' => array( 'placeholder' => 'Unique Number' ),
        ) ) );
    }
}
