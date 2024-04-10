<?php
require "../action.php"; $action = new Action();
$uid = $_SESSION["uid"];
if(empty($uid)) {
	$action->redirect_to("../login");
	die();
} else {
	$srchAdm = $action->query("select * from secret where id='$uid'"); $srchAdm->execute();
	$srchAdms = $srchAdm->fetch(PDO::FETCH_ASSOC);
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>General Settings | Project Hub</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">
        <!-- App css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="../assets/images/avatar-1.jpg" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                    <?php echo ucfirst($srchAdms["username"]);?>  <i class="mdi mdi-chevron-down"></i> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
						
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-outline"></i>
                                <span>Profile</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-settings-outline"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-lock-outline"></i>
                                <span>Lock Screen</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout-variant"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a href="javascript:void(0);" class="nav-link right-bar-toggle">
                            <i class="mdi mdi-settings-outline noti-icon"></i>
                        </a>
                    </li>


                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="index.html" class="logo text-center logo-dark">
                        <span class="logo-lg">
                            <img src="../assets/images/logo-dark.png" alt="" height="26">
                            <!-- <span class="logo-lg-text-dark">Simple</span> -->
                        </span>
                        <span class="logo-sm">
                            <img src="../assets/images/logo-sm.png" alt="" height="22">
                        </span>
                    </a>

                    <a href="index.html" class="logo text-center logo-light">
                        <span class="logo-lg">
                            <img src="../assets/images/logo-light.png" alt="" height="26">
                        </span>
                        <span class="logo-sm">
                            <img src="../assets/images/logo-sm.png" alt="" height="22">
                        </span>
                    </a>
                </div>
				
                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
				</ul>
				
            </div>
			
<div class="left-side-menu">


                <div class="user-box">
					<div class="float-left">
						<img src="../assets/images/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
					</div>
					<div class="user-info">
						<a href="#"><?php echo ucfirst($srchAdms["username"]);?> </a>
					</div>
				</div>
    
            <?php echo $action->adminsideMenu($uid);?>
    
            <div class="clearfix"></div>

    
    </div>
    <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start container-fluid -->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <h4 class="header-title mb-3">Welcome <?php echo ucfirst($srchAdms["username"]);?>!</h4>
                                </div>
                            </div>
                        </div>
						
						<?php
						if(isset($_POST["updtSettings"])) {
							$apiKey = filter_var($_POST["apiKey"], FILTER_SANITIZE_STRIPPED);
							$secKey = filter_var($_POST["secKey"], FILTER_SANITIZE_STRIPPED);
							$contractCode = filter_var($_POST["contractCode"], FILTER_VALIDATE_INT);
							$charge = filter_var($_POST["charge"], FILTER_VALIDATE_FLOAT);
							
							$apicall = filter_var($_POST["apicall"], FILTER_VALIDATE_URL);
							$apiuser = filter_var($_POST["apiuser"], FILTER_SANITIZE_STRIPPED);
							$apipass = filter_var($_POST["apipass"], FILTER_SANITIZE_STRIPPED);
							
							$min_air = filter_var($_POST["min_air"], FILTER_VALIDATE_FLOAT);
							$max_air = filter_var($_POST["max_air"], FILTER_VALIDATE_FLOAT);
							$percent = filter_var($_POST["percent"], FILTER_VALIDATE_FLOAT);
							$dataPercent = filter_var($_POST["dataPercent"], FILTER_VALIDATE_FLOAT);
							
							if($contractCode === FALSE) { ?>
								<div class="alert alert-danger"><b>Error: </b> Contract code is invalid</div>
							<?php } else if($charge === FALSE) { ?>
								<div class="alert alert-danger"><b>Error: </b> Charge is invalid</div>
							<?php } else if($apicall === FALSE) { ?>
								<div class="alert alert-danger"><b>Error: </b> Invalid vending url provided</div>
							<?php } else if($charge === FALSE) { ?>
								<div class="alert alert-danger"><b>Error: </b> Charge is invalid</div>
							<?php } else {
								
								$monny = json_encode([
									"apiKey" => $apiKey,
									"secKey" => $secKey,
									"contractCode" => $contractCode,
									"charge" => $charge
								]);
								
								$apiLink = json_encode([
									"call" => $apicall,
									"user" => $apiuser,
									"pass" => $apipass
								]);
								
								$airtimeSettings = json_encode([
									"min_air" => $min_air,
									"max_air" => $max_air,
									"percent" => $percent,
									"dataPercent" => $dataPercent
								]);
								
								$updtMonny = $action->query("update settings set value='".addslashes($monny)."' where name='monnify'");
								$updtAirt = $action->query("update settings set value='".addslashes($airtimeSettings)."' where name='airtimeSettings'");
								$updtApi = $action->query("update settings set value='".addslashes($apiLink)."' where name='apiLink'");
								
								if($updtMonny->execute() && $updtAirt->execute() && $updtApi->execute()) { ?>
									<script>
										alert("Settings modified successfully");
										window.location = "";
									</script>
								<?php } else { ?>
									<div class="alert alert-danger"><b>Error: </b> Unable to update settings</div>
								<?php }
								
							}
							
						}
						?>
                        
						<div class="row">
                            <div class="col-lg-12">
								<h4><b>Monnify Settings</b></h4> <br>
							</div>
						</div>
												
                        <div class="row">
                            <div class="col-12">
                                <form method="post">
									
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter your api key" name="apiKey" id="apiKey" class="form-control" value="<?php echo $action->providusInfos()->apiKey;?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter your secret key" name="secKey" id="secKey" class="form-control" value="<?php echo $action->providusInfos()->secKey;?>" required>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter your contract code" name="contractCode" id="contractCode" class="form-control" value="<?php echo $action->providusInfos()->contractCode;?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter your charge" name="charge" id="charge" class="form-control" value="<?php echo $action->providusInfos()->charge;?>" required>
											</div>
										</div>
									</div>
                        
									<div class="row">
										<div class="col-lg-12">
											<h4><b>Vending Settings</b></h4> <br>
										</div>
									</div>
									
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<input type="text" placeholder="Enter api endpoint" name="apicall" id="apicall" class="form-control" value="<?php echo $action->apiLink()->call;?>" required>
											</div>
										</div>
										
									</div>
									
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter api username" name="apiuser" id="apiuser" class="form-control" value="<?php echo $action->apiLink()->user;?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter api password" name="apipass" id="apipass" class="form-control" value="<?php echo $action->apiLink()->pass;?>" required>
											</div>
										</div>
									</div>
                        
									<div class="row">
										<div class="col-lg-12">
											<h4><b>Airtime & Data Settings</b></h4> <br>
										</div>
									</div>
									
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter airtime percentage" name="min_air" id="min_air" class="form-control" value="<?php echo $action->airtimeSettings()->min_air;?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter data percentage" name="max_air" id="max_air" class="form-control" value="<?php echo $action->airtimeSettings()->max_air;?>" required>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter airtime percentage" name="percent" id="percent" class="form-control" value="<?php echo $action->airtimeSettings()->percent;?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<input type="text" placeholder="Enter data percentage" name="dataPercent" id="dataPercent" class="form-control" value="<?php echo $action->airtimeSettings()->dataPercent;?>" required>
											</div>
										</div>
									</div>
									
									<div class="text-center">
										<button class="btn btn-success btn-lg" name="updtSettings" id="updtSettings" onclick="return confirm('Modify Settings')" type="submit"><b>
											<i class="ti-pencil"></i> Update Settings</b>
										</button>
									</div>
									
								</form>
                            </div>
                        </div>

                    </div>
					

                </div>
                <!-- end content -->

            </div>
            <!-- END content-page -->

        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <script src="../assets/libs/morris-js/morris.min.js"></script>
        <script src="../assets/libs/raphael/raphael.min.js"></script>

        <script src="../assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>

    </body>
</html>