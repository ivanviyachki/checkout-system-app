<?php 

declare(strict_types = 1);

namespace Checkout_System;

use Checkout_System\Products;

/**
 * Handle REST API calls
 */
class Rest 
{
    /**
	 * WooCommerce shop URL
	 *
	 * @var string
	 */
    private string $woocommerce_url;

    /**
	 * WooCommerce API consumer key
	 *
	 * @var string
	 */
    private string $consumer_key;

    /**
	 * WooCommerce API consumer secret
	 *
	 * @var string
	 */
    private string $consumer_secret;
    
    public function __construct()
    {
        $this->woocommerce_url = 'https://dev.meta365.eu/';
        $this->consumer_key = 'ck_223bf529c3bbd67f56a4d6107edc9cfad9a518d5';
        $this->consumer_secret = 'cs_54d8e79392013e62069bb34e031e667ec5f97cf1';
    }

    /**
     * Method used to import products from database to WooCommerce shop.
     *
     * @return void 
     */
    public function import(): void
    {
        $products = new Products;

        $failed = false;
        
        $products_to_import = $products->getAllProducts();

        foreach ($products_to_import as $product) {
            $status = $this->import_product(strval($product['name']), intval($product['unit_price']));

            if (!$status) {
                $failed = true;
            }
        }

        require_once(__DIR__ . '/../templates/import.php');
    }

    /**
     * Method used to import product to WooCommerce shop.
     *
     * @param  string $name routing path.
	 * @param  int $price handler function.
     * 
     * @return bool 
     */
    private function import_product(string $name, int $price): bool
    {
        $service_url = $this->woocommerce_url . 'wp-json/wc/v3/products';

        $curl = curl_init($service_url);

        $curl_post_data = array(
            'name' => $name,
            'regular_price' => $price, 
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->consumer_key . ":" . $this->consumer_secret);  
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

        $curl_response = curl_exec($curl);

        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('Error during curl exec: ' . var_export($info));
        }

        curl_close($curl);

        $decoded = json_decode($curl_response);

        if (isset($decoded->data->status)) {
           return false;
        }
        
        return true;
    }
}