<?php

class AuthenticationController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}//end of actionIndex
	
	
	public function actionVerifyengg()
	{
		//echo '<h1>i m caled</h1>';
		$email='sweetpullo@gmail.com';
		$pwd='c9ebf569947258fc5263bb8d0b00192a988e99280104d5298e80d1b320deaeba';
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,"http://localhost/purva/server/gomobile/index.php?r=authentication/authentication");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"email=sweetpullo@gmail.com&pwd=c9ebf569947258fc5263bb8d0b00192a988e99280104d5298e80d1b320deaeba");
		

		// in real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS, 
		//          http_build_query(array('postvar1' => 'value1')));

		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);
		

		curl_close ($ch);
		echo($server_output);
		
		
		
		////Step 1: we will send engg id & pass word to go mobile server
		
		///you need to send engineer email and pwd to below url 
		
		///http://localhost/purva/server/gomobile/index.php?r=authentication/authentication
		
	}///	public function verifyengg()

	
	
	
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}