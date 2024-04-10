<?php
require "action.php"; $action = new Action();
$per_page = 25;
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Market Place | Project Hub</title>
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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
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

            .bor10 {
                border: 1px solid #e6e6e6;
                margin-top: 30px;
                padding-bottom: 40px;
                padding-top: 40px;
                padding: 40px;
                text-align: justify;
            }
            .bor15 {
                border-left: 1px solid #D0D0D0;
                border-right: 1px solid #D0D0D0;
                border-bottom: 1px solid #D0D0D0;
                margin-top: -20px;
            }
            .flex-sb-m {
                justify-content: space-between;
                align-items: center;
            }
            .flex-w, .flex-sb-m {
                flex-wrap: wrap;
                display: flex;
            }
            .p-lr-40 {
                padding-right: 40px;
                padding-left: 40px;
            }
            .p-b-15 {
                padding-top: 18px;
                padding-bottom: 15px;
            }
            .bor13 {
                border: 1px solid #e6e6e6;
                border-radius: 22px;
            }
            .size-117 {
                width: 250px;
                height: 45px;
            }
            .stext-104 {
                font-family: Poppins-Regular;
                font-size: 14px;
                line-height: 1.466667;
            }
            .cl2 {
                color: #333;
            }
            .m-r-10 {
                margin-right: 10px;
            }
            .m-tb-5 {
                margin-bottom: 5px;
                margin-top: 5px;
            }
            .p-lr-20 {
                padding-right: 20px;
                padding-left: 20px;
            }
            .hov_btn {
                background: #e6e6e6;
                border: 1px solid #e6e6e6;
                border-radius: 15px;
                width: 150px;
                height: 43px;
                margin-top: 5px;
                font-size: 18px;
                font-weight: bolder;
            }
            
            .hov_btn:hover {
                border-color: #717fe0;
                background-color: #717fe0;
                color: #fff;
            }
            .mtext-109 {
                font-family: Poppins-Bold;
                font-size: 20px;
                font-weight: bolder;
                line-height: 1.3;
                text-transform: uppercase;
            }
            .p-b-30, .p-b-13 {
                padding-bottom: 10px;
            }
            .bor12 {
                border-bottom: 1px dashed #d9d9d9;
                align-items: flex-start;
                flex-wrap: wrap;
                display: flex;
            }
            .size-208 {
                width: 34.5%;
            }
            .size-209 {
                width: 65.5%;
                margin-top: 8px;
                margin-right: -5px;
            }
            .mtext-110 {
                font-family: Poppins-Regular;
                font-size: 18px;
                line-height: 1.466667;
            }
            .stext-110 {
                font-family: Poppins-Medium;
                font-size: 18px;
                line-height: 1.466667;
            }
            .bor14 {
                border-radius: 25px;
                border: none;
            }
            .bg3 {
                background-color: #222;
            }
            .bg3:hover {
                text-decoration: none;
                color: #fff;
            }
            .size-116 {
                width: 100%;
                height: 50px;
            }
            .stext-101 {
                font-family: Poppins-Medium;
                font-size: 15px;
                line-height: 1.466667;
                text-transform: uppercase;
                font-weight: bold;
            }
            .cl0 {
                color: #fff;
            }
		</style>
		
    </head>

    <body>

        <!-- Begin page -->
			
		<div class="container">
			<div class="row mt-5">
				<div class="col-12">
				<div class="col-12 text-center">
					<h2><b>Confirm Your Order</b></h2>
				</div>
					
										
					<div class="row">
					
						<div class="col-md-12">
							<?php 
							
							if(count($_SESSION['cart']) > 0) {
								if(!isset($_SESSION["uid"])) { ?>
									<p style="font-size: 20px">Hey <b style="color: red">Guest!</b> <br/> Kindly sign up or login to complete your order</p>
								<?php } else {
										$userInfo = $action->userInfo($_SESSION["uid"]);
									?>
									<p style="font-size: 20px">Hey <b style="color: red"><?php echo $userInfo["name"];?></b>
									<br/> Your wallet balance is <b style="color: #000">&#8358;<?php echo number_format($userInfo["main_bal"], 2); ?></b></p>
									
								<?php } ?>
						</div>
						
						<div class="col-md-8">
							<div class="column counter-column col-lg-12 col-md-12" style="margin-bottom: 3%; background: #fff; border: 1px solid #c4c4c4">
								
								<table class="table table-bordered" style="margin-top: 1%">
									<tr>
										<th>Project Name</th>
										<th>Price</th>
										<th>Department</th>
										<th></th>
									</tr>
									<tr>
									<?php
										$ids = array();
											foreach($_SESSION['cart'] as $id=>$value){
												array_push($ids, $id);
											}
									
										$stmt = $action->readByIds($ids);
										$total=0;
										$item_count=0;
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											extract($row);
											$projName = strtoupper($row["project_name"]);
											$price = $row["price"];
											$id = $row["projectID"];
											
											$total += $price;
											
									?>
									<td> <?php echo $projName;?> </td>
									<td> &#8358;<?php echo number_format($price, 2);?> </td>
									<td> <?php echo $action->deptName($row["department"]);?> </td>
									
									<td>
										<mytag style="color: red; cursor: pointer" id='removeCart<?php echo $id;?>'><i class="ti-trash"></i></mytag>
									</td>
								</tr> 
								
									<script>
										$(document).ready(function() {
											$("#removeCart<?php echo $id;?>").click(function() {
												var btn = $("#removeCart<?php echo $id;?>");
												var id = <?php echo $id;?>;
												var material_name = "<?php echo $projName;?>";
												Swal.fire({
													title: "Delete From Cart",
													icon: "question",
													html: "You are about to delete <b>"+material_name+"</b> from your cart list",
													allowOutsideClick: false,
													showLoaderOnConfirm: true,
													showDenyButton: true,
													denyButtonText: "<i class='ti-trash'></i> Delete Cart",
													showConfirmButton: true,
												
												}).then((isDenied) => {
													
													var data = {
														delCart: "delCart",
														id: id
													}
													
													$.ajax({
														url: "addcart.php",
														data: data,
														type: "post",
														beforeSend: function() {
															btn.html("<i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
														},
														success: function(response) {
															btn.html('<i class="ti-trash"></i>').prop("disabled", false);
															if($.trim(response) == "success") {
															
																swal.fire({
																	title: "Success",
																	html: "<b>"+material_name+"</b> has been successfully removed from your cart list",
																	icon: "success"
																}).then(function() { 
																	window.location = "";
																})
															} else {
																swal.fire({
																	icon: 'error',
																	title: "Error",
																	html: response,
																	confirmButtonText: 'OK'
																});
															}
														}
													});
													
												});
											});
										});
									</script>
								
										<?php } ?>
								</table>
							</div>
						</div>
						<div class="col-md-4" style="background: #fff; border: 1px solid #c4c4c4; box-shadow: 0px 0px 20px rgba(0,0,0,0.10); padding: 40px 35px;">
							
								<h4 class="mtext-109 cl2 p-b-30">
									Cart Totals
								</h4>
        
								<div id="subtotal">    
									<div class="flex-w flex-t bor12 p-b-13">
										<div class="size-208">
											<span class="stext-110 cl2">
												Subtotal:
											</span>
										</div>
				
										<div class="size-209">
											<span class="mtext-110 cl2">
													&#8358;<?php echo number_format($total, 2);?>
											</span>
										</div>
									</div>
								</div>
													  
								<div id="total_fee">
									<div class="flex-w flex-t bor12 p-b-13">
										<div class="size-208">
											<span class="stext-110 cl2">
											   <b>Total: </b>
											</span>
										</div>
				
										<div class="size-209">
											<span class="mtext-110 cl2">
												<b>
													&#8358;<?php echo number_format($total, 2);?>
												</b>
											</span>
										</div>
									</div>
								</div>
								<br>
								
								<?php
								if(!isset($_SESSION["uid"])) { ?> 
									<br><b>Yet to login ?</b> kindly login or create an account to place your order<br><br>
										<a href="joinus" class="btn btn-danger btn-sm btn-block" style="font-size: 20px; margin-bottom: 10px">
											<b><i class="ti-user"></i>  Sign Up</b>
										</a>
									
										<a href="login" class="btn btn-primary btn-sm btn-block" style="font-size: 20px; margin-bottom: 10px">
											<b><i class="ti-plus"></i> Login </b>
										</a>
								<?php } else { ?>
								<button class="btn btn-primary btn-sm btn-block" onclick="makePay()" id="payBtn" style="font-size: 20px">
									<b><i class="ti-credit-card"></i>  Make Purchase</b>
								</button>
								<?php } ?>
								
								<script>
								
									function makePay() {
										// var walletBlc = <?php echo $userInfo["main_bal"];?>;
										var projectfee = <?php echo $total;?>;
										
										var data = {
											pay_project: "pay_project",
											amount: projectfee
										}
										
										Swal.fire({
											title: "Make Payment",
											icon: "info",
											html: "You're about to pay <b>N"+projectfee.toLocaleString()+"</b> for your cart item list",
											allowOutsideClick: false,
											showLoaderOnConfirm: true,
											showConfirmButton: true,
											showCancelButton: true,
											confirmButtonText: "<i class='ti-credit-card'></i> Make Payment"
										}).then((isPay) => {
											if(isPay.isConfirmed) {
												
												$("#payBtn").prop("disabled", true);
												
												$.ajax({
													url: "addcart.php",
													data: data,
													type: "post",
													beforeSend: function() {
														
													},
													success: function(response) {
														if($.trim(response) == "success") {
															swal.fire({
																title: "Success",
																html: "Payment successful, your download link has been sent to your email address",
																icon: "success"
															}).then(function() { 
																window.location = "account/dashboard";
															})
														} else if($.trim(response) == "insufficient") {
												
															$("#payBtn").prop("disabled", false);
												
															swal.fire({
																title: "Insufficient Balance",
																html: "Your wallet balance is not sufficient to complete this transaction",
																icon: "error"
															}).then(function() { 
																window.location = "account/fundWallet";
															})
														} else if($.trim(response) == "login_needed") {
												
															$("#payBtn").prop("disabled", false);
												
															swal.fire({
																title: "Unauthorized Access",
																html: "Your session has expired. Kindly proceed to login to continue",
																icon: "error"
															}).then(function() { 
																window.location = "login";
															})
														} else if($.trim(response) == "error_saving" ||$.trim(response) == "error") {
												
															$("#payBtn").prop("disabled", false);
												
															swal.fire({
																title: "Error",
																html: "We ran into an unknown error, please contact admin",
																icon: "error"
															})
															
														} else if($.trim(response) == "error_debit") {
												
															$("#payBtn").prop("disabled", false);
												
															swal.fire({
																title: "Wallet Error",
																html: "Error debiting wallet, please try again",
																icon: "error"
															})
															
														} else {
															
															$("#payBtn").prop("disabled", false);
															
															swal.fire({
																title: "Error Ocurred",
																html: response,
																icon: "error"
															})
														} 
													}												
												});
											}
											
										});
									}
								</script>
						</div>
							<?php } else { ?>
								<script>
									
								Swal.fire({
									title: "Shopping Cart",
									icon: "error",
									html: "Your shopping cart is empty, kindly add some material to your cart list",
									allowOutsideClick: false,
									showLoaderOnConfirm: true,
									showDenyButton: true,
									showConfirmButton: false,
									denyButtonText: "<i class='ti-shopping-cart'></i> Place Order",
								
								}).then((isDenied) => {
									window.location = "market";
								});
								
								</script>
								
							<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php require "shopcart.php";?>
		
        <script src="assets/js/vendor.min.js"></script>

        <script src="assets/libs/morris-js/morris.min.js"></script>
        <script src="assets/libs/raphael/raphael.min.js"></script>

        <script src="assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>
</html>