<?php

require "action.php"; $action = new Action();
require "class_monnify.php"; $monify = new monnify();
require "class_vtu.php"; $loadCall = new peaksms();

//Create account...
if(isset($_POST["signUp"])) {
	$fname = $_POST["fname"];
	$phoneno = $_POST["phoneno"];
	$email = $_POST["emailaddress"];
	$password = strtolower($_POST["password"]);
	$confPass = strtolower($_POST["confPass"]);
	
	if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
		echo "incorrect_email";
	} else if(!is_numeric($phoneno)) {
		echo "incorrect_phone";
	} else if($password != $confPass) {
		echo "pass_no_match";
	} else if($action->srchApplicant("email", $email) > 0) {
		echo "email_exists";
	} else if($action->srchApplicant("mobile", $phoneno) > 0) {
		echo "mobile_exists";
	} else {
		
		//Hash password...
		$password = password_hash($password, PASSWORD_BCRYPT);
		$reference = $action->randID(15);
		$references = $action->randID(15);
		
		//Sterling Account...
		$sterAccount = $monify->reserveAccount($fname, $email, $reference);
		
		//Wema and Rolez
		$sendRequest = $monify->reserveAccounts($fname, $email, $references);
		$decode_response = json_decode($sendRequest);
        $accounts = $decode_response->responseBody->accounts;
		
		for($itext=0; $itext<count($accounts); $itext++) {
    
            $decode_acc = $accounts[$itext];
            
            if(strpos(strtolower($decode_acc->bankName), "wema") !== FALSE) {
                $wemaBank = $decode_acc->accountNumber;
            }
            
            if(strpos(strtolower($decode_acc->bankName), "rolez") !== FALSE) {
                $rolezBank = $decode_acc->accountNumber;
            }

        }
        
        $wema_rolez = json_encode(["wema" => $wemaBank, "rolez" => $rolezBank]);
        
		if($action->saveMember($fname, $email, $phoneno, $password, $sterAccount, $reference, $wema_rolez, $references)) {
			echo "success";
		} else {
			echo "failed";
		}
		
	}
	
}

//Sign In...
if(isset($_POST["signIn"])) {
	$username = $_POST["username"];
	$password = strtolower($_POST["password"]);
	
	$loginResult = false;
	
	if($action->IsEmail($username)) {
		$srchUser = $action->query("select * from user where email='$username'"); $srchUser->execute();
		if($srchUser->rowCount() == 0) {
			echo "email_not_exist";
		} else {
			$loginResult = true;
		}
	} else { //Not email...
		if(!is_numeric($username) || strlen($username) > 11 || strlen($username) < 11) {
			echo "incorrect_phone";
		} else {
			$srchUser = $action->query("select * from user where mobile='$username'"); $srchUser->execute();
			if($srchUser->rowCount() == 0) {
				echo "mobile_not_exist";
			} else {
				$loginResult = true;
			}
		}
	}
	
	//Login Info exists.. check password;
	if($loginResult) {
		$srchUsers = $srchUser->fetch(PDO::FETCH_ASSOC);
		$uid = $srchUsers["id"];
		$savedpass = $srchUsers["password"];
		$verified = $srchUsers["isverified"];
		
		if(!password_verify($password, $savedpass)) {
			echo "incorrect_pass";
		} else if($verified == 0) {
			echo "<div class='alert alert-danger'><b> Error : </b>Your account is pending activation, 
			kindly check your email inbox or spam folder to activate your account.<br><br> 
			Resend activation link <a href='resendActivation?umail=".base64_encode($uid)."' target='_blank'>Resend Email</a>";
		} else { //Successfully login...
			$_SESSION["uid"] = $uid;
		?>
			<script>
				window.location = "account/dashboard";
			</script>
			
		<?php }
	}
}

//Update password...
if(isset($_POST["updatePass"])) {
	$currpwd = strtolower($_POST["currpwd"]);
	$newpwd = strtolower($_POST["newpwd"]);
	$re_newpwd = strtolower($_POST["re_newpwd"]);
	
	if(!password_verify($currpwd, $action->userInfo($_SESSION["uid"])["password"])) {
		echo "wrong_currpwd";
	} else if($currpwd == $newpwd) {
		echo "same_pass";
	} else if($newpwd != $re_newpwd) {
		echo "pass_differs";
	} else if(empty($_SESSION["uid"])) {
		echo "login_needed";
	} else {
		
		//Hash password...
		$password = password_hash($newpwd, PASSWORD_BCRYPT);
		
		$changePass = $action->query("update user set password='$password' where id='".$_SESSION["uid"]."'");
		if($changePass->execute()) {
			echo "updated";
			session_destroy();
		} else {
			echo "error_updating";
		}
	}
	
}


