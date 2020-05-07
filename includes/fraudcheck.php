<?php
use MaxMind\MinFraud;

/**
 * takes an array of order details and sends them to maxmind fraudcheck for a score
 */
class WMMMF_Fraudcheck
{
    public $mf;
    public $request;

    public function __construct()
    {
        # The constructor for MinFraud takes your account ID, your license key, and
        # optionally an array of options.
        $this->mf = new MinFraud(get_option("WMMMF_account_ID"), get_option("WMMMF_license_key"));
        // echo "<h1>" . get_option("WMMMF_account_ID") . "</h1>";
        // echo "<h1>" . get_option("WMMMF_license_key") . "</h1>";
        // $this->check_score();
        // $this->set_billing([]);
        // $this->set_device([]);
        // $this->get_score();
    }

    public function set_billing($array)
    {
      $this->request = $this->mf->withBilling($array);
    }

    public function set_device($array)
    {
      $this->request = $this->mf->withDevice($array);
    }

    public function check_score()
    {
        # Note that each ->with*() call returns a new immutable object. This means
        # that if you separate the calls into separate statements without chaining,
        # you should assign the return value to a variable each time.
        $this->request = $this->mf->withDevice([
              'ip_address'  => '81.2.69.160',
              'session_age' => 3600.5,
              'session_id'  => 'foobar',
              'user_agent'  =>
                  'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36',
              'accept_language' => 'en-US,en;q=0.8',
          ])->withEvent([
              'transaction_id' => 'txn3134133',
              'shop_id'        => 's2123',
              'time'           => '2012-04-12T23:20:50+00:00',
              'type'           => 'purchase',
          ])->withAccount([
              'user_id'      => 3132,
              'username_md5' => '4f9726678c438914fa04bdb8c1a24088',
          ])->withEmail([
              'address' => 'test@maxmind.com',
              'domain'  => 'maxmind.com',
          ])->withBilling([
              'first_name'         => 'First',
              'last_name'          => 'Last',
              'company'            => 'Company',
              'address'            => '101 Address Rd.',
              'address_2'          => 'Unit 5',
              'city'               => 'New Haven',
              'region'             => 'CT',
              'country'            => 'US',
              'postal'             => '06510',
              'phone_number'       => '323-123-4321',
              'phone_country_code' => '1',
          ])->withShipping([
              'first_name'         => 'ShipFirst',
              'last_name'          => 'ShipLast',
              'company'            => 'ShipCo',
              'address'            => '322 Ship Addr. Ln.',
              'address_2'          => 'St. 43',
              'city'               => 'Nowhere',
              'region'             => 'OK',
              'country'            => 'US',
              'postal'             => '73003',
              'phone_number'       => '403-321-2323',
              'phone_country_code' => '1',
              'delivery_speed'     => 'same_day',
          ])->withPayment([
              'processor'             => 'stripe',
              'was_authorized'        => false,
              'decline_code'          => 'invalid number',
          ])->withCreditCard([
              'issuer_id_number'        => '323132',
              'last_4_digits'           => '7643',
              'bank_name'               => 'Bank of No Hope',
              'bank_phone_country_code' => '1',
              'bank_phone_number'       => '800-342-1232',
              'avs_result'              => 'Y',
              'cvv_result'              => 'N',
          ])->withOrder([
              'amount'           => 323.21,
              'currency'         => 'USD',
              'discount_code'    => 'FIRST',
              'is_gift'          => true,
              'has_gift_message' => false,
              'affiliate_id'     => 'af12',
              'subaffiliate_id'  => 'saf42',
              'referrer_uri'     => 'http://www.amazon.com/',
          ])->withShoppingCartItem([
              'category' => 'pets',
              'item_id'  => 'leash-0231',
              'quantity' => 2,
              'price'    => 20.43,
          ])->withShoppingCartItem([
              'category' => 'beauty',
              'item_id'  => 'msc-1232',
              'quantity' => 1,
              'price'    => 100.00,
          ]);
        $scoreResponse = $this->request->score();

        echo "<pre>";
        print_r($scoreResponse);
        echo "</pre>";
        print($scoreResponse->riskScore . "<br>");

    }

    function get_score()
    {
      $scoreResponse = $this->request->score();

      Woocommerce_Maxmind_Minfraud::whats_that($scoreResponse, true, "maxmind score");
    }
}

$min_fraud = new WMMMF_Fraudcheck();
$min_fraud->set_billing([
    'first_name'         => 'First',
    'last_name'          => 'Last',
    'company'            => 'Company',
    'address'            => '101 Address Rd.',
    'address_2'          => 'Unit 5',
    'city'               => 'New Haven',
    'region'             => 'CT',
    'country'            => 'US',
    'postal'             => '06510',
    'phone_number'       => '323-123-4321',
    'phone_country_code' => '1',
]);

$min_fraud->set_device([
      'ip_address'  => '81.2.69.160',
  ]);

  // $min_fraud->get_score();
