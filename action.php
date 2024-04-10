<?php
error_reporting(0);
session_start();
set_time_limit(0);
date_default_timezone_set("Africa/Lagos");

require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

$config = new Config();

class Action extends Config  {
	
	public function srchApplicant($cols, $val) {
		try {
			$queryRun = $this->con->prepare("select * from user where $cols='$val'");
			$queryRun->execute();
			return $queryRun->rowCount();
		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}
	
	public function userInfo($uid) {
		try {
			$queryRun = $this->con->prepare("select * from user where id='$uid'"); $queryRun->execute();
			$queryRuns = $queryRun->fetch(PDO::FETCH_ASSOC);
			return $queryRuns;
		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}
	
	public function countMarket($uid, $type) {
		try {
			
			switch($type) {
				case "totalUpload": 
					$queryRun = $this->con->prepare("select * from market where userid='$uid' and status=1"); $queryRun->execute();
					return $queryRun->rowCount();
				break;
				case "totalDwlnd": 
					$queryRun = $this->con->prepare("select sum(downloads) as downloads from market where userid='$uid' and status=1"); $queryRun->execute();
					$queryRuns = $queryRun->fetch(PDO::FETCH_ASSOC);
					return $queryRuns["downloads"];
				break;
				
			}
			
			
		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}
	
	public function updatebal($blc, $cols, $uid) {
		try {
			$queryRun = $this->con->prepare("update user set $cols='$blc' where id='$uid'"); 
			return $queryRun->execute();
		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}

	public function saveMember($uname, $email, $telno, $password, $sterAccnt, $reference, $wema_rolez, $wema_rolez_reference) {
		try {
			$queryRun = $this->con->prepare("insert into user (name, email, mobile, password, providusID, providus_reference, wema_rolez, wema_rolez_reference, accesskey) values ('$uname', '$email', '$telno', '$password', '$sterAccnt', '$reference', '".addslashes($wema_rolez)."', '$wema_rolez_reference', '0000')");
			
			if($queryRun->execute()) {
				
				$veryCode = $this->randID(25);
				
				$saveVery = $this->con->prepare("insert into verification (userid, code) values ('".$this->lastInsertId()."', '$veryCode')");
				$saveVery->execute();
				
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
				Hey <b>".$uname.", </b> You're almost ready to start enjoying Project Hub. 
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
				
				
				$this->sendmail("Verify your Project Hub Account", "no-reply@projecthub.com", $email, $message);
				
				return true;
				
			} else {
				return false;
			}

		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}
	
	public function readByIds($ids) {
		$ids_arr = str_repeat('?,', count($ids) - 1) . '?';
	 
		// query to select products
		$query = "SELECT * FROM market WHERE projectID IN ({$ids_arr}) ORDER BY project_name";
	 
		// prepare query statement
		$stmt = $this->con->prepare($query);
	 
		// execute query
		$stmt->execute($ids);
	 
		// return values from database
		return $stmt;
	}
	
	public function deptName($depatID) {
		//we need to get department name with the id
		$loadDept = $this->con->prepare("select * from department where id='$depatID'"); $loadDept->execute();
		$dept = $loadDept->fetch(PDO::FETCH_ASSOC);
		$deptName = $dept["dertmentName"];
		return $deptName;
	}
	
	public function materialInfo($mat_id) {
		//we need to get department name with the id
		$loadMat = $this->con->prepare("select * from market where projectID='$mat_id'"); $loadMat->execute();
		$loadMats = $loadMat->fetch(PDO::FETCH_ASSOC);
		return $loadMats;
	}
	
	public function sideMenu($uid) { ?>
		<div id="sidebar-menu">
    
                <ul class="metismenu" id="side-menu">
    
                    <li class="menu-title">Navigation</li>
    
                    <li>
                        <a href="dashboard">
                            <i class="ti-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
    
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-user"></i>
                            <span> My Account </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="fundWallet">Fund Wallet</a></li>
                            <li><a href="wallethistory">Wallet History</a></li>
                            <!-- <li><a href="wallethistory">Wallet History</a></li> -->
                            <li><a href="updateProfile">Update Profile</a></li>
                            <li><a href="changePass">Change Password</a></li>
                            <li><a href="changeAccess">Access Key</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="../market">
                            <i class="ti-shopping-cart"></i>
                            <span> Market </span>
                        </a>
                    </li>
    
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-shopping-cart-full"></i>
                            <span>  Ware House  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="uploadProject">Upload Project</a></li>
                            <li><a href="uploadHistory">My Uploads</a></li>
                            <li><a href="mydownload">My Downloads</a></li>
                        </ul>
                    </li>
    
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-newspaper"></i>
                            <span>  Ads Management  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="createAds">Create Ads</a></li>
                            <li><a href="adsHistory">Ads History</a></li>
                        </ul>
                    </li>
    
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-shopping-cart-full"></i>
                            <span> Services </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="airtimeTopup">Airtime Topup</a></li>
                            <li><a href="databundle">Data Bundle</a></li>
                            <li><a href="cableTv">Cable Tv</a></li>
                            <li><a href="#">Electricity Bills</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="logOff" onclick="logOff(event)">
                            <i class="ti-power-off"></i>
                            <span> Sign Out </span>
                        </a>
                    </li>
					
                </ul>
    
            </div>
	<?php }
	
	public function adminsideMenu($uid) { ?>
		<div id="sidebar-menu">
    
                <ul class="metismenu" id="side-menu">
    
                    <li class="menu-title">Navigation</li>
    
                    <li>
                        <a href="dashboard">
                            <i class="ti-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
    
                    <li>
                        <a href="gen_settings">
                            <i class="fa fa-cog"></i>
                            <span> General Settings </span>
                        </a>
                    </li>
    
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-newspaper"></i>
                            <span> Ads Management </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="pendAds">Pending Ads</a></li>
                            <li><a href="adsHistory">Ads History</a></li>
                        </ul>
                    </li>
    
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-user"></i>
                            <span> User Management </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="memberList">Member List</a></li>
                        </ul>
                    </li>
					
                </ul>
    
            </div>
	<?php }
	
	public function providusInfos() {
        
        $loadApp = $this->con->prepare("select * from settings where name='monnify'"); $loadApp->execute();
		$loadApps = $loadApp->fetch(PDO::FETCH_ASSOC);
        return json_decode($loadApps["value"]);
		
    }
	
	public function getstatus($statcode) {
		if ($statcode == 0) {
			return "<font color='brown'><b>Pending Approval</b></font>";
		} elseif ($statcode == 1) {
			return "<font color='green'><b>Approval Successful</b></font>";
		}  elseif ($statcode == 2) {
			return "<font color='red'><b>Project Rejected</b></font>";
		}
	}
	
	public function resolveAccount($account) {
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.flutterwave.com/v3/accounts/resolve",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$account,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			 'Authorization: Bearer '.$this->flutterSettings()->seckey
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		if ($err){ return false; }
		else {
			$result = json_decode($response);
			$accountName = $result->data->account_name;
			return $accountName;
		}
	}
	
	private function flutterSettings() {
        $usr = $this->con->prepare("SELECT * FROM `settings` where name='flutterSettings'");
        $usr->execute();
        $usrInfo = $usr->fetch(PDO::FETCH_ASSOC);
        $setValue = $usrInfo["value"];
        return json_decode($setValue);
    }
	
	public function airtimeSettings() {
        $usr = $this->con->prepare("SELECT * FROM `settings` where name='airtimeSettings'");
        $usr->execute();
        $usrInfo = $usr->fetch(PDO::FETCH_ASSOC);
        $setValue = $usrInfo["value"];
        return json_decode(trim($setValue));
    }
	
	public function apiLink() {
        $usr = $this->con->prepare("SELECT * FROM `settings` where name='apiLink'");
        $usr->execute();
        $usrInfo = $usr->fetch(PDO::FETCH_ASSOC);
        $setValue = $usrInfo["value"];
        return json_decode($setValue);
    }
	
	public function degree($dg) {
		switch($dg) {
			case "hnd" :
				$progname = "Higher National DIploma";
			break;
			case "ond" :
				$progname = "Ordinary National DIploma";
			break;
			case "nce" :
				$progname = "Nigeria Certificate In Education";
			break;
			case "msc" :
				$progname = "Magister Scientiae";
			break;
			case "degree" :
				$progname = "Degree";
			break;
			case "pgd" :
				$progname = "Post Graduate Degree";
			break;
			case "others" :
				$progname = "Other Qualification";
			break;
			case $dg :
				$progname = $dg;
			break;
		}
		return $progname;
	}
    
    public function compressImage($source, $destination, $quality) {

      $info = getimagesize($source);

      if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

      elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

      elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

      imagejpeg($image, $destination, $quality);
        
        return true;
    
    }
	
	public function randID($length) { 
        $vowels = 'aeu'; //I do not want i & o
        $consonants = '23456789bcdfghjkmnpqrstvwxyz';  //I do not want 0, 1, l & L
        $idnumber = ''; 
        $alt = time() % 2; 
        for ($i = 0; $i < $length; $i++) { 
            if ($alt == 1) { 
                $idnumber.= $consonants[(rand() % strlen($consonants)) ]; 
                $alt = 0; 
            } else { 
                $idnumber.= $vowels[(rand() % strlen($vowels)) ]; 
                $alt = 1; 
            } 
        } 
         
        return $idnumber; 
    }
	
    private function lastInsertId() {
        $lastInsertId = $this->con->lastInsertId();
        return $lastInsertId;
    }
	
    public function redirect_to($link) {
        $redirect = header("Location:".$link);
        return $redirect;
    }
	
	public function query($query) {
        $query = $this->con->prepare($query);
        return $query;
    }

	
    public function rows($query) {
        $q = $this->con->prepare($query);
        $q->execute();
        $count = $q->rowCount();
        return $count;
    }

	public function sendmail($subject, $sender, $receiver, $message) {
		global $mail;
		//Set who the message is to be sent from
		$mail->setFrom($sender, $sender);
		//Set an alternative reply-to address
		$mail->addReplyTo($sender, '');
		//Set who the message is to be sent to
		$mail->addAddress($receiver, 'YNES');
		//Set the subject line
		$mail->Subject = $subject;
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);
		//Attach an image file
		// $mail->addAttachment('images/phpmailer_mini.png');
		//send the message, check for errors
		if (!$mail->send()) {
			return false;
			// echo 'Mailer Error: '. $mail->ErrorInfo;
		} else {
			return true;
		}
	}
	
    public function success($statement) {
        $success=  '<div class="alert alert-success alert-dismissable" style="color: black; font-size: 16px; text-transform: uppercase;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<b>'. $statement .'</b>
							</div>';

        return $success;
    }

    public function error($statement) {
        $error=  '<div class="alert alert-danger alert-dismissable" style="background-color: #f2dede; margin-right: 15px; color: black; font-size: 16px; text-transform: uppercase;">
								<b>'. $statement .'</b>
							</div>';

        return $error;
    }
	
	public function IsEmail($val) {
		if(filter_var($val, FILTER_VALIDATE_EMAIL) === FALSE) {
			return false;
		} else { return true; }
	}
	
	public function paginate($href, $sql) {
		// $PERPAGE_LIMIT = 20;
		$PERPAGE_LIMIT = 10;
		$result =  $this->con->prepare($sql); $result->execute();
		$count = $result->rowCount();
		$output = '';
		if(!empty($href)) {
			$href = "?$href";
		} else { $href = "?"; }
		
		if(!isset($_REQUEST["currentpage"])){
			$_REQUEST["currentpage"] = 1;
			$page = $_REQUEST["currentpage"];
		} else {
			$page = $_REQUEST["currentpage"];
		}
    
		if($PERPAGE_LIMIT != 0)
			$pages  = ceil($count/$PERPAGE_LIMIT);
				
		//if pages exists after loop's lower limit
		if($pages>1) {
			
			if(($_REQUEST["currentpage"]-3)>0) {
				$output = $output . '<a href="' . $href . 'currentpage=1" class="btn btn-primary btn-sm">1</a>';
			}
			if(($_REQUEST["currentpage"]-3)>1) {
				$output = $output . ' ... ';
			}
			
			
			// Page: 1 - 20 out of 364
			//Loop for provides links for 2 pages before and after current page
			for($i=($_REQUEST["currentpage"]-2); $i<=($_REQUEST["currentpage"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_REQUEST["currentpage"] == $i)
					$output = $output . '<span id='.$i.' class="btn btn-primary btn-sm">'.$i.'</span>';
				else
					$output = $output . '<a href="' . $href . "currentpage=".$i . '" class="btn btn-primary btn-sm" style="margin-left: 5px; margin-right: 5px">'.$i.'</a>';
			}

			//if pages exists after loop's upper limit
			if(($pages-($_REQUEST["currentpage"]+2))>1) {
				$output = $output . ' ... ';
			}
			if(($pages-($_REQUEST["currentpage"]+2))>0) {
				if($_REQUEST["currentpage"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="btn btn-primary btn-sm">' . ($pages) .'</span>';
				else
					$output =  $output . '<a href="' . $href .  "currentpage=" .($pages) .'" class="btn btn-primary btn-sm">' . ($pages) .'</a>';
			}
		
		}
    
		echo "Page:   $page  - ";  if($PERPAGE_LIMIT * $page > $count) { echo $count; } else { echo $PERPAGE_LIMIT * $page; } ?> 
		<?php echo ' out of '. $count  . ' ' . $output;
		
	}

}
$obj = new Action();
?>