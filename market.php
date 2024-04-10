<?php
require "action.php"; $action = new Action();

$per_page = 10;
if(isset($_GET["currentpage"])) {
	$page = $_GET["currentpage"];
} else  {
	$page = 1;
}
$start_page = ($page-1) * $per_page;
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
				<div class="col-12 text-center">
					<h2><b>Market Place</b></h2>
				</div>
					
										
					<div class="row">
					
						<div class="col-lg-12">
							<form class="form mt-4 mt-lg-0" method="get">
								<div class="form-group">
									<label class="control-label mt-3 mt-lg-0" for="example-input1-group2" style="font-size: 22px"><b>Find a material</b></label>
									<div class="input-group">
										<input type="text" name="projName" class="form-control form-control-lg" placeholder="Search">
										<span class="input-group-prepend">
											<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
										</span>
									</div>
								</div>
							</form>
						</div>
						
						<div class="col-md-8">
						<?php
					    $start_page = ($page-1) * $per_page;
						if(isset($_REQUEST["projName"])) {
							$projName = $_REQUEST["projName"];
							// $query = "select * from market where status = 1 and project_name like '%$projName%' or abstract like '%$projName%' or proj_doc like '%$projName%' ORDER BY projectID desc";
							$query = "select * from market where project_name like '%$projName%' or abstract like '%$projName%' or proj_doc like '%$projName%' ORDER BY projectID desc";
							echo "<p style='color: #000'><b>You search for : </b>".$projName."</p>";
						} else if(isset($_REQUEST["deptID"])) {
							$deptID = $_REQUEST["deptID"];
							// $query = "select * from market where status = 1 and department='$deptID' ORDER BY projectID desc";
							$query = "select * from market where department='$deptID' ORDER BY projectID desc";
						} else {
							// $query = "select * from market where status = 1 ORDER BY projectID desc";
							$query = "select * from market ORDER BY projectID desc";
						}
						
						$loadMrket = $action->query($query . " limit $start_page, $per_page"); $loadMrket->execute();
						 
						$next = 1;
						
						while ($dapp = $loadMrket->fetch(PDO::FETCH_ASSOC)) {
					        $depatID = $dapp["department"];
					        
					        //we need to get department name with the id
					        $loadDept = $action->query ("select * from department where id='$depatID'"); $loadDept->execute();
					        $dept = $loadDept->fetch(PDO::FETCH_ASSOC);
					        $deptName = $dept["dertmentName"];
						?>
							<div class="column counter-column col-lg-12 col-md-12" style="margin-bottom: 3%; background: #fff; border: 1px solid #c4c4c4">
								<div class="inner" style="">
									<ul class="post-meta-info">
										<li>
											<a href="?<?php echo strtolower($dapp["degree_awarded"]);?>"> <i class="ti-user"></i> <?php echo strtoupper($dapp["degree_awarded"]);?> PROJECT </a>
										</li>
										  
									   <li>
											 <a href="?deptID=<?php echo $dapp["department"];?>">
												<i class="ti-file"></i>
												<?php echo strtoupper($deptName);?>
		
											</a>
										</li>
										<li>
											<i class="ti-time"></i> <?php echo $dapp["date"];?>
										</li>
									</ul>
									
									<h3 class="post-title">
										<a href="projectInfo?pid=<?php echo base64_encode($dapp['projectID']);?>"> <?php echo $dapp["project_name"];?> </a>
									</h3>
									
									<div style="text-align: left; line-height: 1.7; margin-left: 20px;">
										<?php echo substr($dapp["abstract"], 0 ,255)."...";?>
										<br>
										<b style="display: none; color: #000; font-size: 22px">Price &#8358;<?php echo number_format($dapp["price"]);?></b>
										<br>
										
										<button class="btn btn-warning btn-sm" style="margin-top: -10px; color: #000" disabled>
											<b>&#8358;<?php echo number_format($dapp["price"]);?></b>
										</button>
										
										<?php if (array_key_exists($dapp['projectID'], $_SESSION['cart'])) { ?>

            									<button class="btn btn-warning btn-sm" style="margin-bottom: 10px" id="removeCart<?php echo $dapp['projectID'];?>">
            										<b><i class="ti-trash"></i> Remove Item</b>
            									</button>
											<?php } else { ?>
												<button class="btn btn-primary btn-sm" id="addcart<?php echo $dapp['projectID'];?>" style="margin-bottom: 10px"><i class="ti-shopping-cart-full"></i> Add To Cart </button>
											<?php } ?>
											<button class="btn btn-primary btn-sm" style="display: none; margin-bottom: 10px" id="addcart<?php echo $dapp['projectID'];?>"><i class="ti-shopping-cart-full"></i> Add To Cart </button>
											<button class="btn btn-danger btn-sm" style="display: none; margin-bottom: 10px" disabled id="addedCart<?php echo $dapp['projectID'];?>">
        										<b><i class="ti-check"></i> Item Added</b>
        									</button>
        									<button class="btn btn-warning btn-sm" style="display: none; margin-bottom: 10px" id="removeCart<?php echo $dapp['projectID'];?>">
        										<b><i class="ti-trash"></i> Remove Item</b>
        									</button>
										
										
										<a href="projectInfo?pid=<?php echo base64_encode($dapp['projectID']);?>" class="btn btn-primary btn-sm" style="border-color: #3F9B77; background-color: #3F9B77; margin-bottom: 10px">
											Continue Reading <i class="ti-arrow-right"></i>
										</a>
										<br><br>
									</div>
								</div>
							</div>
							
							<?php
							if(($next++ % 2) == 0) {
								if(isset($_REQUEST["deptID"])) {
									$deptID = $_REQUEST["deptID"];
									$srchAd = $action->query("Select * from ads where department='$deptID' order by rand() limit 1");
								} else {
									$srchAd = $action->query("Select * from ads order by rand() limit 1");
								} 
								$srchAd->execute();
								while($srchAds = $srchAd->fetch(PDO::FETCH_ASSOC)) {
									$adsName = $srchAds["name"];
									
									if(!empty($srchAds["images"])) { ?>
										<a href="<?php echo $srchAds["url"];?>" title="Visit Website" target="_blank">
											<img src="uploads/ads/<?php echo $srchAds["images"]; ?>" class="img img-fluid" style="width: 735px; height: 350px; margin-bottom: 3%;"/>
										</a>
									<?php } else { ?>
										
										<a href="<?php echo $srchAds["url"];?>" title="Visit Website" style="color: #000" target="_blank">
											<div class="column counter-column col-lg-12 col-md-12" style="margin-bottom: 3%; background: #fff; border: 1px solid #c4c4c4">
												<div class="inner" style="">
													<h2><?php echo $srchAds["name"];?></h2>
													<?php echo nl2br(substr($srchAds["content"],0, 500));?>
													<br><br>
													<a href="<?php echo $srchAds["url"];?>" class="btn btn-primary btn-sm" title="Visit Website" style="border-color: #3F9B77; background-color: #3F9B77; margin-bottom: 10px">
														<b><i class="fa fa-globe"></i> Visit Website </b>
													</a>
													<br><br>
												</div>
											</div>
										</a>
									<?php }
								}
							}
							?>
							
							
							<script>
        					    $(document).ready(function () {
        					        
        					        $("#addcart<?php echo $dapp['projectID'];?>").click(function(e) {
        					            e.preventDefault();
        					            var id = <?php echo $dapp['projectID'];?>;
										
										var data = {
											addCart: "addCart",
											quantity: 1,
											id: id
										}
										
										var btnAdd = $("#addcart<?php echo $dapp['projectID'];?>");
										var addedCart = $("#addedCart<?php echo $dapp['projectID'];?>"); //Show button on save to cart...
										var removeCart = $("#removeCart<?php echo $dapp['projectID'];?>"); //Show for removing cart...
										
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
        					        
									$("#removeCart<?php echo $dapp['projectID'];?>").click(function(e) {
        					            e.preventDefault();
										
										var id = <?php echo $dapp['projectID'];?>;
										
										var data = {
											removeCart: "removeCart",
											quantity: 1,
											id: id
										}
										
										var btnAdd = $("#addcart<?php echo $dapp['projectID'];?>");
										var removeCart = $("#removeCart<?php echo $dapp['projectID'];?>"); //Show for removing cart...

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
							
							
						<?php } ?>	
							
							
							<div class="col-lg-12 text-center">
								<?php
								if(isset($_REQUEST["deptID"])) {
									$href = "deptID=".$_REQUEST["deptID"]."&";
								} else if(isset($_REQUEST["projName"])) {
									$href = "projName=".$_REQUEST["projName"]."&";
								} else { $href = ''; }
								
								echo $action->paginate($href, $query); ?>
							</div>
							
						</div>
						<div class="col-md-4" style="height: 24%; background: #fff; border: 1px solid #c4c4c4; box-shadow: 0px 0px 20px rgba(0,0,0,0.10); padding: 40px 35px;">
							<h2 style="text-align: left"><b> Department </b></h2>
							
							<ul class="tryer">
								<?php 
								$loadDep = $action->query ("select * from department"); $loadDep->execute();
								while ($dapps = $loadDep->fetch(PDO::FETCH_ASSOC)) { ?>
									<li class="try"><a href="?deptID=<?php echo $dapps["id"];?>"><?php echo $dapps["dertmentName"];?></a></li>
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