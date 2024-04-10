<title>Verify Applicant</title>

<script src="https://use.fontawesome.com/5a6f9d7a85.js"></script>

<body style="background-color: #f3f3f3; font-size: 28px">

<?php

require "action.php"; $action = new Action();

$verifyCode = $_REQUEST["id"];

$chkVery = $action->query("select * from verification where code='$verifyCode'"); $chkVery->execute();

$chkVerys = $chkVery->fetch(PDO::FETCH_ASSOC);


if($chkVery->rowCount() == 0) { ?>
	<p>
		Oops! Account verification code is incorrect. Kindly copy the code from your email and paste it to your browser or Alternatively, kindly click on the url in the email.
	</p>
	<script>
		setTimeout(function() {
			window.location = "login";
		}, 5000);
	</script>
<?php } else {
	
	if($chkVerys["status"] != 0) { ?>
	<p>
		Oops, Your account has been verified already
	</p>
	<script>
		setTimeout(function() {
			window.location = "login";
		}, 5000);
	</script>
<?php } else {
		$userid = $chkVerys["userid"];
		$updtApplcnt = $action->query("update user set isverified=1 where id='$userid'"); $updtApplcnt->execute();
		$updtVery = $action->query("update verification set status=1 where code='$verifyCode' and userid='$userid'"); $updtVery->execute();
		 ?>
	<p>
		Your account has been verified. You will be redirected in 5seconds <i class="fa fa-spinner fa-spin"></i>
	</p>
	<script>
		setTimeout(function() {
			window.location = "login";
		}, 5000);
	</script>
<?php
	}
	
}

?>