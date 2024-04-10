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
        <title>Upload Project | Project Hub</title>
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
								<h4><b>Upload Project</b></h4> Fill the form below to upload your project<br><br>
							</div>
						</div>
						
						<div class="row">
							<?php
							if (isset($_POST["uploadProject"])) {
								$topic = addslashes(strtoupper(str_replace("&" , "and", $_POST["topic"])));
								$pages = $_POST["pages"];
								$chapter = $_POST["chapter"];
								$department = $_POST["department"];
								$degree = $_POST["degree"];
								$abstract = addslashes($_POST['abstract']);
								$mytime = date("D j F, Y; h:i a");
								
								$filename = $_FILES['upload']['name'];
								$tmpname = $_FILES['upload']['tmp_name'];
								$foldername = '../uploads/';
								$targetPath = $foldername.$_FILES['upload']['name'];
								$joinfile = $foldername . $filename;
								$file_size = $_FILES['upload']['size']; //size of the document to be uploaded
								
								if(strtolower($department) == "others") { $department = $_POST["deptName"]; }
								
								if(strtolower($degree) == "others") { $degree = $_POST["degreeName"]; }
								
								$extension = strtolower(pathinfo($filename)["extension"]);
								$allowed_extension = array("doc", "docs", "docx");
								
								if ($file_size > 5120000){ ?>
									<div class="col-12">
										<div class="alert alert-danger">
											<b>Error: </b> File is too large, Maximum file upload is 5mb
										</div>
									</div>
								<?php } else if (!in_array($extension, $allowed_extension)) { ?>
									<div class="col-12">
										<div class="alert alert-danger">
											<b>Error: </b> Unsupported extension (<b><?php echo $extension;?></b>) selected
										</div>
									</div>
								<?php } else if ($movefile = move_uploaded_file($tmpname, $joinfile)) {
									$saveNew = $action->query("insert into market (userid, project_name, abstract, proj_doc, no_of_pages, department, chapterno, degree_awarded, status, date) values ('$uid','$topic','$abstract','$filename','$pages','$department','$chapter','$degree','0', '$mytime')"); $saveNew->execute(); 
									if ($saveNew) {
									 ?>
										<div class="col-12">
											<div class="alert alert-success" style="font-size: 18px">
												<b>Success: </b> You have successfully uploaded your project, your project is pending approval
											</div>
										</div>
									<?php } else { ?>
										<div class="col-12">
											<div class="alert alert-danger">
												<b>Error: </b> We could not process your request, please try again
											</div>
										</div>
									<?php }
								}
							}
						?>
						</div>
						
						
                        <div class="row">
                            <div class="col-12">
                                <form method="post" enctype="multipart/form-data" autocomplete="off">
									<label for="topic"><b>Project Topic:</b></label>
											<input type="text" id="topic" class="form-control input-lg" name="topic" placeholder="Enter project name" required>
											<br>
											
											<div class="row" style="margin-bottom: 10px">
												<div class="col-6">
													<label for="pages"><b>Number of Pages:</b></label>
													<input type="number" id="pages" class="form-control input-lg" name="pages" min="1" placeholder="50" required>
												</div>
												
												<div class="col-6">
													<label for="chapter"><b>Number of Chapter:</b></label>
													<input type="number" id="chapter" class="form-control input-lg" min="1" name="chapter" placeholder="1-5" required>
												</div>
											</div>
											
											<div class="row" style="margin-bottom: 10px">
												<div class="col-6">
													<label for="department"><b>Department:</b></label>
													<select name="department" id="department" class="form-control" required>
														<option value=""> -- Select Department --  </option>
														<?php 
														$loadDep = $action->query ("select * from department"); $loadDep->execute();
														while ($dapp = $loadDep->fetch(PDO::FETCH_ASSOC)) {
															$department = $dapp["dertmentName"];
															$deptID = $dapp["id"];
														?>
														<option value="<?php echo $deptID;?>"> 
															<?php echo $department; ?>
														</option>
														<?php } ?>
														<option value="others"> OTHERS </option>
													</select>
												</div>
												
												<div class="col-6">
													<label for="degree"><b>Degree Awarded:</b></label>
													<select name="degree" id="degree" class="form-control" required>
														<option value="">  -- Select Degree Awarded --  </option>
														<option value="degree"> DEGREE </option>
														<option value="NCE">Nigeria Certificate In Education </option>
														<option value="ond"> Ordinary National DIploma </option>
														<option value="hnd"> Higher National DIploma </option>
														<option value="msc"> Magister Scientiae </option>
														<option value="pgd"> Post Graduate Degree </option>
														<option value="others"> OTHERS </option>
													</select>
												</div>
											</div>
											
											<div class="row" style="margin-bottom: 10px">
												<div class="col-12">
													<div id="deptBox"></div>
												</div>
											</div>
											
											<div class="row" style="margin-bottom: 10px">
												<div class="col-12">
													<div id="degreeBox"></div>
												</div>
											</div>
											
											<label for="abstract"><b>Project Abstract:</b></label>
											<textarea name="abstract" id="abstract" class="form-control input-lg" cols="10" rows="8" placeholder="Project Abstract" required></textarea>
											<br>
											<label for="doc"><b>Project Document:</b></label>
											<input type="file" class="form-control input-lg" name="upload" accept="doc, docx, docs" required> <br>
											<font size="4px"><b style="color: red">NOTE : </b> Only <b>.docs, doc, docx</b> files are allowed, Maximum of <b>5mb</b> per upload
											<br><br>
									
									<div class="text-center">
										<button class="btn btn-success btn-lg" name="uploadProject" type="submit"><b>
											<i class="ti-upload"></i> Upload Project</b>
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