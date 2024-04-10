<?php

class peaksms extends action {
	
	public function postdata($type, $data) {
		global $action;
        $data = json_decode($data);
        switch($type) {
			
            case "airtime_topup": 
				
                //We need to decode the data...
                $network = $data->network;
                $amount = $data->amount;
                // $amount = 10; #a test amount..
                $phoneno = $data->phone;
				
				$request_url =  $action->apiLink()->call . "airtime.php?phone=".$phoneno."&network=".$network."&amount=".$amount."&username=".$action->apiLink()->user."&password=".$action->apiLink()->pass;
				$response = $this->data_post( $request_url, $protocol = "POST" );
				
				// $response = '{"msg":"Order successful","status":"1","amount_charge":48,"orderid":"651575081348"}';
				
				$decodeResponse = json_decode($response, true);
				if(!empty($decodeResponse["orderid"])) {
					$_SESSION["response"] = $response;
					return true;
				} else { return false; }
				
				
				return $response;
				
				
			break;
			
			// */
			
			case "databundle":
                
                $phoneno = $data->phone;
                $volume = $data->databundle;
				
				#this for vtutopupbox, test server...
				$request_url =   $action->apiLink()->call . "buydata.php?phone=".$phoneno."&dataplan=".$volume."&username=".$action->apiLink()->user."&password=".$action->apiLink()->pass;
                
				$response = $this->data_post( $request_url, $protocol = "POST" );
				
				#$id = mt_rand(111111, 999999).mt_rand(111111, 999999).mt_rand(111111, 999999);
				#$response = '{"msg":"Order successful","status":"1","orderid":"'.$id.'"}';
				
				$decodeResponse = json_decode($response, true);				
				if(!empty($decodeResponse["orderid"])) {
					$_SESSION["response"] = $response;
					return true;
				} else { return false; }
				
				return $request_url;
				
			break;
			
			case "providerbalance":
			
				#this for vtutopupbox, test server...
				$request_url =   $action->apiLink()->call . "balance?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass;
				$response = $this->data_post( $request_url, $protocol = "POST" );
				$response = json_decode($response);
				return "&#8358;".number_format($response->bal, 2);
			break;
			
			case "cableverify":
				$decoderName = $data->decoderName;
				$iucNo = $data->iucNo;
				
				#this for peaksms, live server...
				// $request_url =   $action->apiLink()->call."decoder_check.php?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&service=".$decoderName."&number=".$iucNo;
								
				#this for vtutopupbox, test server...
				$request_url =   $action->apiLink()->call."checkcable.php?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&cable=".$decoderName."&iuc=".$iucNo;
				$response = $this->data_post( $request_url, $protocol = "POST" );
				return $response;
			break;
			
			case "cablepay":
				$decoderName = $data->decoderName;
				$iucNo = $data->iucNo;
				$productid = $data->productid;
				
				#this for peaksms, live server...
				// $request_url =   $action->apiLink()->call."decoderpay.php?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&smartno=".$iucNo."&productcode=".$this->providerID($productid);
								
				#this for vtutopupbox, test server...
				$request_url =   $action->apiLink()->call."cablepay.php?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&productid=".$this->providerID($productid)."&iuc=".$iucNo;
				$response = $this->data_post( $request_url, $protocol = "POST" );
				// $response = '{"msg":"Order successful","status":"1","orderid":"675565508731","bq":"GOTv Plus NGN 1900","cableType":"GOTV"}';
				
				$decodeResponse = json_decode($response, true);				
				if(!empty($decodeResponse["orderid"])) {
					$_SESSION["response"] = $response;
					return true;
				} else { return false; }
				
			break;
			
			case "electricverify":
				$disco = $data->disco;
				$meterNo = $data->meterNo;
				
				$request_url =   $action->apiLink()->call."verifymeter?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&meterno=".$meterNo."&productid=".$this->providerID($disco);
				$response = $this->data_post( $request_url, $protocol = "POST" );
				return $response;
			break;
			
			case "electricpay":
				$disco = $data->disco;
				$meterNo = $data->meterNo;
				$amount = $data->amount;
				
				$request_url =   $action->apiLink()->call."electricity?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&meterno=".$meterNo."&amount=".$amount."&productid=".$this->providerID($disco);
				$response = $this->data_post( $request_url, $protocol = "POST" );
				// $response = '{"msg":"Transaction successful","product":"IBEDC Prepaid","token":"3390 9368 8549 ********","token_amount":"100","orderid":"798705933226601","unit":"9023.5kw","status":1}';
				
				$decodeResponse = json_decode($response, true);	
				if(!empty($decodeResponse["orderid"])) {
					$_SESSION["response"] = $response;
					return true;
				} else { return false; }
			break;
			
			case "waecpay":
				$productID = $data->productid;
				$request_url =   $action->apiLink()->call."waecpay?username=".$action->apiLink()->user."&password=".$action->apiLink()->pass."&productid=".$this->providerID($productID);
				
				//return $request_url;
				
				$response = $this->data_post( $request_url, $protocol = "POST" );
				// $response = ' {"msg":"Order successful","status":"1","orderid":"228445927393714","pin":"424209394092","serial":"WRN17318983722","ordertype":"WAEC Result Checker"} ';
				
				$decodeResponse = json_decode($response, true);	
				if(!empty($decodeResponse["orderid"])) {
					$_SESSION["response"] = $response;
					return true;
				} else { return false; }
				
				
			break;
			
		}			
	}		

