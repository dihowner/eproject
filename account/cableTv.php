<?php
require "../action.php"; $action = new Action();
require "../class_vtu.php"; $loadCall = new peaksms();
$uid = $_SESSION["uid"];
if(empty($uid)) {
	$action->redirect_to("../login");
	die();
} else {
	$userInfo = $action->userInfo($uid);
	$min_airtime = $action->airtimeSettings()->min_air;
	$max_airtime = $action->airtimeSettings()->max_air;
	$air_percent = $action->airtimeSettings()->percent;
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Cable Tv | Project Hub</title>
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
								<h4><b>Cable Tv Subscription</b></h4> Fill the form below to subscribe on your decoder of your choice<br><br>
							</div>
						</div>
						
						<div class="row">
							<?php
							
							// print_r($loadCall->postdata("airtime_topup", $data));
							
							// die();
							if (isset($_POST["buyAirtime"])) {
								$wallettype = strtolower($_POST["wallettype"]);
								$networkName = $_POST["networkName"]; //Network Name...
								$mobileno = $_POST["mobileno"]; //Mobile Number...
								$airAmnt = $_POST["airAmnt"]; //Airtime Value...
								$accessKey = $_POST["accessKey"]; //Access Key...
								
								
								if($accessKey == "0000") { ?>
									<div class="col-sm-12">
										<div class="alert alert-danger"><b> Error : </b> Default access key can not be use</div> 
									</div>
								<?php } else if($accessKey != $userInfo["accesskey"]) { ?>
									<div class="col-sm-12">
										<div class="alert alert-danger"><b> Error : </b> Incorrect access key supplied</div> 
									</div>
								<?php } else {
									//wallet to debit...
									if ($wallettype == "main") {
										$debit = "main wallet";
										$balance = $userInfo["main_bal"];
									} else if ($wallettype == "earn") {
										$debit = "earnings wallet";
										$balance = $userInfo["earn_bal"];
									}
									
									$topay = ($airAmnt - (($airAmnt * $air_percent)/100));
									
									if(!is_numeric($mobileno) || strlen($mobileno) < 11) { ?>
										<div class="col-sm-12">
											<div class="alert alert-danger"><b> Error : </b> Incorrect mobile number supplied</div> 
										</div>
									<?php } else if($topay > $balance) { ?>
										<div class="col-sm-12">
											<div class="alert alert-danger"><b> Error : </b> Insufficient <?php echo $debit;?> balance. Kindly recharge your wallet <a href='fundWallet' style='color: red'>Add Money</a></div> 
										</div>
									<?php } else if($topay < 1) { ?>
										<div class="col-sm-12">
											<div class="alert alert-danger"><b> Error : </b> No valid purchase price for this product</div> 
										</div>
									<?php } else if($airAmnt < $min_airtime) { ?>
										<div class="col-sm-12">
											<div class="alert alert-danger"><b> Error : </b> Minimum airtime purchase is &#8358;<?php echo number_format($min_airtime, 2);?></div> 
										</div>
									<?php } else if($airAmnt > $max_airtime) { ?>
										<div class="col-sm-12">
											<div class="alert alert-danger"><b> Error : </b> Maximum airtime purchase is &#8358;<?php echo number_format($max_airtime, 2);?></div> 
										</div>
									<?php } else {
										
										$dataRequest = json_encode(["phone" => $mobileno,
																	"network" => $networkName,
																	"amount" => $airAmnt
														]);
										
										if($loadCall->postdata("airtime_topup", $dataRequest)) {
											$status = 0;
											$serverResponse = $_SESSION["response"]; #response from the provider...
											$respJson = json_decode($serverResponse, true);
											$orderid = $respJson["orderid"];
											
											$aftAmnt = $balance - $topay;
											
											$action->updatebal($aftAmnt, "earn_bal", $uid);
											$bfrAmnt = $balance; //amount before airtime is bought
											
											$mytime=date("D j F, Y; h:i a");
											 
											$save = $action->query("insert into allbuys (userid, network, walletdebit, amount, amountDeduct, bfrAmnt, AftAmnt, phoneno, status, timed, msg, category, dataid) values ('$uid', '".strtoupper($networkName)."', '$debit', '$airAmnt', '$topay', '$bfrAmnt', '$aftAmnt', '$mobileno', '$status', '$mytime',  'Order successful', 'airtime', '$orderid')");
											$save->execute();
											?>
										<script>
											var phone = "<?php echo $mobileno;?>";
											var network = "<?php echo strtoupper($networkName);?>";
											var airAmnt = "<?php echo $airAmnt;?>";
											alert("Transaction successful. "+ phone+ " has been recharged with "+network+" N"+airAmnt+" airtime topup. Kindly check your account balance");
											window.location = "airtimeTopup";
										</script>
										<?php
										} else { ?>
											<div class="col-sm-12">
												<div class="alert alert-danger"><b> Error : </b> Unable to process request at the moment</div> 
											</div>
										<?php }
										
									}
								}
								
							}
						?>
						</div>
						
						
                        <div class="row">
                            <div class="col-12">
							
							<ul class="nav nav-tabs">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#addMaterials">Activate Cable</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#uploadHist">Transaction History</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content" style="background-color: #fff; color: #000">
									<div id="addMaterials" class="container tab-pane active">
									
										
										<form method="post">
											<div id="imghere" align="center" style="margin-top: 2%; margin-bottome: 2%;"></div>
											<label for="wallettype"><b>Choose Wallet to Debit</b></label>
											<select name="wallettype" id="wallettype" class="form-control" autofocus required>
												<option value="">-- Select Wallet --</option>
												<option value="main"> Main Wallet - &#8358;<?php echo $currency.number_format($userInfo["main_bal"],2)?> </option>
												<option value="earn"> Earnings Wallet - &#8358;<?php echo $currency.number_format($userInfo["earn_bal"],2)?> </option>
											</select>
											<br/>
											
											<label for="networkName"><b>Select Decoder:</b></label>
											<select class="form-control input-sm" name="decoderName" id="decoderName" required>
												<option value="">-- Select Decoder --</option>
												<option value="dstv">DSTV</option>
												<option value="gotv">GOTV</option>
												<option value="startimes">STARTIMES</option>
											</select>
											
											<div id="decoder_list"></div>
											
											<br>
											<label for="iucNo"><b>Decoder Number:</b></label>
											<div class="row">
												<div class="col-md-8" style="margin-top: 10px">
													<input name="iucNo" id="iucNo" class="form-control input-sm" type="text" minlength="4" placeholder="Enter decoder or iuc number" required="">
												</div>
												
												<div class="col-md-4" style="margin-top: 10px">
													<button class="btn btn-success btn-block" id="verifydecoder" type="button">Verify Decoder</button>
												</div>
											</div>
											<br/>
											
											<div id="customerInfo"></div>
											
											<br>
											<label for="amount"><b>Access Key:</b></label>
											<input name="accessKey" id="accessKey" class="form-control input-sm" type="password" placeholder="Enter your access key" required>
											<br>
													
											<div class="text-center">
												<button class="btn btn-success btn-lg" name="buyAirtime" type="submit">
													<b>Make Purchase</b>
												</button>
											</div>
											
										</form>
									
									</div>
									<div id="uploadHist" class="container tab-pane">
										
										<div class="table-responsive">
											<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>SN</th>
														<th>Description</th>
														<th>Old Balance</th>
														<th>Amount <br/>Deducted</th>
														<th>New Balance</th>
														<th>Status</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<tr>
													    <?php 
                                                        $i=0;
                                                        $getall = $action->query("select * from allbuys where userid='$uid' and category='airtime' order by id desc");
                                                        $getall->execute();
                                                        foreach ($getall as $dss) {
                                                            $status = $dss['status'];
                                                            $i++;?>
                                                            <td><?php echo $i;?></td>
                                                            <td>
                                                                <?php echo $dss['network'];?> 
                                                                &#8358;<?php echo number_format($dss["amount"],2);?> for
                                                                <?php echo $dss['phoneno'];?>
                                                                <p style="color: red; font-size: 11px"><?php echo ucwords($dss['walletdebit']);?></p>
                                                            </td>
                                                            
                                                            <td><?php echo number_format($dss['bfrAmnt'],2);?></td>
                                                            <td><?php echo number_format($dss['amountDeduct'],2);?></td>
                                                            <td><?php echo number_format($dss['AftAmnt'],2);?></td>
                                                            <td><?php echo $action->getstatus($dss['status']);?></td>
                                                            <td><?php echo $dss['timed'];?></td>
															
                                                        </tr>
                                                        <?php } ?>
													</tr>
												</tbody>
											</table><br><br><br>
										</div>
									
									</div>
								</div>
							
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