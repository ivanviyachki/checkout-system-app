<?php
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
				<h1>Checkout Form</h1>
			</div>
			<div class="row">
				<form role="form" action="/" method="post">
					<div id="myRepeatingFields">
						<div class="entry input-group col-xs-3">
							<input class="form-control" name="skus[]" type="text" placeholder="Product SKU" />
							<span class="input-group-btn">
								<button type="button" class="btn btn-success btn-lg btn-add">
									<span class="glyphicon glyphicon-plus" aria-hidden="true">+</span>
								</button>
							</span>
						</div>
					</div>
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="margin-top: 20px !important">Checkout</button>
				</form>
				<br>
			</div>
		</div>
		<script>
			$(function()
			{
				$(document).on('click', '.btn-add', function(e)
				{
					e.preventDefault();
					var controlForm = $('#myRepeatingFields:first'),
						currentEntry = $(this).parents('.entry:first'),
						newEntry = $(currentEntry.clone()).appendTo(controlForm);
					newEntry.find('input').val('');
					controlForm.find('.entry:not(:last) .btn-add')
						.removeClass('btn-add').addClass('btn-remove')
						.removeClass('btn-success').addClass('btn-danger')
						.html('<span class="glyphicon glyphicon-minus">-</span>');
				}).on('click', '.btn-remove', function(e)
				{
					e.preventDefault();
					$(this).parents('.entry:first').remove();
					return false;
				});
			});
		</script>
	</body>
</html>