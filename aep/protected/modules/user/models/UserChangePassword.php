<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel {
	public $password;
	public $verifyPassword;
	
	public function rules() {
		return array(
			array('password, verifyPassword', 'required'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
		);
	}



	public function remoteupdatepass($user_email, $encrypted_pass)
	{

		//$data='email='.$u->email.'&pwd=THI*****SISMYPASS';
		$data='email='.$user_email.'&pwd='.$encrypted_pass;

		$url="index.php?r=authentication/updatedetails";
		$method='POST';
		$result=Systemconfig::model()->callurl($url,$data,$method);
		$j_result= json_decode($result);

		//echo $j_result[0]->status_message;

		return $j_result[0]->status_message;

	}//end of 	public function remoteupdatepass()

} 