    public function verifyorder() {
        try {
            global $action;
            
		    $loadBuy = $action->query("select * from mybuys where (status=0 or status=2)"); $loadBuy->execute();

            while($loadBuys = $loadBuy->fetch(PDO::FETCH_ASSOC)) {
            	$id = $loadBuys["id"];
            	$orderid = $loadBuys["dataid"];
            	$amount = $loadBuys["amount"];
            	$userid = $loadBuys["userid"];
            	$userid = $loadBuys["userid"];
            	$category = $loadBuys["category"];
            	$productBuy = $loadBuys["product"];
            	$network = $loadBuys["network"];
            	$avalue = $loadBuys["avalue"];
            	$phoneno = $loadBuys["phoneno"];
            	
            	$userplan = $action->getPlanByID($action->userInfo($userid)['plan']);
            	
            	$request_url =  $action->apiLink()->call."verifyorder.php?orderid=".$orderid;
            	
				$response = $this->data_post( $request_url, $protocol = "POST" );
				
				$decodeResponse = json_decode($response, true);	
				
				$status = $decodeResponse["status"];
				$msg = $decodeResponse["msg"];
				    
        		if($category == "airtime") { $productBuy = $loadBuys["network"] . " ".$loadBuys["avalue"] . " for ".$phoneno; } 
        		else { $productBuy = $productBuy." for ".$phoneno; }
				    
			    switch($status) {
			        case "0":
		                $updtBuy = $action->query("update mybuys set status='0' where dataid='$orderid'"); $updtBuy->execute();
		            break;
			        case "1":
    					#the order is complete...
        				$updtBuy = $action->query("update mybuys set status='1', msg='$msg' where dataid='$orderid'"); $updtBuy->execute();
    					$updtRef = $action->query("update referral_transactions set status='1' where dataid='$orderid'"); $updtRef->execute();
    				break;
			        case "2":
    					#the order is complete...
    					$updtBuy = $action->query("update mybuys set status='2' where dataid='$orderid'"); $updtBuy->execute();
    					$updtRef = $action->query("update referral_transactions set status='2' where dataid='$orderid'"); $updtRef->execute();
    				break;
    				case "4":
    					#the order is refunded...
    					$updtBuy = $action->query("update mybuys set status='4', msg='$msg' where dataid='$orderid'"); $updtBuy->execute();
    					$updtRef = $action->query("update referral_transactions set status='4' where dataid='$orderid'"); $updtRef->execute();
    					
    					$bfrAmnt = $action->walletBlc($userid);
    					$aftAmnt = $bfrAmnt + $amount;
    					$mytime = $action->OrderDate();
    					
    					$resp = array();
						$resp["txref"] = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
						$resp["apprBy"] = "System Refund";
						$resp = addslashes(json_encode($resp));
						
						$inPay = $action->query("insert into payn (userid, amount, bfrAmnt, aftAmnt, timed, status, memo, method) values ('$userid', '$amount', '$bfrAmnt', '$aftAmnt', '$mytime', '4', '$resp', '$productBuy')"); $inPay->execute();
						$inBuy = $action->query("insert into mybuys (userid, network, avalue, amount, bfrAmnt, aftAmnt, phoneno, plan, status, timed, msg, product, category, dataid, cost_price) values ('$userid', '$network', '$avalue', '$amount', '$bfrAmnt', '$aftAmnt', '$phoneno', '$userplan', '-4', '$mytime', 'Order refunded', '$productBuy', '$category', '$orderid', '$amount')"); $inBuy->execute();
					    
					    $action->updateBlc($aftAmnt, $userid);
					    
					    echo $bfrAmnt . " ".$aftAmnt . " ".$userid. " ".$action->userInfo($userid)["email"] . "<br>";
					    
                	break;
			    }
            }
            
        } catch(PDOException $e) {
			echo $e->getMessage();
		}
    }
    
