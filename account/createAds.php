<?php
require "../action.php"; $action = new Action();
require "../class_vtu.php"; $loadCall = new peaksms();
$uid = $_SESSION["uid"];
if(empty($uid)) {
	$action->redirect_to("../login");
	die();
} else {
	$userInfo = $action->userInfo($uid);
	$dataPercent = $action->airtimeSettings()->dataPercent;
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Create Ads | Project Hub</title>
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
        <script src="../assets/js/jquery-2.1.4.min.js"></script>
		<script src="../assets/js/project.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
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
                                    <?php echo $userInfo["name"];?>  <i class="mdi mdi-chevron-down"></i> 
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
						<a href="#"><?php echo ucfirst($userInfo["name"]);?> </a>
					</div>
				</div>
    
            <?php echo $action->sideMenu($uid);?>
    
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
                                    <h4 class="header-title mb-3">Hi <?php echo ucfirst($userInfo["name"]);?>!</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
								<h4><b>Create Ads</b></h4> Fill the form below to create your ads, If you create an Ads without Image, Ads description will be used in showing your Ads on our website<br><br>
							</div>
						</div>
						
						<div class="row">
							
							<?php
							
							if(isset($_POST["uploadAds"])) {
								$adsName = filter_var($_POST["adsName"], FILTER_SANITIZE_STRIPPED); //Remove HTML Tags
								$adsDesc = addslashes(filter_var($_POST["adsDesc"], FILTER_SANITIZE_STRIPPED)); //Remove HTML Tags
								$adsUrl = filter_var($_POST["adsUrl"], FILTER_VALIDATE_URL);
								$deptID = $_POST["deptID"];
								
								$isUpload = false;
								$sizeErr = false;
								$extErr = false;
								
								$mytime = date("D j F, Y; h:i a");
								
								if(!empty($_FILES["adsFile"]["name"])) { //Image was uploaded...
									$isUpload = true;
									//Ads Info...
									$adsFileName = $_FILES["adsFile"]["name"];
									$adsFile_tmp = $_FILES["adsFile"]["tmp_name"];
									$adsFile_ext = strtolower(pathinfo($_FILES["adsFile"]["name"])["extension"]);
									
									// Valid extension
									$valid_ext = array('png','jpeg','jpg');
									
									if($_FILES["adsFile"]["name"] > 716800) {
										$sizeErr = true;
									} else if(!in_array($adsFile_ext, $valid_ext)) {
										$extErr = true;
									} else {
										$folder = "../uploads/ads/";
										$action->compressImage($adsFile_tmp, $folder.$adsFileName, 60);  //Reduce business logo size and upload...
									}
									
								}
								
								if($adsUrl === FALSE) { ?>
									<div class="col-12">
										<div class="alert alert-danger" style="font-size: 20px">
											<b>Error : </b> Invalid Ads URL provided
										</div>
									</div>
								<?php } else if($isUpload == true) {
									if($sizeErr == true) { ?>
										<div class="col-12">
											<div class="alert alert-danger" style="font-size: 20px">
												<b>Error : </b> Maximum Ads upload size is between 500kb to 700kb
											</div>
										</div>
									<?php } else if($extErr == true) { ?>
										<div class="col-12">
											<div class="alert alert-danger" style="font-size: 20px">
												<b>Error : </b> Invalid file extension (<?php echo $adsFile_ext;?>) uploaded for Ads
											</div>
										</div>
									<?php } else {
										//Save to db..
										$saveAds = $action->query("insert into ads (userid, name, content, images, url, department, dateCreated) values ('$uid', '$adsName', '$adsDesc', '$adsFileName', '$adsUrl', '$deptID', '$mytime')");
										
										if($saveAds->execute()) { ?>
											<script>
												swal.fire({
													icon: "success",
													title: "Ads Created",
													text: "Your Ads has been created await Admin Approval"
												}).then(function() {
													window.location = "";
												});
											</script>
										<?php } else { ?>
										<div class="col-12">
											<div class="alert alert-danger" style="font-size: 20px">
												<b>Error : </b> We could not create a reference for your Ads at the moment, kindly try again later
											</div>
										</div>
									<?php }
									}
								} else { //No image was uploaded...
									
									//Save to db..
									$saveAds = $action->query("insert into ads (userid, name, content, url, department, dateCreated) values ('$uid', '$adsName', '$adsDesc', '$adsUrl', '$deptID', '$mytime')");
									
									if($saveAds->execute()) { ?>
										<script>
											swal.fire({
												icon: "success",
												title: "Ads Created",
												text: "Your Ads has been created await Admin Approval"
											}).then(function() {
												window.location = "";
											});
										</script>
									<?php } else { ?>
									<div class="col-12">
										<div class="alert alert-danger" style="font-size: 20px">
											<b>Error : </b> We could not create a reference for your Ads at the moment, kindly try again later
										</div>
									</div>
								<?php }
									
								}
								
							}
							
							// uploadAds, adsFile, adsName, adsDesc, adsUrl
							?>
						</div>
						
						
                        <div class="row">
                            <div class="col-12">
								<form method="post" enctype="multipart/form-data">
									<label><b>Ads Name</b></label>
									<input type="text" class="form-control" name="adsName" placeholder="Enter Ads Name" required /> <br/>
									
									<label><b>Ads Description</b></label>
									<textarea class="form-control input-lg" name="adsDesc" rows="5" placeholder="Enter Ads description" required></textarea><br/>
									
									<label><b>Ads URL</b></label>
									<input type="text" class="form-control" name="adsUrl" placeholder="Enter Ads URL e.g facebook , twitter, whatsapp or Website URL" required /> <br/>
																		
									<label><b>Department (Optional, leave empty if you do not know where your Ads belongs to)</b></label>
									<select type="text" class="form-control" name="deptID">
										<option value="">-- Select Department --</option>
										<?php 
										$loadDept = $action->query("select * from department order by dertmentName asc"); $loadDept->execute();
										while($loadDepts = $loadDept->fetch(PDO::FETCH_ASSOC)) { ?>
											<option value="<?php echo $loadDepts['id'];?>"><?php echo $loadDepts['dertmentName'];?></option>
										<?php } ?>
									</select>
									<br/>
									
									<label><b>Ads Image (Optional)</b></label>
									<input type="file" class="form-control" name="adsFile" accept="image/png,image/jpg,image/jpeg,image/gif" /> <br/>
									<div style="font-size: 18px; color: #000;"><span class="text-error" style="font-size: 18px; color: red; font-weight: bolder">NOTE : </span>
										Maximum file upload is 500KB to 700KB, 735px width and 350px height</div>
									<br>
									<div class="text-center">
										<button type="submit" name='uploadAds' class="btn btn-primary btn-lg">
											<b><i class="fa fa-upload"></i> Submit Ads</b>
										</button>
									</div>
									
								</form>
								
                            </div>
                        </div>
                        <!--end row -->


                    </div>
					
					<?php require "foot.php"; ?>

                </div>

            </div>
        </div>
		
        <script src="../assets/js/vendor.min.js"></script>

        <script src="../assets/libs/morris-js/morris.min.js"></script>
        <script src="../assets/libs/raphael/raphael.min.js"></script>

        <script src="../assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>

    </body>
</html>