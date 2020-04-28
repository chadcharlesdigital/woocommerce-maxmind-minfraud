<?php
/**
 * Plugin Name:       Woocommerce Maxmind Minfraud
 * Plugin URI:
 * Description:       Use Maxmind Minfraud score to do things with orders
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Chad Charles
 **/
 use MaxMind\MinFraud;


/**
 *
 */
class Woocommerce_Maxmind_Minfraud
{

  function __construct()
  {
    $this->load_dependencies();
    // echo "<h1>". get_option( "wc_settings_tab_demo_title" ) . "</h1>";
  }

  public function load_dependencies()
  {
    //require composer autoload
    require 'vendor/autoload.php';
    require ( plugin_dir_path( __FILE__ ) . 'admin/admin.php');
    require ( plugin_dir_path( __FILE__ ) . 'includes/fraudcheck.php');
  }
}

new Woocommerce_Maxmind_Minfraud;
