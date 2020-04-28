<?php
use MaxMind\MinFraud;

/**
 * class that controls the admin interface
 */
class WMMMF_Admin
{
    public function __construct()
    {
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50);
        add_action( 'woocommerce_settings_tabs_woocommerce_maxmind_minfraud', array($this, 'settings_tab') );
        add_action( 'woocommerce_update_options_woocommerce_maxmind_minfraud', array($this, 'update_settings') );
    }

    public function add_settings_tab($settings_tabs)
    {
        $settings_tabs['woocommerce_maxmind_minfraud'] = __('Maxmind MinFraud', 'woocommerce');
        return $settings_tabs;
    }

    public function settings_tab()
    {
        woocommerce_admin_fields($this->get_settings());
    }
    public function update_settings()
    {
        woocommerce_update_options($this->get_settings());
    }

    public function get_settings()
    {
        $settings = array(
          'section_title' => array(
              'name'     => __('Maxmind Minfraud For Woocommerce', 'woocommerce'),
              'type'     => 'title',
              'desc'     => 'Reduce fraud in your store',
              'id'       => 'wc_settings_tab_demo_section_title'
          ),
          'account_ID' => array(
              'name' => __('Account ID', 'woocommerce'),
              'type' => 'text',
              'desc' => __('Maxmind Account/User ID found in your maxmind account', 'woocommerce'),
              'id'   => 'WMMMF_account_ID'
          ),
          'description' => array(
              'name' => __('License Key', 'woocommerce'),
              'type' => 'text',
              'desc' => __('License key generated on the backend', 'woocommerce'),
              'id'   => 'WMMMF_license_key'
          ),
          'section_end' => array(
               'type' => 'sectionend',
               'id' => 'wc_settings_tab_demo_section_end'
          )
        );
        return $settings;
        // return apply_filters('wc_settings_tab_demo_settings', $settings);
    }
}

new WMMMF_Admin();
