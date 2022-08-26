<?php

declare(strict_types = 1);

use Checkout_System\Rest;
use Checkout_System\Products;
use Checkout_System\Checkout;

namespace Checkout_System;

/**
 * Class responsible for routers.
 */
class Router 
{
    /**
	 * Constant for POST and GET methods
	 */
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';

    /**
	 * Array of all registered Handlers
	 *
	 * @var array
	 */
    private $handler;

    /**
	 * Handler for 404
	 *
	 * @var mixed
	 */
    private $notFoundHandler;

    public function __construct() 
    {
        $this->get('/', function () {
            require_once(__DIR__ . '/../templates/checkout.php');
        });
        
        $this->post('/',Checkout::class . '::checkout');
        
        $this->post('/import', Rest::class . '::import');
                
        $this->get('/products', Products::class . '::render');
        
        $this->addNotFoundHandler( function () {
            require_once(__DIR__ . '/../templates/404.php');
        });
    }

	/**
	 * Set routing for GET method.
	 *	
	 * @param  string $path routing path.
	 * @param  mixed $handler handler function.
	 *
     * @return void
	 */
    public function get(string $path, $handler): void
    {
        $this->addHandler($path, self::METHOD_GET, $handler);
    }
    
    /**
	 * Set routing for POST method.
	 *	
	 * @param  string $path routing path.
	 * @param  mixed $handler handler function.
	 *
     * @return void
	 */
    public function post(string $path, $handler): void 
    {
        $this->addHandler($path, self::METHOD_POST, $handler);
    }

    /**
	 * Add handler.
	 *	
	 * @param  string $path routing path.
     * @param  string $method type of method.
	 * @param  mixed $handler handler function.
	 *
     * @return void
	 */
    private function addHandler(string $path, string $method, $handler): void 
    {   
        $this->handler[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler   
        ];
    }

    /**
	 * Add not found handler.
	 *	
	 * @param  mixed $handler handler function.
	 *
     * @return void
	 */
    public function addNotFoundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }

    /**
	 * Method for handle routing and execute callback function.
	 *
     * @return void
	 */
    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = null;

        foreach ($this->handler as $handler) {
            if ($handler['path'] === $requestPath && $handler['method'] === $method) {
                $callback = $handler['handler'];
            }
        }

        if (is_string($callback)) {
            
            $parts = explode('::', $callback);

            if (is_array($parts)) {
                $className = array_shift($parts);
                $handler = new $className;

                $method = array_shift($parts);
                $callback = [$handler, $method]; 
            }
        }

        if (!$callback) {
            header('HTTP/1.0 404 Not Found');
            if(! empty($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;   
            }
        }

        call_user_func_array($callback,[
            array_merge( $_GET, $_POST)
        ]); 
    }
}
