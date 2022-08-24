<?php 
    /* @var array $products*/
?>
<html>
	<head>
   		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

        <style>
            .main h1{
                text-align: center;
                margin-bottom: 40px;
                font-size: 54px;
            }
            .navbar .btn-outline-success{
				border-color: #674399;
				color: #674399;
			}
			.navbar .btn-outline-success:hover{
				background-color: #674399;
				color: white;
			}
        </style>   
	</head>
	<body>
        <div class="navigation">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 25px 15%;">
                <a class="navbar-brand" href="/">Checkout System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                    <a class="nav-link" href="/">Checkout</a>
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link" href="/products">Products</a>
                    </li>
                </ul>
                <form class="form-inline align-items-end my-2 my-lg-0 woo" style="margin-left: 60%;" action="/import" method="post">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Import to WooCommerce</button>
                </form>
                </div>
            </nav> 
        </div> 

		<div class="container main" style="margin-top:130px">
            <h1>Products</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Price</th>
                        <th scope="col">Special Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $products as $product ) :?>
                        <tr>
                        <th><?php echo $product['id'];?></th>
                        <th><?php echo $product['name'];?></th>
                        <th><?php echo $product['sku'];?></th>
                        <th><?php echo $product['unit_price'];?></th>
                        <th><?php echo $product['special_price'];?></th>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
		</div>
	</body>
</html>