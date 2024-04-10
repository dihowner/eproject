<?php
require "../action.php"; $action = new Action();
$uid = $_SESSION["uid"];
if(empty($uid)) {
	$action->redirect_to("../login");
	die();
} else {
	$userInfo = $action->userInfo($uid);
	$bankInfo = json_decode($userInfo["bankInfo"], true);
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Update Profile | Project Hub</title>
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
								<h4><b>Update Profile</b></h4> Fill the form below to edit your profile<br><br>
							</div>
						</div>
						
						<?php
							if(isset($_POST["edtProf"])) {
								$fname = $_POST["fname"];
								
								$updtProf = $action->query("update `user` set name='$fname' where id='".$userInfo["id"]."'");
								if($updtProf->execute()) { ?>
									<script>
										alert("Profile Updated successfully");
										window.location = "updtProfile";
									</script>
								<?php } else { ?>
									<div class="alert alert-danger"><b>Error :</b> Unable to modify profile</div>
								<?php }
							}
							
							if(isset($_POST["updtBank"])) {
								$accesskey = $_POST["access"];
								$accName = $_POST["accName"];
								$bankCode = $_POST["bank_Name"];
								$accNo = $_POST["accNo"];
								
								if(!isset($accName) || empty($accName)) {
									$accName = $bankInfo["accName"];
								}
								
								if($userInfo["accesskey"] != $accesskey) { ?>
									<div class="col-12">
										<div class="alert alert-danger"><b> Error : </b> Incorrect access key supplied</div>
									</div>
								<?php } else if(empty($accName)) { ?>
									<div class="col-12">
										<div class="alert alert-danger"><b> Error : </b> Please verify account number</div>
									</div>
								<?php } else {
									
									$bank_json = json_encode([
										"accName" => $accName,
										"accNo" => $accNo,
										"bankCode" => $bankCode
									]);
									
									$updtBank = $action->query("update user set bankInfo='".addslashes($bank_json)."' where id='$uid'");
									
									if($updtBank->execute()) { ?>
										<script>
											alert("Bank information updated");
											window.location = "updateProfile";
										</script>
									<?php } else { ?>
										<div class="col-12">
											<div class="alert alert-danger"><b> Error : </b> Unable to update account details</div>
										</div>
									<?php }
									
								}
								
								
							}
						?>
						
                        <div class="row">
                            <div class="col-12">
							
								<ul class="nav nav-tabs">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#addMaterials">Edit Profile</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#uploadHist">Banking Information</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content" style="background-color: #fff; color: #000">
									<div id="addMaterials" class="container tab-pane active">
										<form method="post">
											<div class="row">
												<div class="col-6">
													<div class="form-group">
														<input type="text" placeholder="Enter your name" value="<?php echo $userInfo["name"];?>" name="fname" class="form-control">
													</div>
												</div>
												<div class="col-6">
													<div class="form-group">
														<input type="text" disabled class="form-control" value="<?php echo $userInfo["email"];?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-6">
													<div class="form-group">
														<input type="text" class="form-control" disabled value="<?php echo $userInfo["mobile"];?>">
													</div>
												</div>
												<div class="col-6">
													<div class="form-group">
														<input type="text" disabled class="form-control" value="&#8358;<?php echo number_format($userInfo["main_bal"], 2);?>">
													</div>
												</div>
											</div>
											
											<div class="text-center">
												<button class="btn btn-success btn-lg" name="edtProf" type="submit"><b><i class="ti-pencil"></i> Edit Profile</b></button>
											</div>
											
										</form>
									</div>
									<div id="uploadHist" class="container tab-pane">
										<form method="post">
											<div class="row">
												<div class="col-12">
													<label><b>Select Your Bank </b></label>
													<select name="bank_Name" id="bank_Name" class="form-control">
														<option value="">-- Select Bank --</option>
														<option value="044"<?php echo ($bankInfo["bankCode"] == "044")?"selected='selected'":"";?>>Access Bank</option>
														<option value="323"<?php echo ($bankInfo["bankCode"] == "323")?"selected='selected'":"";?>>Access Money</option>
														<option value="401"<?php echo ($bankInfo["bankCode"] == "401")?"selected='selected'":"";?>>ASO Savings and & Loans</option>
														<option value="317"<?php echo ($bankInfo["bankCode"] == "317")?"selected='selected'":"";?>>Cellulant</option>
														<option value="303"<?php echo ($bankInfo["bankCode"] == "303")?"selected='selected'":"";?>>ChamsMobile</option>
														<option value="023"<?php echo ($bankInfo["bankCode"] == "023")?"selected='selected'":"";?>>CitiBank</option>
														<option value="551"<?php echo ($bankInfo["bankCode"] == "551")?"selected='selected'":"";?>>Covenant Microfinance Bank</option>
														<option value="559"<?php echo ($bankInfo["bankCode"] == "559")?"selected='selected'":"";?>>Coronation Merchant Bank</option>
														<option value="063"<?php echo ($bankInfo["bankCode"] == "063")?"selected='selected'":"";?>>Diamond Bank</option>
														<option value="302"<?php echo ($bankInfo["bankCode"] == "302")?"selected='selected'":"";?>>Eartholeum</option>
														<option value="050"<?php echo ($bankInfo["bankCode"] == "050")?"selected='selected'":"";?>>Ecobank Plc</option>
														<option value="307"<?php echo ($bankInfo["bankCode"] == "307")?"selected='selected'":"";?>>EcoMobile</option>
														<option value="084"<?php echo ($bankInfo["bankCode"] == "084")?"selected='selected'":"";?>>Enterprise Bank</option>
														<option value="306"<?php echo ($bankInfo["bankCode"] == "306")?"selected='selected'":"";?>>eTranzact</option>
														<option value="314"<?php echo ($bankInfo["bankCode"] == "314")?"selected='selected'":"";?>>FET</option>
														<option value="070"<?php echo ($bankInfo["bankCode"] == "070")?"selected='selected'":"";?>>Fidelity Bank</option>
														<option value="318"<?php echo ($bankInfo["bankCode"] == "318")?"selected='selected'":"";?>>Fidelity Mobile</option>
														<option value="011"<?php echo ($bankInfo["bankCode"] == "011")?"selected='selected'":"";?>>First Bank of Nigeria</option>
														<option value="214"<?php echo ($bankInfo["bankCode"] == "214")?"selected='selected'":"";?>>First City Monument Bank</option>
														<option value="501"<?php echo ($bankInfo["bankCode"] == "501")?"selected='selected'":"";?>>Fortis Microfinance Bank</option>
														<option value="308"<?php echo ($bankInfo["bankCode"] == "308")?"selected='selected'":"";?>>FortisMobile</option>
														<option value="309"<?php echo ($bankInfo["bankCode"] == "309")?"selected='selected'":"";?>>FBNMobile</option>
														<option value="601"<?php echo ($bankInfo["bankCode"] == "601")?"selected='selected'":"";?>>FSDH</option>
														<option value="058"<?php echo ($bankInfo["bankCode"] == "058")?"selected='selected'":"";?>>GTBank Plc</option>
														<option value="315"<?php echo ($bankInfo["bankCode"] == "315")?"selected='selected'":"";?>>GTMobile</option>
														<option value="324"<?php echo ($bankInfo["bankCode"] == "324")?"selected='selected'":"";?>>Hedonmark</option>
														<option value="030"<?php echo ($bankInfo["bankCode"] == "030")?"selected='selected'":"";?>>Heritage</option>
														<option value="415"<?php echo ($bankInfo["bankCode"] == "415")?"selected='selected'":"";?>>Imperial Homes Mortgage Bank</option>
														<option value="301"<?php echo ($bankInfo["bankCode"] == "301")?"selected='selected'":"";?>>JAIZ Bank</option>
														<option value="402"<?php echo ($bankInfo["bankCode"] == "402")?"selected='selected'":"";?>>Jubilee Life Mortgage Bank</option>
														<option value="082"<?php echo ($bankInfo["bankCode"] == "082")?"selected='selected'":"";?>>Keystone Bank</option>
														<option value="325"<?php echo ($bankInfo["bankCode"] == "325")?"selected='selected'":"";?>>MoneyBox</option>
														<option value="313"<?php echo ($bankInfo["bankCode"] == "313")?"selected='selected'":"";?>>Mkudi</option>
														<option value="999"<?php echo ($bankInfo["bankCode"] == "999")?"selected='selected'":"";?>>NIP Virtual Bank</option>
														<option value="552"<?php echo ($bankInfo["bankCode"] == "552")?"selected='selected'":"";?>>NPF MicroFinance Bank</option>
														<option value="990"<?php echo ($bankInfo["bankCode"] == "990")?"selected='selected'":"";?>>Omoluabi Mortgage Bank</option>
														<option value="327"<?php echo ($bankInfo["bankCode"] == "327")?"selected='selected'":"";?>>Pagatech</option>
														<option value="560"<?php echo ($bankInfo["bankCode"] == "560")?"selected='selected'":"";?>>Page MFBank</option>
														<option value="526"<?php echo ($bankInfo["bankCode"] == "526")?"selected='selected'":"";?>>Parralex</option>
														<option value="329"<?php echo ($bankInfo["bankCode"] == "329")?"selected='selected'":"";?>>PayAttitude Online</option>
														<option value="305"<?php echo ($bankInfo["bankCode"] == "305")?"selected='selected'":"";?>>Paycom</option>
														<option value="311"<?php echo ($bankInfo["bankCode"] == "311")?"selected='selected'":"";?>>ReadyCash (Parkway)</option>
														<option value="403"<?php echo ($bankInfo["bankCode"] == "403")?"selected='selected'":"";?>>SafeTrust Mortgage Bank</option>
														<option value="076"<?php echo ($bankInfo["bankCode"] == "076")?"selected='selected'":"";?>>Skye Bank</option>
														<option value="221"<?php echo ($bankInfo["bankCode"] == "221")?"selected='selected'":"";?>>Stanbic IBTC Bank</option>
														<option value="304"<?php echo ($bankInfo["bankCode"] == "304")?"selected='selected'":"";?>>Stanbic Mobile Money</option>
														<option value="068"<?php echo ($bankInfo["bankCode"] == "068")?"selected='selected'":"";?>>Standard Chartered Bank</option>
														<option value="232"<?php echo ($bankInfo["bankCode"] == "232")?"selected='selected'":"";?>>Sterling Bank</option>
														<option value="326"<?php echo ($bankInfo["bankCode"] == "326")?"selected='selected'":"";?>>Sterling Mobile</option>
														<option value="100"<?php echo ($bankInfo["bankCode"] == "100")?"selected='selected'":"";?>>SunTrust Bank</option>
														<option value="328"<?php echo ($bankInfo["bankCode"] == "328")?"selected='selected'":"";?>>TagPay</option>
														<option value="90115"<?php echo ($bankInfo["bankCode"] == "90115")?"selected='selected'":"";?>>TCF MFB</option>
														<option value="319"<?php echo ($bankInfo["bankCode"] == "319")?"selected='selected'":"";?>>TeasyMobile</option>
														<option value="523"<?php echo ($bankInfo["bankCode"] == "523")?"selected='selected'":"";?>>Trustbond</option>
														<option value="033"<?php echo ($bankInfo["bankCode"] == "033")?"selected='selected'":"";?>>United Bank for Africa</option>
														<option value="032"<?php echo ($bankInfo["bankCode"] == "032")?"selected='selected'":"";?>>Union Bank</option>
														<option value="215"<?php echo ($bankInfo["bankCode"] == "215")?"selected='selected'":"";?>>Unity Bank</option>
														<option value="320"<?php echo ($bankInfo["bankCode"] == "320")?"selected='selected'":"";?>>VTNetworks</option>							
														<option value="035"<?php echo ($bankInfo["bankCode"] == "035")?"selected='selected'":"";?>>Wema Bank</option>
														<option value="057"<?php echo ($bankInfo["bankCode"] == "057")?"selected='selected'":"";?>>Zenith Bank</option>
													</select>	
												</div>
											</div>
											
											<div class="row" style="margin-top: 2%">
												<div class="col-12">
													<label><b>Enter Account Number </b></label>
													<div class="input-group">
														<input type="text" class="form-control" placeholder="Enter account number" name="accNo" id="accNo" value="<?php echo $bankInfo["accNo"];?>">
															<div class="input-group-btn">
																<button class="btn btn-info" type="submit" id="verifyAccntBtn">
																	<b>Verify Account</b>
																</button>
															</div>
													</div>
												</div>
											</div>
											
											<?php if(!empty($bankInfo["accName"])) { ?>
												<div class="row" style="margin-top: 2%">
													<div class="col-12">
														<div id="response">
															<font size="4px"><b>Account Name : </b><?php echo $bankInfo["accName"];?></font>
														</div>
													</div>
												</div>
											<?php } ?>
											
											<div class="row" style="margin-top: 2%">
												<div class="col-12">
													<label><b>Enter Access Key </b></label>
													<input type="password" class="form-control" placeholder="Enter access key" name="access" id="access" maxlength="4">
												</div>
											</div>
											
											<div class="text-center" style="margin-top: 2%">
												<button class="btn btn-success btn-lg" name="updtBank" type="submit"><b><i class="ti-pencil"></i> Update Account</b></button>
											</div>
											
										</form>
									</div>
							
							
                            </div>
                        </div>
                        <!--end row -->


                    </div>
                    <!-- end container-fluid -->

                    

                    <!-- Footer Start -->
                    <footer class="footer" style="background: #000">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12" style="color: #fff; font-size: 18px">
                                    2017 - 2020 &copy; Simple theme by <a href="#">Coderthemes</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- end Footer -->

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