// print_r($_POST);

//Update password...
if(isset($_POST["updateAccKey"])) {
	$currpwd = strtolower($_POST["currpwd"]);
	$newpwd = strtolower($_POST["newpwd"]);
	$re_newpwd = strtolower($_POST["re_newpwd"]);
	
	$savedAccess = $action->userInfo($_SESSION["uid"])["accesskey"];
	
	if(!is_numeric($newpwd) || !is_numeric($newpwd)) {
		echo "number_only";
	} else if($newpwd == '0000' || $re_newpwd == '0000') {
		echo "def_zero";
	} else if($currpwd == $newpwd) {
		echo "same_access";
	} else if($currpwd != $savedAccess) {
		echo "wrong_curr_access";
	} else if(empty($_SESSION["uid"])) {
		echo "login_needed";
	} else {
		$changeAcc = $action->query("update user set accesskey='$newpwd' where id='".$_SESSION["uid"]."'");
		if($changeAcc->execute()) {
			echo "updated";
		} else {
			echo "error_updating";
		}
	}		
	
}

//Get account...
if(isset($_POST["getAcct"])) {
	
	#echo 111;
	$account = json_encode(["account_number" => $_POST["accNo"] , "account_bank"=>$_POST["bank_Name"]]);
	$account_result = $action->resolveAccount($account); 
	
	if(!empty($account_result)) {
	?>
	
	<font size="4px"><b>Account Name : </b><?php echo $account_result;?></font>
	<input id="accName" name="accName" value="<?php echo $account_result; ?>" type="hidden">
<?php } else { echo "error"; }
}
	
//Get all data...
if(isset($_REQUEST['fetchdaTas'])) {
	$network = $_POST["network"];
	
	if ($network == "Direct") {
		$rchProd = $action->query("select * from products where category='Data Bundle' and dataName like '%Direct%'"); $rchProd->execute();
	} else if($network == "SME") {
		$rchProd = $action->query("select * from products where category='Data Bundle' and dataName like '%SME%'"); $rchProd->execute();
	} else {
		$rchProd = $action->query("select * from products where category='Data Bundle' and dataName like '%$network%'"); $rchProd->execute();
	}
	?>
		<label for="gsmdata"><b>Select Data Bundle</b></label>
		<select class="form-control" name="gsmdata" id="gsmdata" onchange="getData()" required>
			<option value="">-- Select --</option>
			<?php
			foreach($rchProd as $rchProds) { ?>
				<option value="<?php echo $rchProds["id"];?>"><?php echo $rchProds["dataName"];?></option>
			<?php } ?>
		</select>
	<?php
}

if(isset($_REQUEST["fetchdataPrices"])) {
	$gsmdata = $_REQUEST["gsmdata"];
        
	$searchId = $action->query("select * from products where id ='$gsmdata'"); $searchId->execute();
	$srchProd = $searchId->fetch(PDO::FETCH_ASSOC);
	$pname = $srchProd["dataName"];
	?>
        <label><b>Data Price:</b></label>
        <input value="&#8358;<?php echo number_format($srchProd["price"], 2);?>" class="form-control input-sm" disabled> <br>
        <label><b>Amount To Pay:</b></label>
        <input value="&#8358;<?php echo number_format($srchProd["price"] - (($srchProd["price"]*$action->airtimeSettings()->dataPercent)/100), 2);?>" class="form-control input-sm" disabled> <br>
	<?php
}


//Cart....
if(isset($_POST["addCart"])) {
	echo 111;
}

