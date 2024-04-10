<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Register Page | Poject Hub</title>
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
                                        <span><img src="assets/images/logo-dark.png" alt="" height="30"></span>
                                    </a>
                                </div>
                                <form method="post" class="p-2" id="memberInfo">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="fname" name="fname" placeholder="Enter your name">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="email" id="emailaddress" name="emailaddress" placeholder="Enter your email address">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="phoneno" name="phoneno" placeholder="Enter your mobile number" maxlength="11">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" id="password" name="password" placeholder="Enter your password">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" id="confPass" name="confPass" placeholder="Confirm your password">
                                    </div>
									
									<div id="response" style="font-size: 22px"></div>
									
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary btn-block" type="submit" id="signUp" name="signUp"> <b>Join Us</b> </button>
                                    </div>
                                </form>
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-4">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted mb-0">Already have an account? <a href="login" class="text-dark ml-1"><b>Sign In</b></a></p>
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