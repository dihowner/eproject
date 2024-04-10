<?php require "action.php"; $action = new Action();
    // get the product id
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    $quantity = isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : 1;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=array();
    }

    // make quantity a minimum of 1
    $quantity=$quantity<=0 ? 1 : $quantity;


    #session_destroy();
    if(isset($_REQUEST["addCart"])) {
        // add new item on array
        $cart_item = array(
            'quantity'=>$quantity
        );

        // check if the item is in the array, if it is, do not add
        if(array_key_exists($id, $_SESSION['cart'])){
            echo "exists";
        } else {
            $_SESSION['cart'][$id] = $cart_item;
			echo "added";
        }
    }
	
	if(isset($_REQUEST["removeCart"])) {
        unset($_SESSION['cart'][$id]);
        echo "Item has been removed from your cart";
    }
	
	if(isset($_REQUEST["countCart"])) {
        $cart_count=count($_SESSION['cart']);
        //session_destroy();
        echo $cart_count;
    }
	
	if(isset($_REQUEST["delCart"])) {
        unset($_SESSION['cart'][$id]);
        echo "success";
    }
	
	if(isset($_REQUEST["pay_project"])) { //Pay for project ...
		$userid = $_SESSION["uid"];
		
		$userInfo = $action->userInfo($userid);
		$userbal = $userInfo["main_bal"];
		
		$amount = $_POST["amount"];
		
		if(!isset($userid) || empty($userid)) {
			echo "login_needed";
		} else if($amount > $userbal) {
			echo "insufficient";
		} else {
			$newBlc = $userbal - $amount;
			if($action->updatebal($newBlc, "main_bal", $userid)) {
				$mytime = date("D j F, Y; h:i a");
				$dataid = mt_rand(1111111, 9999999).mt_rand(1111111, 9999999);
				$saveBuy = $action->query("insert into allbuys (userid, network, amountDeduct, bfrAmnt, aftAmnt, status, timed, product, category, dataid) values ('$userid', 'Project', '$amount', '$userbal', '$newBlc', '1', '$mytime', 'Purchase of project topic material', 'project', '$dataid')");
				
				if($saveBuy->execute()) {
					
					foreach($_SESSION['cart'] as $id=>$value) {
						$project_id = $id;
						
						$d_url = $action->randID(25);
						$expire = date("Y-m-d H:i:s", strtotime("+3 hours"));
						$saveLnk = $action->query("insert into downloads (userid, project_id, timed, expires_on, download_url) values ('$userid', '$project_id', '$mytime', '$expire', '$d_url')");
						
						if($saveLnk->execute()) { $msg = "success"; 
						
					$message= "<html>
            <head>
                <title>Download - ".$action->materialInfo($project_id)["project_name"]."</title>
            </head>
			<body style='background-color: #f3f3f3;'>
  <table border='0' cellpadding='0' cellspacing='0' width='100%' style='margin-top: 2%'>
    <tr>
      <td align='center' bgcolor='#f3f3f3'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
          <tr>
            <td align='left' bgcolor='#ffffff' style='padding: 36px 24px 0; font-family: Helvetica, Arial, sans-serif; border-top: 3px solid #32b5e7;'>
              <h1 style='text-align: center; margin: 0; font-size: 36px; font-weight: 700; letter-spacing: -1px; line-height: 48px;'>PROJECT HUB</h1>
              <h4 style='text-align: center; margin: 0; font-size: 20px; font-weight: 700; letter-spacing: -1px; line-height: 48px;'>Download your material!</h4>
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
				Hi <b>".$userInfo["name"].", </b> Thanks for purchasing your project material from us. Kindly click on the link below to download your project material. Download link expires after <b>3 hours</b> of purchase
				<br><br>
				<div style='background: #f3f3f3; padding: 15px'>
					<b>Download Link :</b> <br>
						<a href='http://nairaportal.com/projecthub/dwldMtl?fileID=".$d_url."' target='_blank' style='color: #1c6ea8; text-decoration: none;'>
						http://nairaportal.com/projecthub/dwldMtl?fileID=".$d_url."</a>
				</div>
				<br><br>
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
		
$action->sendmail("Download your material", "no-reply@projecthub.com", $userInfo["email"], $message);		
						
						} else { $msg = "error"; }
						
					}
					
					echo $msg;
				} else { echo "error_saving"; }
				
				
			} else {
				echo "error_debit";
			}
			
		}
	}