//Request for password reset link...
if(isset($_REQUEST['requestLink'])) {
	
	$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
	
	//Find user info...
	if($action->IsEmail($username)) {
		$srchUser = $action->query("select * from user where email='$username'"); $srchUser->execute();
	} else { //Not email...
		if(!is_numeric($username) || strlen($username) > 11 || strlen($username) < 11) {
			echo "incorrect_phone";
		} else {
			$srchUser = $action->query("select * from user where mobile='$username'"); $srchUser->execute();
		}
	}
	
	if($srchUser->rowCount() == 0) {
		echo "user_not_found";
	}
	else {
	
		$srchUsers = $srchUser->fetch(PDO::FETCH_ASSOC);
		$name = $srchUsers["name"];
		$email = $srchUsers["email"];
		$userid = $srchUsers["id"];
		
		//Search if code exists in reset password...
		$srchReset = $action->query("select * from resetpassword where userid = '$userid' and status = 0"); $srchReset->execute();
		
		if($srchReset->rowCount() > 0) {
			$srchResetInfo = $srchReset->fetch(PDO::FETCH_ASSOC);
			$resetCode = $srchResetInfo['reset_code'];
		} else { 
			$resetCode = $action->randID(18);
			$saveReset = $action->query("insert into resetpassword (userid, reset_code) values  ('$userid', '$resetCode')"); 
			$saveReset->execute();
		}
				
		$resetLink = BASE_URL."recoverpwd?reset=". $resetCode;
			
		$message= "<html>
        <head>
            <title>".$subject."</title>
        </head>
        <body>
            <div style='width:80%;margin:0px auto;padding:10px;background:#fff;'>
                
                    <p style='font-size:22px; color: #000'><em>Hi ". $name."</em></p>
    
                    <p style='font-size:20px;color:#000;font-family:georgia;'>
                        You recently request for a password reset on your account. Kindly copy your reset code to change your password. 
                        <br><br>Reset Code: ". $resetCode . "<br><br>
						Alternatively, you can click on the link below to change your password
						<br><br>
						
						<a href='".$resetLink."'>".$resetLink."</a>
                        
                        <br><br>Regards,<br>
                        Project Hub
                    </p>
                <div style='background:#000; color:#fff; padding:5px;'>&copy; ". date('Y') ." Project Hub All Rights Reserved </div>
            </div>
    </body>
    </html>";
		
	$sender = "no-reply@projecthub.com";
	$subject = "Reset your password";
		
		if($action->sendmail($subject, $sender, $email, $message)) {
			echo "sent";
			exit;
		}
		else {
			echo "failed";
			exit;
		}
		
	}
}

//Search for decoder...
if(isset($_REQUEST["getDecoder"])) {
	$decoderName = filter_var($_POST['decoderName'], FILTER_SANITIZE_STRING);
	
	if(strpos($decoderName, "star") !== FALSE) { $decName = "star"; } else { $decName = $decoderName; }
	
	$srchCable = $action->query("select * from products where dataName like '%$decName%'"); $srchCable->execute();

	if($srchCable->rowCount() == 0) {

	} else { ?>
		<br>
		<label for="decoderPackage"><b>Select Package:</b></label>
		<select class="form-control" name="decoderPackage" id="decoderPackage" required>
			<option value=""> -- Select package --</option>
			<?php
			while($srchCableInfo = $srchCable->fetch(PDO::FETCH_ASSOC)) { ?>
				<option value="<?php echo $srchCableInfo["prodID"]; ?>">
					<?php echo $srchCableInfo["dataName"]; ?> - &#8358;<?php echo number_format($srchCableInfo["price"], 2); ?>
				</option>
			<?php } ?>
		</select>
		<?php

	}

}

if(isset($_REQUEST['verifyIUC'])) {
	$cableName = filter_var($_POST['cableName'], FILTER_SANITIZE_STRING);
	$iucNo = filter_var($_POST['iucNo'], FILTER_SANITIZE_STRING);

	$verifyCable = $loadCall->postdata("cableverify", json_encode(["decoderName" => $cableName, "iucNo" => $iucNo]));

	//Let's decode the cable...
	$decode_cable = json_decode($verifyCable);

	if($cableName == "gotv" OR $cableName == "dstv") { ?>
		Account Status: <?php echo $decode_cable->details->accountStatus;?> <br>
		SMARTCARD NO: <?php echo $iucNo;?> <br>
		Registered Name:  <?php echo $decode_cable->details->lastName;?> <br>
		Due Date: <?php echo str_replace("T00:00:00+01:00", "", $decode_cable->details->dueDate);?> <br>
		Customer Number:  <?php echo $decode_cable->details->customerNumber;?> <br>
	<?php }
	else { ?>
		Account Status: <?php echo $getme->details->customerType;?> <br>
		SMARTCARD NO: <?php echo $iuc;?> <br>
		Registered Name:  <?php echo $getme->details->customerName;?> <br>
		Balance: <?php echo $getme->details->balance;?> <br>
	<?php }

}

?>