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

		$user_email='';
		if (strpos($this->username,"@")) {
			$user_email=$this->username;
			$user=User::model()->notsafe()->findByAttributes(array('email'=>$this->username));
		} else {
			$user = User::model()->notsafe()->findByAttributes(array('username' => $this->username));
			if ($user)
				$user_email = $user->email;
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
		
		
		else if($this->verifyserverlogin($user_email,$user->password)==false)
			$this->errorCode=self::ERROR_SERVER_ERROR;
		

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


	private function verifyserverlogin($e,$p)
	{

		//echo $p;
		$url="index.php?r=authentication/authentication";
		$data="email=".$e."&pwd=".$p;
		$method='POST';

		$result=Systemconfig::model()->callurl($url,$data,$method);
		
		//echo $result;
	 
		$j = json_decode($result);
 	
 		if ($j)
		{
			if ($j[0]->{"status"} === 'OK')
				return true;
			else
				return false;
		}
		else
			return false;	
	}
}