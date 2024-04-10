<?php

class monnify extends action {
	
    /*
	private $endpointQuery = "https://api.monnify.com/api/v1/merchant/transactions/query";
    private $getAuth_base = "https://api.monnify.com/api/v1/auth/login";
    private $reserve_base = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
    
    */
    
    private $endpointQuery = "https://sandbox.monnify.com/api/v1/merchant/transactions/query";
    private $getAuth_base = "https://sandbox.monnify.com/api/v1/auth/login";
    private $reserve_base = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
	
	private function providusInfo() {
        global $action;
        
        $loadApp = $action->query("select * from settings where name='monnify'"); $loadApp->execute();
		$loadApps = $loadApp->fetch(PDO::FETCH_ASSOC);
        return json_decode($loadApps["value"]);
    }
    
    private function getAuth() {
        $curl = curl_init();
    		curl_setopt_array($curl, array(CURLOPT_URL => $this->getAuth_base,
        		CURLOPT_RETURNTRANSFER => true,
        		CURLOPT_ENCODING => "",
        		CURLOPT_MAXREDIRS => 10,
        		CURLOPT_TIMEOUT => 0,
        		CURLOPT_FOLLOWLOCATION => true,
        		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        		CURLOPT_CUSTOMREQUEST => "POST",
        		CURLOPT_HTTPHEADER => array("Content-Type: application/json",
	                                "Authorization: Basic ".base64_encode(str_replace(" ", "", $this->providusInfo()->apiKey).':'.str_replace(" ", "", $this->providusInfo()->secKey))       
							    ),
			));
		$response = curl_exec($curl);
		return $response;
    }
	
	public function reserveAccount($uname, $email, $reference) {
        $body = json_encode([
                    "accountReference"=>$reference,
                    "accountName"=>$uname,
                    "currencyCode"=>"NGN",
                    "contractCode"=>$this->providusInfo()->contractCode,
                    "customerEmail"=>$email,
                    "customerName"=>$uname,
                    "getAllAvailableBanks"=>232 //035 is for wema...
                ]);
                
        $accessToken = json_decode($this->getAuth());
                
        $accessToken = $accessToken->responseBody->accessToken;
        
        $curl = curl_init();
		curl_setopt_array($curl, array(CURLOPT_URL => $this->reserve_base,
        								CURLOPT_RETURNTRANSFER => true,
        								CURLOPT_ENCODING => "",
        								CURLOPT_MAXREDIRS => 10,
        								CURLOPT_TIMEOUT => 0,
        								CURLOPT_FOLLOWLOCATION => true,
        								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        								CURLOPT_CUSTOMREQUEST => "POST",
        								CURLOPT_POSTFIELDS => $body,
        								CURLOPT_HTTPHEADER => array("Content-Type: application/json",
								                                    "Authorization:Bearer ".$accessToken  
										                           ),
						));
		$response = curl_exec($curl);
    		
        //Get Sterling...
        $response_item = json_decode($response);
        $decode_response = $response_item->responseBody->accounts;
        $sterAcct = $decode_response["0"]->accountNumber;
        	
		return $sterAcct;
		
    }
    
    //Get Rolez & Wema
    public function reserveAccounts($uname, $email, $reference) {
        $body = json_encode([
                    "accountReference"=>$reference,
                    "accountName"=>$uname,
                    "currencyCode"=>"NGN",
                    "contractCode"=>$this->providusInfo()->contractCode,
                    "customerEmail"=>$email,
                    "customerName"=>$uname,
                    "getAllAvailableBanks"=>true //035 is for wema...
                ]);
                
        $accessToken = json_decode($this->getAuth());
                
        $accessToken = $accessToken->responseBody->accessToken;
        
        $curl = curl_init();
		curl_setopt_array($curl, array(CURLOPT_URL => $this->reserve_base,
        								CURLOPT_RETURNTRANSFER => true,
        								CURLOPT_ENCODING => "",
        								CURLOPT_MAXREDIRS => 10,
        								CURLOPT_TIMEOUT => 0,
        								CURLOPT_FOLLOWLOCATION => true,
        								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        								CURLOPT_CUSTOMREQUEST => "POST",
        								CURLOPT_POSTFIELDS => $body,
        								CURLOPT_HTTPHEADER => array("Content-Type: application/json",
								                                    "Authorization:Bearer ".$accessToken  
										                           ),
						));
		$response = curl_exec($curl);
    		
		return $response;
		
    }
	
	public function receivePay($info) {
        session_start();
        //receive the order...
        return $this->creditMemb($info);
    }
	
	private function creditMemb($info) {
        global $action;
        $result = json_decode($info, true);
        
        $hash = hash("SHA512" ,str_replace(" ", "", $this->providusInfo()->secKey)."|".$result['paymentReference']."|".$result['amountPaid']."|".$result['paidOn']."|".$result['transactionReference']);
    	
    	$approvedBy = $result['accountPayments']['0']['accountName']; //to be used on payn
        
        $loadPay = $action->query("select * from payment where reference='".$result["paymentReference"]."'"); $loadPay->execute();
        
        if(empty($result["paymentReference"])) {
            $response = json_encode(['message' => 'Payment reference not found', 'status' => '400']);
        } else if($loadPay->rowCount() > 0) {
            $response = json_encode(['message' => 'Payment already approved', 'status' => '400']);
        } else {
            $data = http_build_query([ "paymentReference" =>$result["paymentReference"] ]);
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->endpointQuery."?".$data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_SSL_VERIFYPEER=> false,
                CURLOPT_SSL_VERIFYHOST=> false,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS =>'',
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                    "Authorization:  Basic ".base64_encode(str_replace(" ", "", $this->providusInfo()->apiKey).':'.str_replace(" ", "", $this->providusInfo()->secKey))
                ),
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err){ return false; }  else { 
				
				//Let's check the response we got from Monnify, needs to be decode...
                
                $resp = json_decode($response);
                
                if($hash==$result["transactionHash"] && $resp->responseBody->paymentStatus=="PAID") {
                    
                    if($result["product"]["type"] == "RESERVED_ACCOUNT") { //if reserved/mapped account
						
						$reference = $result["product"]["reference"]; // Providus account reference
                        
                        //Search account reference number...
                        $srchClnt = $action->query("select * from user where providus_reference='$reference'"); $srchClnt->execute();
                        
						$srchClnts = $srchClnt->fetch(PDO::FETCH_ASSOC);
						
						$currBlc = $srchClnts["main_bal"]; //what's the current balance of the member making payment...
						
						$userid = $srchClnts["id"]; //what's the id of the user paying....
						
						$amountPaid = $result["amountPaid"]; // how much was paid to monnify without settlement amount....
						
						$resp = json_encode(["txref"=>$result["paymentReference"], "apprBy"=>"Monnify System"]);
						$newBlc = $currBlc + $amountPaid;
						
                        $mytime = date("D j F, Y; h:i a");
                        $approvedBy = 'Monnify System';
                        
                        if($action->updatebal($newBlc, "main_bal", $userid)) {
						    $savePayment = $action->query("insert into payment (userid, amount, bfrAmnt, aftAmnt, timed, status, memo, method, reference) values ('$userid', '$amountPaid', '$currBlc','$newBlc', '$mytime', '1', '$resp', '$approvedBy', '".$result["paymentReference"]."')");
							$savePayment->execute();
						    $response = json_encode(['message' => 'Payment approved successfully', 'status' => '200']);
                        }
                    }
                }
            }
        }
    		
		return $response;
		
	}
}

$runTest = new monnify();
