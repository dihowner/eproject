<?php require "../action.php"; $action = new Action(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <title>Login Page | Project Hub</title>
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
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                
								<div class="text-center mb-4 mt-3">
                                    <a href="index.html">
                                        <span><img src="../assets/images/logo-dark.png" alt="" height="30"></span>
                                    </a>
                                </div>
								<?php
								if(isset($_POST["signIn"])) {
									$username = strtolower($_POST["username"]);
									$password = strtolower($_POST["password"]);
									
									//Search user...
									$srchAdm = $action->query("select * from secret where username='$username'"); $srchAdm->execute();
									if($srchAdm->rowCount() > 0) {
										$srchAdms = $srchAdm->fetch(PDO::FETCH_ASSOC);
										$savedpass = $srchAdms["password"];
										
										if(!password_verify($password, $savedpass)) { ?>
											<div class="alert alert-danger"><b>Error: </b> Incorrect password supplied</div>
										<?php } else {
											$_SESSION["uid"] = $srchAdms["id"];
											$action->redirect_to("dashboard");
										}
										
									} else { ?>
										<div class="alert alert-danger"><b>Error: </b> Username does not exist</div>
									<?php }
									
								}
								?>
								
								
                                <form method='post' class="p-2">
                                    <div class="form-group">
                                        <label for="emailaddress">Username</label>
                                        <input class="form-control" type="text" id="username" name="username" placeholder="Enter your username">
                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress">Password</label>
                                        <input class="form-control" type="password" id="password" name="password" placeholder="Enter your password">
                                    </div>
									
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary btn-block" type="submit" name="signIn" id="signIn"> <b>Sign In</b> </button>
                                    </div>
                                </form>
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        <div class="row mt-4">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted mb-0">Don't have an account? <a href="joinus" class="text-dark ml-1"><b>Sign Up</b></a></p>
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
        <script src="../assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>

    </body>
</html>