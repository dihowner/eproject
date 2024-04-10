<title>Verify Applicant</title>

<script src="https://use.fontawesome.com/5a6f9d7a85.js"></script>

<body style="background-color: #f3f3f3; font-size: 28px">

<?php

require "action.php"; $action = new Action();

$id = base64_decode($_REQUEST["umail"]);

$chkVery = $action->query("select * from user where id='$id'"); $chkVery->execute();

$chkVerys = $chkVery->fetch(PDO::FETCH_ASSOC);
$umail = $chkVerys['email'];

if($chkVery->rowCount() == 0) { ?>
	<p>
		Oops! User does not exists
	</p>
	<script>
		setTimeout(function() {
			window.location = "login";
		}, 5000);
	</script>
<?php } else if($chkVerys["verified"] == 1) { ?>
	<p>
		Oops! Your account has been verified already
	</p>
	<script>
		setTimeout(function() {
			window.location = "login";
		}, 5000);
	</script>
<?php } else { 
	
	//Get Code...
	$srchVery = $action->query("select * from verification where userid='".$chkVerys["id"]."'"); $srchVery->execute();
	$srchVerys = $srchVery->fetch(PDO::FETCH_ASSOC);
	$veryCode = $srchVerys["code"];
	
	$message= "<html>
            <head>
                <title>Verify your Project Hub Account</title>
            </head>
			<body style='background-color: #f3f3f3;'>
  <table border='0' cellpadding='0' cellspacing='0' width='100%' style='margin-top: 2%'>
    <tr>
      <td align='center' bgcolor='#f3f3f3'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
          <tr>
            <td align='left' bgcolor='#ffffff' style='padding: 36px 24px 0; font-family: Helvetica, Arial, sans-serif; border-top: 3px solid #32b5e7;'>
              <h1 style='text-align: center; margin: 0; font-size: 36px; font-weight: 700; letter-spacing: -1px; line-height: 48px;'>PROJECT HUB</h1>
              <h4 style='text-align: center; margin: 0; font-size: 20px; font-weight: 700; letter-spacing: -1px; line-height: 48px;'>Account Verification!</h4>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align='center' bgcolor='#f3f3f3'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
          <tr>
            <td align='left' bgcolor='#ffffff' style='padding: 24px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;'>
              <p style='margin: 0;'>
				Hey <b>".$chkVerys['name'].", </b> You're almost ready to start enjoying Project Hub. 
				Kindly confirm that you used this email to create an account with Project Hub. 
				Once verified, you can now start enjoying Project Hub features.
				<br><br>
				<div style='background: #f3f3f3; padding: 15px'>
					<b>Verification Link :</b> <br><a href='http://nairaportal.com/projecthub/verifyMember?id=".$veryCode."' target='_blank' style='color: #1c6ea8; text-decoration: none;'>
						http://nairaportal.com/projecthub/verifyMember?id=".$veryCode."</a>
				</div>
				<br><br>
				<a href='http://nairaportal.com/projecthub/verifyMember?id=".$veryCode."' target='_blank' style='background: #32b5e7; color: #fff; text-decoration: none; padding: 10px 30px 10px 30px;'>
					<b>Verify Email</b>
				</a>
			  </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
	
    <tr>
      <td align='center' bgcolor='#f3f3f3' style='padding: 24px;'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
          <tr>
            <td align='center' bgcolor='#f3f3f3' style='padding: 12px 24px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;'>
              <p style='color: #000; margin: 0;'>You received this email because a projecthub account was created for You, you can safely delete this email if this message is strange.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>";
	
	$action->sendmail("Verify your Project Hub Account", "no-reply@projecthub.com", $umail, $message);
	
?>
	<p>
		Verification code has been resent to your email address.
	</p>
	<script>
		setTimeout(function() {
			window.location = "login";
		}, 5000);
	</script>
<?php }

?>