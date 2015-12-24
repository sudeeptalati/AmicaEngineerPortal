<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	const ERROR_SERVER_ERROR=6;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{


		if (strpos($this->username,"@")) {
			$user=User::model()->notsafe()->findByAttributes(array('email'=>$this->username));
		} else {
			$user=User::model()->notsafe()->findByAttributes(array('username'=>$this->username));
		}
		if($user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		else if(Yii::app()->getModule('user')->encrypting($this->password)!==$user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;

		else if($user->status==-1)
			$this->errorCode=self::ERROR_STATUS_BAN;
			/*
		else if($this->verifyserverlogin()==false)
			$this->errorCode=self::ERROR_SERVER_ERROR;
*/

		else {
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
    
    /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->_id;
	}


	private function verifyserverlogin()
	{

		$ch = curl_init();
		$sc = Systemconfig::model()->findByAttributes(array('parameter' => 'server_url'));
		$verifyurl = $sc->value;
		$verifyurl = $verifyurl . "index.php?r=authentication/authentication";

		//echo $verifyurl;
		curl_setopt($ch, CURLOPT_URL, $verifyurl);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS,"email=sweetpullo@gmail.com&pwd=c9ebf569947258fc5263bb8d0b00192a988e99280104d5298e80d1b320deaeba");
		curl_setopt($ch, CURLOPT_POSTFIELDS, "email=" . $this->username. "&pwd=" . hash('sha256', $this->password));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close($ch);
		//echo '<hr> Server says: ' . $server_output;
		$j = json_decode($server_output);
		if ($j[0]->{"status"} === 'OK')
			return true;
		else
			return false;

	}
}