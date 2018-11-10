<?php

class Sender{
	
	var $host;
	var $port;
	/*
	Username to be used for the submission*/
	var $strUserName;
	/*password to be used along the username*/
	var $strPassword;
	/*sender id to be used when sending the message*/
	var $strSender;
	/*message content that is to be transmitted*/
	var $strMessage;
	/*mobile number to be transmitted*/
	var $strMobile;
	/*
	what type of message is to be sent
	0 plain
	1 flash
	2 unicode
	6 unicode flash
	*/	
	var $strMessageType;
	/** require DLR
	0 DLR not required
	1 DLR required**/
	var $strDlr;
		
	private function sms_unicode($message){
		$hex1='';
		if(function_exists('iconv')){
			$latin = @iconv('UTF-8','ISO-8859-1',$message);
			if(strcmp($latin,$message)){
				$arr = unpack('H*hex',@iconv('UTF-8','UCS-2BE',$message));
				$hex1 = strtoupper($arr['hex']);
			}
			if($hex1==''){
				$hex2 = '';
				
				$hex = '';
				
				for($i=0; $i<strlen($message);$i++){
					$hex = dechex(ord($message[$i]));
					$len = strlen($hex);
					$add = 4 - $len;
					if($len<4){
						for($j=0;$j<$add;$j++){
							$hex = "0".$hex;
						}
					}
					$hex2 .= $hex;
				}
				return $hex2;
			}
			else{
				return $hex1;
			}
		}
		else{
			print 'iconv Function Not Exists !';
		}
	}
	
	//constructor
	
	public function Sender($host,$port,$username,$password,$sender,$message,$mobile,$msgtype,$dlr){
		$this->host = $host;
		$this->port = $port;
		$this->strUserName = $username;
		$this->strPassword = $password;
		$this->strSender = $sender;
		$this->strMessage = $message; //URL encode message
		$this->strMobile = $mobile;
		$this->strMessageType = $msgtype;
		$this->strDlr = $dlr;
	}
	
	public function Submit(){
		if($this->strMessageType=="2" || $this->strMessageType=="6"){
			//call the functio of string to HEX.
			$this->strMessage = $this->sms_unicode($this->strMessage);
			try{
				//smpp http Url to send sms
				
				$live_url = "http://".$this->host.":".$this->port."/bulksms/bulksms?username=".$this->strUserName."&password=".$this->strPassword."&type=".$this->strMessageType."&dlr=".$this->strDlr."&destination=".$this->strMobile."&source=".$this->strSender."&message=".$this->strMessage."";
				$parse_url = file($live_url);
				echo $parse_url[0];
			}catch(Exception $e){
				echo 'Message:'.$e->getMessage();
			}
		}
		else{
			$this->strMessage = urlencode($this->strMessage);
			try{
				//smpp http Url to send sms
				
				$live_url = "http://".$this->host.":".$this->port."/bulksms/bulksms?username=".$this->strUserName."&password=".$this->strPassword."&type=".$this->strMessageType."&dlr=".$this->strDlr."&destination=".$this->strMobile."&source=".$this->strSender."&message=".$this->strMessage."";
				$parse_url = file($live_url);
				echo $parse_url[0];
			}
			catch(Exception $e){
				echo 'Message:'.$e->getMessage();
			}
		}
	}
				
	
}