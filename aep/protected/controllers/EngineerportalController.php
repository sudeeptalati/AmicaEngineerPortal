<?php

class EngineerportalController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	} //end of index
	
	public function actionGetdatafromserver()
	{
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
		//echo($server_output);
		json_decode($server_output);
		echo $server_output;
	}
	
}