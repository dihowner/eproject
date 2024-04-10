<?php
require "action.php"; $action = new Action();
$per_page = 25;

$srchProj = $action->query("select * from market where projectID='".base64_decode($_REQUEST["pid"])."'"); $srchProj->execute();
$srchProjs = $srchProj->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title><?php echo $srchProjs["project_name"];?> | Project Hub</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
        <script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/project.js"></script>
		<style>
			.tryer {
				list-style-type: none;
				text-align: left;
				padding: 0px;
				margin: 0px;
			}
			.try a {
				display: block;
				color: #000;
				padding: 8px 16px;
				text-decoration: none;
				border-bottom: 1px solid #c4c4c4;
			}
			.fact-counter .column {
				position: relative;
				margin-bottom: 30px;
			}
			.fact-counter .column .inner {
				position: relative;
				text-align: center;
				padding: 40px 35px;
				border: 1px solid #e7e6e6;
				background-color: #ffffff;
				box-shadow: 0px 0px 20px rgba(0,0,0,0.10);
			}
			.post-meta-info {
    margin-top: 2%;
    margin-bottom: 10px;
    padding-left: 0;
    text-align: left;
}.post-meta-info li {
    font-size: 12px;
    display: inline-block;
    position: relative;
    margin-left: 20px;
    -moz-transition: all 0.9s ease;
    font-weight: 600;
    color: #5c5c5c;
}
.post-meta-info li a {
    color: #5c5c5c;
}
.post-title a:hover {
    color: #3F9B77;
    text-decoration: none;
}
.post-title {
    font-size: 1rem;
    text-align: justify;
    font-weight: bold;
    margin-bottom: 10px;
    margin-left: 20px;
}
		</style>
    </head>

    <body>

        <!-- Begin page -->
			
		<div class="container">
			<div class="row mt-5">
				<div class="col-12">
					
										
					<div class="row">
											
						<div class="col-md-8">
						
							<div class="column counter-column col-lg-12 col-md-12" style="margin-bottom: 3%; background: #fff; border: 1px solid #c4c4c4">
								<div style="font-size: 19px; text-transform: uppercase; padding: 25px 30px 20px; color: #372926">
									<h4><b style="border-bottom: 2px solid #f2f0f0;"><?php echo $srchProjs["project_name"];?></b></h4>
								</div>
								<p style="margin-left: 17px; font-size: 14px;"><?php echo nl2br($srchProjs["abstract"]);?></p>
								
								<hr/>
									
								<div style="text-align: left; line-height: 1.7; margin-left: 20px;">
									<b style="display: none; color: #000; font-size: 22px">Price &#8358;<?php echo number_format($srchProjs["price"]);?></b>
									<br>
									
									<button class="btn btn-warning btn-sm" style="margin-top: -10px; color: #000" disabled>
										<b>&#8358;<?php echo number_format($srchProjs["price"]);?></b>
									</button>
									
									<?php if (array_key_exists($srchProjs['projectID'], $_SESSION['cart'])) { ?>

											<button class="btn btn-warning btn-sm" style="margin-bottom: 10px" id="removeCart<?php echo $srchProjs['projectID'];?>">
												<b><i class="ti-trash"></i> Remove Item</b>
											</button>
										<?php } else { ?>
											<button class="btn btn-primary btn-sm" id="addcart<?php echo $srchProjs['projectID'];?>" style="margin-bottom: 10px"><i class="ti-shopping-cart-full"></i> Add To Cart </button>
										<?php } ?>
										<button class="btn btn-primary btn-sm" style="display: none; margin-bottom: 10px" id="addcart<?php echo $srchProjs['projectID'];?>"><i class="ti-shopping-cart-full"></i> Add To Cart </button>
										<button class="btn btn-danger btn-sm" style="display: none; margin-bottom: 10px" disabled id="addedCart<?php echo $srchProjs['projectID'];?>">
											<b><i class="ti-check"></i> Item Added</b>
										</button>
										<button class="btn btn-warning btn-sm" style="display: none; margin-bottom: 10px" id="removeCart<?php echo $srchProjs['projectID'];?>">
											<b><i class="ti-trash"></i> Remove Item</b>
										</button>
									
										<script>
											$(document).ready(function () {
												
												$("#addcart<?php echo $srchProjs['projectID'];?>").click(function(e) {
													e.preventDefault();
													var id = <?php echo $srchProjs['projectID'];?>;
													
													var data = {
														addCart: "addCart",
														quantity: 1,
														id: id
													}
													
													var btnAdd = $("#addcart<?php echo $srchProjs['projectID'];?>");
													var addedCart = $("#addedCart<?php echo $srchProjs['projectID'];?>"); //Show button on save to cart...
													var removeCart = $("#removeCart<?php echo $srchProjs['projectID'];?>"); //Show for removing cart...
													
													$.ajax({
														url: "addcart.php",
														data: data,
														type: "post",
														beforeSend: function () {
															btnAdd.html("<i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
														},
														success: function (msgs) {
															addedCart.show();
															btnAdd.hide();
															console.log(msgs);
														}
													})
												});
												
												$("#removeCart<?php echo $srchProjs['projectID'];?>").click(function(e) {
													e.preventDefault();
													
													var id = <?php echo $srchProjs['projectID'];?>;
													
													var data = {
														removeCart: "removeCart",
														quantity: 1,
														id: id
													}
													
													var btnAdd = $("#addcart<?php echo $srchProjs['projectID'];?>");
													var removeCart = $("#removeCart<?php echo $srchProjs['projectID'];?>"); //Show for removing cart...

													$.ajax({
														url: "addcart.php",
														data: data,
														type: "post",
														beforeSend: function () {
															btnAdd.html("<i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
														},
														success: function (msgs) {
															btnAdd.show().prop("disabled", false).html("<i class='ti-shopping-cart-full'></i> Add To Cart");
															removeCart.hide();
															console.log(msgs);
														}
													})
												
												});
											 });
										</script>
							
									
									<br><br>
								</div>
								
							</div>
						</div>
						<div class="col-md-4" style="height: 24%; background: #fff; border: 1px solid #c4c4c4; box-shadow: 0px 0px 20px rgba(0,0,0,0.10); padding: 40px 35px;">
							<h2 style="text-align: left"><b> Department </b></h2>
							
							<ul class="tryer">
									<?php 
									$loadDep = $action->query ("select * from department"); $loadDep->execute();
									while ($dapp = $loadDep->fetch(PDO::FETCH_ASSOC)) { ?>
										<li class="try"><a href="#home"><?php echo $dapp["dertmentName"]?></a></li>
									<?php } ?>
							</ul>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<br/><br/><br/><br/>
		<?php require "shopcart.php";?>
		
        <script src="assets/js/vendor.min.js"></script>

        <script src="assets/libs/morris-js/morris.min.js"></script>
        <script src="assets/libs/raphael/raphael.min.js"></script>

        <script src="assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>
</html>