	private function providerID($productID) {
		try {
			global $action;
			$searchProvider = $action->query("select * from product where productID='$productID'");
			$searchProvider->execute();
			$srchProd = $searchProvider->fetch(PDO::FETCH_ASSOC);
			return $srchProd["providerID"];
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	private function data_post( $url_full, $protocol = "GET" ) {
    	$url = parse_url( $url_full );
    
    	$port = (empty($url["port"])) ? false : true;
    	// check if port is define as in the case of routesms
    	if (!$port) {
    		if (isset($url["scheme"]) && $url["scheme"] == "http") {
    			$url["port"] = 80;
    		} elseif (isset($url["scheme"]) && $url["scheme"] == "https") {
    			$url["port"] = 443;
    		}
    	}
    
    	if(isset($url["scheme"]))
    		$urlpost = $url["scheme"] . '://' . $url["host"] . $url["path"];
    
    	$url["query"] = empty($url["query"]) ? "" : $url["query"];
    	$url["path"] = empty($url["path"]) ? "" : $url["path"];
    	if (function_exists( "curl_init" )) {
    		if ($protocol == "GET") {
    			$ch = curl_init( $url["scheme"] . '://' . $url["host"] . $url["path"] . "?" . $url["query"] );
    			if ($ch) {
    				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    				curl_setopt( $ch, CURLOPT_HEADER, 0 );
    				if ($port)
    					curl_setopt( $ch, CURLOPT_PORT, $url["port"] );
    				$content = curl_exec( $ch );
    				curl_close( $ch );
    			} else {
    				$content = "";
    			}
    		} else {
    			$final_url = $url["scheme"] . '://' . $url["host"] . $url["path"];
    			$ch = curl_init();
    			if ($ch) {
    				curl_setopt($ch, CURLOPT_URL, $final_url);
    				curl_setopt( $ch, CURLOPT_POST, 1 );
    				curl_setopt( $ch, CURLOPT_POSTFIELDS, $url["query"] );
    				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
    				curl_setopt( $ch, CURLOPT_MAXREDIRS, 5 );
    				curl_setopt( $ch, CURLOPT_HEADER, 0 );
    				curl_setopt( $ch, CURLOPT_USERAGENT, "Autobizapp" );
    				if ($port)
    					curl_setopt( $ch, CURLOPT_PORT, $url["port"] );
    					curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
    					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    					$content = curl_exec( $ch );
    					curl_close( $ch );
    			} else {
    				$content = "";
    			}
    		}
    	} else if(function_exists( "fsockopen" )) {
    		$url["protocol"] = $url["scheme"] . "://";
    		$eol = "\r\n";
    		$h = "";
    		$postdata_str = "";
    		$getdata_str = "";
    		if ($protocol == "POST") {
    			$h = "Content-Type: text/html" . $eol . "Content-Length: " . strlen( $url["query"] ) . $eol;
    			$postdata_str = $url["query"];
    		} else {
    			$getdata_str = "?" . $url["query"];
    			$headers = "$protocol " . $url["protocol"] . $url["host"] . $url["path"] . $getdata_str . " HTTP/1.0" . $eol . "Host: " . $url["host"] . $eol . "Referer: " . $url["protocol"] . $url["host"] . $url["path"] . $eol . $h . "Connection: Close" . $eol . $eol . $postdata_str;
    			$fp = fsockopen( $url["host"], $url["port"], $errno, $errstr, 60 );
    			if ($fp) {
    				fputs( $fp, $headers );
    				$content = "";
    				while (!feof( $fp )) {
    					$content .= fgets( $fp, 128 );
    				}
    				fclose( $fp );
    				$pattern = "/^.*\r\n\r\n/s";
    				$content = preg_replace( $pattern, "", $content );
    			}
    		}
    	} else {
    		try {
    			if ($protocol == "GET") {
    				return file_get_contents( $url_full );
    			}
    			else {
    				$site = explode( "?", $url_full, 2 );
    				$content = file_get_contents( $site[0], false, stream_context_create( array("http" => array("method" => "POST", "header" => "Connection: close\r\nContent-Length: " . strlen( $site[1] ) . "\r\n", "content" => $site[1]))));
    			}
    		}
    		catch (Exception $g) {
    			$content = "";
    		}
    	}
    	return $content;
    }
	
	
}
$loadCall = new peaksms();
?>