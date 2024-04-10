<?php
require "../action.php"; $action = new Action();
$uid = $_SESSION["uid"];
if(empty($uid)) {
	$action->redirect_to("../login");
	die();
} else {
	$userInfo = $action->userInfo($uid);
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Ads History | Project Hub</title>
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

        <link href="../assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
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
                                    <h4 class="header-title mb-3">Hi <?php echo ucfirst($userInfo["name"]);?>!</h4>
                                </div>
                            </div>
                        </div>
						
							
                        <div class="row">
                            <div class="col-12">
								<h4><b> Ads History</b></h4> Here you can see all Ads History<br><br>
							</div>
						</div>
						
						
                        <div class="row">
                            <div class="col-12">
                                
								 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
												<th>Date</th>
												<th>Ads Name</th>
												<th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            <tr>
                                                <?php
													$i = 0;
													$getHis = $action->query("select * from ads where status!='0' order by id desc"); $getHis->execute();
													foreach ($getHis as $dss) { $i++;
													
														if($dss["status"] == 0) {
															$adsStat = "<b style='color: red'>Pending Approval</b>";
														} else if($dss["status"] == 2) {
															$adsStat = "<b style='color: brown'>Ads Declined</b>";
														} else if($dss["status"] == 1) {
															$adsStat = "<b style='color: green'>Ads Approved</b>";
														} 
													
												?>
													<td><?php echo $i;?></td>
													<td><?php echo $dss['dateCreated'];?></td>
													<td><?php echo $dss['name'];?></td>
													<td><?php echo $adsStat;?></td>
													
												</tr>
												
												<?php } ?>
                                        </tbody>
                                    </table>

								
                            </div>
                        </div>
						
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
		
        <script src="../assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="../aassets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="../aassets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <script src="../assets/js/pages/datatables.init.js"></script>

    </body>
</html>