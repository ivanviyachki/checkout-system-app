<?php 

declare(strict_types = 1);

use Checkout_System\Database;
use Checkout_System\Product;

namespace Checkout_System;

class Checkout extends Database
{
    /**
	 * Array of products in the cart
	 *
	 * @var array of Product objects
	 */
    protected array $cart;

    /**
	 * Array of products quantity
	 *
	 * @var array
	 */
    protected array $quantity;

    /**
	 * Array sotore prices per product
	 *
	 * @var array
	 */
    protected array $totalPerProduct;

    public function __construct() 
    {
        parent::__construct();

        $this->cart = [];
        $this->quantity = [];
        $this->totalPerProduct = [];
    }

    /**
     * Method for processing checkout
     *
     * @param array $request_parameters request parameters.
     */
    public function checkout(array $request_parameters): void
    {   
        if ( isset($request_parameters['skus']) && ! in_array(null, $request_parameters['skus'])) {

            $this->scan($request_parameters['skus']);
            $total = $this->calculate_total($this->cart, $this->quantity);
            $orderId = $this->create_receipt($total);

            if ($orderId) {
                $this->render_receipt($orderId);
            } else {
                die('Fail to create receipt');
            }
        } else {
            require_once __DIR__ . '/../templates/empty_cart.php';
        }
    }

    /**
     * Adds an item to the cart
     *
     * @param array $products array of products to scan.
     */
    private function scan(array $products): void
    {   
        foreach ($products as $productSku) {
            if ($this->is_porduct_exists(strval($productSku))) {
                if (!array_key_exists($productSku, $this->cart)) {
                    $this->cart[$productSku] = new Product(strval($productSku));
                }
    
                if (array_key_exists($productSku, $this->quantity)) {
                    $this->quantity[$productSku] += 1;
                } else {
                    $this->quantity[$productSku] = 1;
                }
            } else {
                require_once(__DIR__ . '/../templates/invalid_product.php');
                die();
            }
        }
    }

    /**
     * Calculates the total price of all items in the cart
     * 
     * @param array $cart of Product objects.
     * @param array $quantity array of products quantity.
     * 
     * @return int
     */
    public function calculate_total(array $cart, array $quantity): int 
    {
        $totalPrice =  0;

        foreach ($cart as $key => $product) {
            $discount = $product-> getDiscount(); 

            $productPrice = 0;

            if ( ! empty($discount) && $quantity[$key] >= intval($discount[0])) {

                $numberOfSets = floor($quantity[$key] / $discount['0']);
                $productPrice += intval($discount[1] * $numberOfSets);
                
                $productsOutOfSet = intval($quantity[$key] % $discount['0']);
                if ($productsOutOfSet > 0) {
                    $totalPrice += $productsOutOfSet * $product->getPrice();
                }

            } else {
                $productPrice += intval($product->getPrice() * $quantity[$key]);
            }

            $this->totalPerProduct[$key] = $productPrice;

            $totalPrice += $productPrice;
        }
        return $totalPrice;
    }

    /**
     * Check if product exists
     * 
     * @param string $sku sku of the product.
     *
     * @return bool
     */
    public function is_porduct_exists(string $sku): bool 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            return false;
        } 

        $stmt = $mysqli->prepare("SELECT id FROM products WHERE sku=? LIMIT 1");
    
        $stmt->bind_param('s', $sku);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $mysqli->close();
            return true;
        } else {
            $mysqli->close();
            return false;
        }
    }

    /**
     * Method for create order
     * 
     * @param int $total total price of the order.
     *
     * @return int
     */
    public function create_receipt(int $total): int 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            die('Database connection error');
        }

        $stmt = $mysqli->prepare("INSERT INTO orders (total_price) VALUES (?)");
    
        $stmt->bind_param('i', $total);

        if ($stmt->execute()) {
            $orderId = $mysqli->insert_id;
        } else {
            $orderId = 0;
        }
        
        if ( ! empty($this->totalPerProduct)) {
            foreach($this->totalPerProduct as $key => $total) {
                if (array_key_exists($key,  $this->quantity) && array_key_exists($key,  $this->cart)) {
                    $this->add_order_meta($orderId, $this->cart[$key]->getSku(), $this->quantity[$key], $total);
                }
            }
        }

        $mysqli->close();

        return $orderId;
    }

    /**
     * Method for render receip
     *
     * @param int $orderId ID of the order.
     * 
     * @return void
     */
    public function render_receipt(int $orderId): void 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            die('Database connection error');
        }

        $stmt = $mysqli->prepare("SELECT o.id, o.total_price, om.item_sku, om.quantity, om.total_price
                FROM orders as o 
                LEFT JOIN order_meta as om
                ON o.id = om.order_id
                WHERE o.id=?"
            );
    
        $stmt->bind_param('i', $orderId);
        
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $data[] = $row;
        }
        
        $mysqli->close();

        require_once(__DIR__ . '/../templates/receipt.php');
    }

    /**
     * Method to add order meta
     * 
     * @param int $orderId total price of the order.
     * @param string $sku the sku of the product.
     * @param int $quantity units that ordered from this product.
     * @param int $total total price of units that sell.
     *
     * @return void
     */
    public function add_order_meta(int $orderId, string $sku, int $quantity, int $total): void 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            die('Database connection error');
        }

        $stmt = $mysqli->prepare("INSERT INTO order_meta (order_id, item_sku, quantity, total_price) VALUES (?, ?, ?, ?)");
    
        $stmt->bind_param('isii', $orderId, $sku, $quantity, $total);
        
        $stmt->execute();
       
        $mysqli->close();
    }
}