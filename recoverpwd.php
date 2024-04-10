<?php require "action.php"; $action = new Action(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <title>Forgot Password | Project Hub</title>
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

    </head>

    <body>
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mb-4 mt-3">
                                    <a href="#">
                                        <span><img src="assets/images/logo-dark.png" alt="" height="30"></span>
                                    </a>

                                </div>
								
								<?php	
								
								if(isset($_REQUEST["reset"])) {
									$resetcode = $_REQUEST['reset'];
									
									$redirect_url_forgot = BASE_URL."recoverpwd"; //For redirection...
									
									$redirect_url_login = BASE_URL."login"; //For login...
									
									//Search reset...
									$getReset = $action->query("select * from resetpassword where reset_code='$resetcode'"); $getReset->execute();
									$getResetInfo = $getReset->fetch(PDO::FETCH_ASSOC);
									
									if($getReset->rowCount() == 0) { ?>
										<script>
											var redirect_url_forgot = "<?php echo $redirect_url_forgot;?>";
											Swal.fire({
												icon: "error",
												title: "Not Found",
												html: "Reset code does not exist, please generate a new reset code"
											}).then((result) => {
												if (result.isConfirmed) { window.location = redirect_url_forgot; }
											});
										</script>
									<?php }
									else if($getResetInfo['status'] != 0) { ?>
										<script>
											var redirect_url_forgot = "<?php echo $redirect_url_forgot;?>";
											Swal.fire({
												icon: "error",
												title: "Not Found",
												html: "Reset code has already been used. Please generate a new reset code"
											}).then((result) => {
												if (result.isConfirmed) { window.location = redirect_url_forgot; }
											});
										</script>
									<?php }
									else {
										$userInfo = $action->userInfo($getResetInfo['userid']);
										$clientName = $userInfo['name'];
										$clientEmail = $userInfo['email'];
										
										if(isset($_POST['changePassword'])) {
											$userid = $_POST['userid'];
											$newPass = strtolower($_POST['newPass']);
											$confPass = strtolower($_POST['confPass']);
											
											if($newPass != $confPass) {
												echo $action->error("Password do not match");
											}
											else if(password_verify($newPass, $userInfo['password'])) {
												echo $action->error("New password is same as current password");
											}
											else {
												$password = password_hash($newPass, PASSWORD_BCRYPT);

												$changePass = $action->query("update user set password='$password' where id='$userid'");
												
												if($changePass->execute()) {
													$updateReset = $action->query("update resetpassword set status='1' where id='$userid' AND reset_code='$resetcode'");
													$updateReset->execute();
												?>
													<script>
														var redirect_url_login = "<?php echo $redirect_url_login;?>";
														Swal.fire({
															icon: "success",
															title: "Password Modified",
															html: "Your password has been modified successfully, kindly login now."
														}).then((result) => {
															if(result.isConfirmed) { window.location = redirect_url_login; }
														});
													</script>
												<?php
												}
												else {
													echo $action->error("Unable to change password");
												}
											}
											
										}
										
										?>
											<form method='post' class="p-2">
												<p style="color: #000">Kindly fill the form below to change your password</p>
												<div class="form-group">
													<label for="emailaddress">Name</label>
													<input class="form-control" value="<?php echo $clientName; ?>" disabled> <br>
												
													<label for="emailaddress">Email Address</label>
													<input class="form-control" value="<?php echo $clientEmail; ?>" disabled> <br>
												
													<label for="emailaddress">New Password</label>
													<input class="form-control" type="password" name="newPass" placeholder="Enter your new password" required> <br>
												
													<label for="emailaddress">Re-type Password</label>
													<input class="form-control" type="password" name="confPass" placeholder="Re-type Password" required>
													<input class="form-control" type="hidden" name="userid" value="<?php echo $getResetInfo['userid'];?>">
												</div>
												
												<div class="mb-3 text-center">
													<button class="btn btn-primary btn-block" type="submit" name="changePassword"> <b>Modify Password</b> </button>
												</div>
											</form>
										<?php
									}
								} 
								else { ?>
								
									<form method='post' class="p-2">
										<p style="color: #000">Forgot your password ? Don't be scared, it happens mostly. Get your password changed seems easy</p>
										<div class="form-group">
											<label for="emailaddress">Email Address or Mobile Number</label>
											<input class="form-control" type="text" id="username" name="username" placeholder="Enter your email or mobile number">
										</div>
										
										<div id="response" style="font-size: 20px"></div>
										
										<div class="mb-3 text-center">
											<button class="btn btn-primary btn-block" type="submit" name="requestLink" id="requestLink"> <b>Request Link</b> </button>
										</div>
									</form>
								<?php } ?>
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        <div class="row mt-4">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted mb-0">Don't have an account? <a href="joinus" style="color: red"><b>Sign Up</b></a> || 
									Don't have an account? <a href="login" style="color: red"><b>Login</b></a> </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>
</html>