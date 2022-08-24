<?php 
 /* @var array $data*/
?>
<html>
	<head>
   		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    	<script
			  src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
			  integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
			  crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<style>
			.entry:not(:first-of-type)
			{
				margin-top: 10px;
			}
			.glyphicon
			{
				font-size: 15px;
			}
			.input-group button {
				margin-left:10px
			}
			.navbar .btn-outline-success{
				border-color: #674399;
				color: #674399;
			}
			.navbar .btn-outline-success:hover{
				background-color: #674399;
				color: white;
			}
			.main h1{
				text-align:center;
				margin-bottom: 40px;
    			font-size: 54px;
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

		<div class="container main" style="max-width:800px; margin-top:130px">
			<div class="row">
				
				<h1 class="">Receipt</h1>
				<div class="col-md-6">
					<div class="billed"><span class="font-weight-bold text-uppercase">Order ID: </span><span class="ml-1"><?php echo !empty($data[0][0]) ? $data[0][0] : ''; ?></span></div>
				</div>
			</div>
			<div class="mt-3">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Product</th>
								<th>Unit</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($data as $unitInformation) : ?>
							<tr>
								<td><?php echo !empty($unitInformation[2]) ? $unitInformation[2] : '' ?></td>
								<td><?php echo !empty($unitInformation[3]) ? $unitInformation[3] : '' ?></td>
								<td><?php echo !empty($unitInformation[4]) ? $unitInformation[4] : '' ?></td>
							</tr>
							<?php endforeach ?>
							<tr>
								<td></td>
								<td>Total</td>
								<td><?php echo !empty($data[0][1]) ? $data[0][1] : '' ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>