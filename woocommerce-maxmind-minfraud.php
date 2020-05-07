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
    public static $path;

    public static function whats_that($thing, $echo="true", $title="")
    {
        if (!$echo) {
            ob_start();
        }
        echo "<h1>". $title . "</h1>";
        echo "<pre>";
        print_r($thing);
        echo "</pre>";

        if (!$echo) {
            $content = ob_get_clean();
            $myfile = fopen( plugin_dir_path( __FILE__ ) . "debug.html", "a") or die("Unable to open file!" );
            $txt = $content;
            fwrite($myfile, $txt);
            fclose($myfile);
        }
    }

    public function __construct()
    {
        //create path var
        self::$path = plugin_dir_path(__FILE__);
        $this->load_dependencies();
        // echo "<h1>". get_option( "wc_settings_tab_demo_title" ) . "</h1>";
        // add_action('woocommerce_checkout_create_order', array( $this, "minfraud_check_order" ), 10, 2 );
        add_action('woocommerce_checkout_update_order_meta', array( $this, "minfraud_check_order" ), 10, 2 );
        // add_filter('woocommerce_thankyou', array( $this, "update_order_status" ), 10, 2 );
    }

    public function load_dependencies()
    {
        //require composer autoload
        require 'vendor/autoload.php';
        require(plugin_dir_path(__FILE__) . 'admin/admin.php');
        require(plugin_dir_path(__FILE__) . 'includes/fraudcheck.php');
    }

    public function minfraud_check_order($order, $data)
    {

      //create minfraud object
      $min_fraud = new WMMMF_Fraudcheck();

        // $this->whats_that($order, false, "order");
        // $this->whats_that(wc_get_order( $order ), false, "order");
        // $this->whats_that($data, false, "data");

        //start gathering data from order to make maxmind call
        $device_info = array();
        // $device_info['ip_address'] = get_post_meta( $order, '_customer_ip_address', true );
        $device_info['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $min_fraud->set_device($device_info);
        $min_fraud->get_score();
    }

    public function update_order_status($order_id)
    {
        if (! $order_id) {
            return;
        }

        $order = wc_get_order($order_id);

        $this->whats_that($order, false, "order from thank you page");

        // $order->update_status('completed', "this is a test note");
        return $order_id;
    }
}

new Woocommerce_Maxmind_Minfraud();
