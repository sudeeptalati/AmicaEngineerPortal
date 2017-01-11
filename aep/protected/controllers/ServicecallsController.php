<?php

class ServicecallsController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
        );

    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render( 'view', array(
            'model' => $this->loadModel( $id ),
        ) );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Servicecalls the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Servicecalls::model()->findByPk( $id );
        if ($model === null)
            throw new CHttpException( 404, 'The requested page does not exist.' );
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Servicecalls;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Servicecalls'])) {
            $model->attributes = $_POST['Servicecalls'];
            if ($model->save())
                $this->redirect( array('view', 'id' => $model->id) );
        }

        $this->render( 'create', array(
            'model' => $model,
        ) );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel( $id );

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Servicecalls'])) {
            $model->attributes = $_POST['Servicecalls'];
            if ($model->save())
                $this->redirect( array('view', 'id' => $model->id) );
        }

        $this->render( 'update', array(
            'model' => $model,
        ) );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel( $id )->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect( isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin') );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider( 'Servicecalls' );
        $this->render( 'index', array(
            'dataProvider' => $dataProvider,
        ) );
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Servicecalls( 'search' );
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Servicecalls']))
            $model->attributes = $_GET['Servicecalls'];

        $this->render( 'admin', array(
            'model' => $model,
        ) );
    }

	public function actionMycalls()
    {

        $model = new Servicecalls( 'myservicecallsearch' );

        $data = '';
        $url = "index.php?r=server/senddatatoportal";
        $method = 'POST';
        
        $user=User::model()->findByPk(Yii::app()->user->id);
        
   		$engg_email= $user->email;
        
        
        
        $result = Systemconfig::model()->callurlforsecuredata($engg_email, $url, $data, $method );
        
        $model->savemyservicecalldata( $result );


        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Servicecalls']))
            $model->attributes = $_GET['Servicecalls'];

        $this->render( 'mycalls', array(
            'model' => $model,
        ) );
        ////Insert into table

    }///end of public function actionMycalls()
    

	public function actionGetdataforengineerdesktop()
	{
	
		$json_array=array('data'=>'', 'status'=>'BAD_REQUEST', 'status_message'=>'This is bad request');
	
	
		 
	 
		$email="";
		$pwd="";
		
		if(isset($_POST['email']))
			$email=$_POST['email'];
			
		if(isset($_POST['pwd']))
			$pwd=$_POST['pwd'];
	
		$verify_engg=Systemconfig::model()->verifyengg($email,$pwd);
		
		 
		if ($verify_engg)
		{
			$json_array['status']='LOGIN_OK';
			$json_array['status_message']='Successful Login.';
			
			$data="engineer_email=".$email."&pwd=".$pwd;
        	$url = "index.php?r=server/senddatatoportal";
        	$method = 'POST';
        	$result = Systemconfig::model()->callurl( $url, $data, $method );
        	$json_array['data']= $result;
	
			$model = new Servicecalls( 'myservicecallsearch' );

	        $model->savemyservicecalldata( $result );

				
		}///end of if ($verify_engg)
		else
		{
			$json_array['status']='INVALID_LOGIN';
			$json_array['status_message']='Could not authenticate. Please check login details or contact support.';
		}
		 
		echo json_encode($json_array);
		
		//echo $result;
	}///end of public function actionGetdataforengineerdesktop()
	


    public function actionViewmyservicecall($id)
    {
        $model = $this->loadModel( $id );
        ///$this->performAjaxValidation($model);
        $system_message='';

        if ($model->engineer_user_id === Yii::app()->user->id) {

            $workcarriedoutmodel = new Workcarriedout( 'update' );
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'workcarriedout-form') {
                echo CActiveForm::validate( $workcarriedoutmodel );
                Yii::app()->end();
            }


            if (isset($_POST['Workcarriedout'])) {
                $workcarriedoutmodel->attributes = $_POST['Workcarriedout'];

                $data_type='servicecall_data';

                if ($workcarriedoutmodel->validate()) {

                    // form inputs are valid, do something here
                    $wco_array = array();
                    $wco_array['product_serial_number_available'] = $workcarriedoutmodel->product_serial_number_available;
                    $wco_array['product_serial_number_unavailable_reason'] = $workcarriedoutmodel->product_serial_number_unavailable_reason;
                    $wco_array['product_serial_number'] = $workcarriedoutmodel->product_serial_number;

                    $workcarriedoutmodel->product_plating_image=CUploadedFile::getInstance($workcarriedoutmodel,'product_plating_image');
                    if ($this->checkiffileuploaded($workcarriedoutmodel->product_plating_image)) {

                        $workcarriedoutmodel->product_plating_image = CUploadedFile::getInstance( $workcarriedoutmodel, 'product_plating_image' );

                        $filepathinyii='images/engg_upoaded_images/'.$model->service_reference_number.'_product_plating';


                        if ($workcarriedoutmodel->product_plating_image->saveAs( $filepathinyii )) {
                            $system_message .= '<div class="flash-success">Image successfully Uploaded</div>';
                            $workcarriedoutmodel->product_plating_image_url=$filepathinyii;

                            //echo '<br>Uploaded at location:'.Yii::app()->request->getBaseUrl(true).'/'.$workcarriedoutmodel->product_plating_image_url;
                        } else {
                           //$system_message.= 'Cannot save Image.'.var_dump( $workcarriedoutmodel->getErrors() );
                           $system_message .= '<div class="flash-error">Cannot save Image. Please contact support</div>';
                        }
                     }else {    ///$system_message .= '<div class="flash-error">NO IMAGE IS UPLOADEDt</div>';
                    }

                    //echo "<h2>IMAGE URL: ".$workcarriedoutmodel->product_plating_image_url."</h2>";

                    $wco_array['product_plating_image_url']=$workcarriedoutmodel->product_plating_image_url;

                    $wco_array['work_done'] = $workcarriedoutmodel->work_done;
                    $wco_array['first_visit_date'] = $workcarriedoutmodel->first_visit_date;
                    $wco_array['job_completion_date'] = $workcarriedoutmodel->job_completion_date;
                    $wco_array['submission_date'] = date('d-M-Y H:i:s');

                    $wco_array['spares_used'] = $workcarriedoutmodel->spares_used;
                    $wco_array['spares_array'] = json_decode($workcarriedoutmodel->spares_array,true);

                    $wco_json = json_encode( $wco_array );

                    //echo json_encode( $wco_array );
                    $model->data_sent = $wco_json;

                    $workcarriedoutmodel->chat_message = trim( $workcarriedoutmodel->chat_message );
                    if ($workcarriedoutmodel->chat_message != '') {
                        $chat_array = array();
                        $chat_array['date'] = date( 'l jS \of F Y h:i:s A' );
                        $chat_array['person'] = 'me';
                        $chat_array['message'] = $workcarriedoutmodel->chat_message;
                        $fullchat = $model->communications;
                        $full_chat_array = json_decode( $fullchat, true );
                        array_push( $full_chat_array['chats'], $chat_array );
                        $model->communications = json_encode( $full_chat_array );
                    }

                    $model->jobstatus_id = '35';///it means job is submitted

                    if ($model->save()) {

                         $system_message.= '<div class="flash-success">Data successfully Saved</div>';
						
						 $system_message.= $model->senddatatoserver($data_type);

                    } else
                  	{      ///$system_message.= var_dump( $model->getErrors() );
                        $system_message.='<div class="flash-error">Data cannot be successfully Saved</div>';
					}
                  
                }
            }

            // echo '<h2>Genuine User</h2>';

            $this->render( 'viewmyservicecall', array(
                'model' => $model, 'workcarriedoutmodel' => $workcarriedoutmodel, 'system_message'=>$system_message
            ) );


        } else {
            $this->redirect( 'index.php?r=site/logout' );
        }
    }///end of public function actionMycalls()

    public function actionUpdatemyservicecall()
    {
        $model = new Workcarriedout( 'update' );

        // uncomment the following code to enable ajax-based validation

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workcarriedout-updatemyservicecall-form') {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }


        if (isset($_POST['Workcarriedout'])) {
            $model->attributes = $_POST['Workcarriedout'];
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render( 'updatemyservicecall', array('model' => $model) );
    }///end of public function viewmyservicecall()


    public function actionSendmessagetoamica()
    { 

		
    	  
      	$json_array=array();
		$json_array['status']='BAD_REQUEST'; 
        $json_array['status_message']= 'I am called'; 
        
        
 
        if(isset($_POST['service_reference_number']))
        {
	        $json_array['status']='OK'; 
    	    $json_array['status_message']= $_POST['chat_msg'];
    	  
            $service_reference_number=$_POST['service_reference_number'];
            $data_type='chat_message';

            $chat_msg=$_POST['chat_msg'];


			
	        $id= Servicecalls::model()->getserviceidbyservicerefrencenumber($service_reference_number);
  				
  	 	 	$json_array['status_message'].= 'service_reference_number'.$service_reference_number; 
  				
  			 
  			if ($id)
  			{
	         	$json_array['status']='S_OK'; 
  			    $model=$this->loadModel($id);
					
					
				echo $model->communications;
				
				
				if ($model)
				{
					
				
				  $chat_array = array();
				  $chat_array['date'] = date( 'l jS \of F Y h:i:s A' );
				  $chat_array['person'] = 'me';
				  $chat_array['message'] = $chat_msg;
				  $fullchat = $model->communications;
				  $full_chat_array = json_decode( $fullchat, true );
				  array_push( $full_chat_array['chats'], $chat_array );
				  $model->communications = json_encode( $full_chat_array );
				
					
				  $model->jobstatus_id = '37';///it means message is sent to Amica
					 
				  if ($model->save()) {
				  		
					$json_array['status_message'] .= '<div class="flash-success">Data successfully Saved</div>';
					$json_array['status_message'] .=$model->senddatatoserver($data_type);
				  	///01563 827070	
				  } else
				  	{
	    	            $system_message.= var_dump( $model->getErrors() );
    	    	        $json_array['status_message'].='<div class="flash-error">Data cannot be successfully Saved</div>';
					}////end of   } else
					
				  
				}////end of if ($model)
				
				
  			}////end of if ($id)

	        else
	        {
	         	$json_array['status']='INVALID_REF_NO'; 
    	  		$json_array['status_message'].= "We have got an invalid ref no.";
	        }
	
  		 
           


        }//end of if(isset($_POST['servicecalls_id'])
        else
        {
         	$json_array['status_message'].="<br>CANNOR FOND SERCINCE CID";
         	 
        }
        	
         

        echo json_encode($json_array);

    }//end of actionSendmessagetoamica()



	public function actionSendstatusupdatetoamica()
	{	
	 	$json_array=array();
		$json_array['status']='BAD_REQUEST';
		$json_array['status_message']='This is bad request';


		$email="";
		$pwd="";
		
		if(isset($_POST['email']))
			$email=$_POST['email'];
			
		if(isset($_POST['pwd']))
			$pwd=$_POST['pwd'];
	
		$verify_engg=Systemconfig::model()->verifyengg($email,$pwd);
		 
		$json_array['status_message'].="<br> verifyengg".$verify_engg;
		 
		if ($verify_engg)
		{
		
			$json_array['status']='LOGIN_OK';
			$json_array['status_message']='You have been successfully logged in.';
		
		
			$service_ref_no= $_POST['remote_ref_no'];
			$status_log= $_POST['status_log'];
			$api_key= $_POST['api_key'];
			 
			 
			 
			$service_id=Servicecalls::model()->getserviceidbyservicerefrencenumber($service_ref_no);
			
			$json_array['status_message'].="<br> service_id".$service_id;
		 
			
			if($service_id);
			{
			
					
				$json_array['status']='SERVICECALL_OK';
				$json_array['status_message']='Service call is found.';
		

				$model=$this->loadModel($service_id);
				$model->status_log=$status_log;
			
			
				if ($model->save())
				{
			
			
				$data_type='status_log';
				//////send to Razzmatazz Server
				
				$return_data_array = array();

       			$return_data_array['type'] = $data_type;///is it a message or  servicecall_data
			    $return_data_array['engineer_email'] = $email;
		        $return_data_array['service_reference_number'] = $model->service_reference_number;
		        $return_data_array['gomobile_account_id'] = $api_key;
        		$return_data_array['sent_data'] = array('data_sent' => $model->data_sent, 'communications' => $model->communications , 'status_log' => $model->status_log);
 		
       		 
      
     
       
     		   $data_to_be_sent_string = json_encode(array('data' => $return_data_array));

		
        		$url = "index.php?r=server/getdatafromportal";
        		
        		$method = 'POST';
	
				$data_to_be_sent_string=urlencode($data_to_be_sent_string);
	
	            $data="engineer_email=".$email."&pwd=".$pwd."&data=".$data_to_be_sent_string;
         
				
				$result = Systemconfig::model()->callurl( $url, $data, $method );
				
	 			$json_array['status_message'].=  "Sending result-".$result;
				
				}/////end of if ($model->save())
			}///end of if($service_id);
		}////end of if ($verify_engg)
		
		
		echo json_encode($json_array);
		 
	}////end of public function actionSendstatusupdatetoamica()
	


	public function actionSendclaimtoviaapi()
	{
	 	$json_array=array();
		$json_array['status']='BAD_REQUEST';
		$json_array['status_message']='This is bad request';

		$system_message="";
		$email="";
		$pwd="";
		
		if(isset($_POST['email']))
			$email=$_POST['email'];
			
		if(isset($_POST['pwd']))
			$pwd=$_POST['pwd'];
	
		$verify_engg=Systemconfig::model()->verifyengg($email,$pwd);
			 
		if ($verify_engg)
		{
			$json_array['status']='LOGIN_OK';
			$json_array['status_message']='Login Successful';
		
			$json_array['recieved_data']=$_POST['data_sent'];
		  
			$service_ref_no=$_POST['remote_ref_no'];
		  
			$service_id=Servicecalls::model()->getserviceidbyservicerefrencenumber($service_ref_no);
		
			$model = $this->loadModel( $service_id );
	 	
			$recieved_data_json_array=json_decode($_POST['data_sent']);
			
			
			$data_to_be_sent=$recieved_data_json_array->data->sent_data->data_sent;
			$data_communications=$recieved_data_json_array->data->sent_data->communications;
			$data_status_log=$recieved_data_json_array->data->sent_data->status_log; 
		    
		    $data_type=$recieved_data_json_array->data->type; 
		    
		    
		   
		    $model->data_sent= $data_to_be_sent;
		    $model->communications= $data_communications;
		    $model->status_log= $data_status_log;

		    
		   if ($model->save())
		   {
//               $json_array['local_status']= '<div class="flash-success">Data successfully Saved</div>';
               $json_array['local_status']= 'Data successfully Saved';
               $json_array['razz_server_status']= $model->senddatatoserver($data_type);
		   } else
		   {
		   		///$system_message.= var_dump( $model->getErrors() );
               $json_array['local_status']= 'Data successfully Saved';
               //$system_message.='<div class="flash-error">Data cannot be successfully Saved</div>';
           }
            

		 
		}///end of 	if ($verify_engg)

		return $json_array;

	}///end of public function actionSendclaimtoviaapi()
	


	
	
	
	
	
	
	
	
	
	

        /**
     * Performs the AJAX validation.
     * @param Servicecalls $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'servicecalls-form') {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
    }////ctionUpdatemyservicecall()

    protected function checkiffileuploaded($file)
    {
        if ((is_object( $file ) && get_class( $file ) === 'CUploadedFile'))
            return true;
        else
            return false;

    }///end of protected checkiffileuploaded()


////********************************///
////********************************///
////********************************///


	public function actionPostdatatorazzserverviaportal()
	{
	
		$json_array=array();
		$json_array['status']='BAD_REQUEST';
		$json_array['status_message']='This is bad request';

		$system_message="";
		$email="";
		$pwd="";
		
		if(isset($_POST['email']))
			$email=$_POST['email'];
			
		if(isset($_POST['pwd']))
			$pwd=$_POST['pwd'];


	
		$verify_engg=Systemconfig::model()->verifyengg($email,$pwd);



    if ($verify_engg)
    {
        $post_data=$_POST['json_post_data'];
        $post_data_json=json_decode($post_data);
        $json_array['post_data_json']=$post_data_json;

        ////	SAMPLE JSON DATA ON SERVER
        ////
        ////     {"data_type":"servicecall_data","engineer_email":"sudeeptalati@talatitools.co.in","service_reference_number":"136615","api_key":"TESTINGAMICA","sent_data":{"data_sent":{"product_serial_number_available":"0","product_serial_number_unavailable_reason":"adsadasda","product_serial_number":"00000000000000","product_plating_image_url":"","work_done":"This si sa test work done","first_visit_date":"07-Dec-2016","job_completion_date":"22-Dec-2016","submission_date":"08-Dec-2016 09:58:21","spares_used":null,"spares_array":{"spares":[{"part_number_or_name":"Ball bearing 1020334","qty":"1"},{"part_number_or_name":"Grease filter ft 50 1006929","qty":"1"}]}},"communications":{"chats":[{"date":"Tuesday 6th of December 2016 09:44:51 AM","person":"AMICA","message":"Please see details attached"},{"date":"Tuesday 6th of December 2016 10:36:22 AM","person":"me","message":"OKthis is a test one"},{"date":"Tuesday 6th of December 2016 11:06:59 AM","person":"me","message":"OKThats it"},{"date":"Tuesday 6th of December 2016 11:08:05 AM","person":"AMICA","message":"this is is the log at 11 07"},{"date":"Tuesday 6th of December 2016 11:08:26 AM","person":"me","message":"Ohwow"},{"date":"Tuesday 6th of December 2016 11:08:05 AM","person":"AMICA","message":"this is is the log at 11 07"},{"date":"Tuesday 6th of December 2016 11:10:00 AM","person":"AMICA","message":"6 dec 1109"},{"date":"Tuesday 6th of December 2016 11:10:45 AM","person":"me","message":"thanksrecieved at 11010"},{"date":"Tuesday 6th of December 2016 11:40:49 AM","person":"me","message":"Justchill"},{"date":"Tuesday 6th of December 2016 11:08:05 AM","person":"AMICA","message":"this is is the log at 11 07"},{"date":"Tuesday 6th of December 2016 11:10:00 AM","person":"AMICA","message":"6 dec 1109"},{"date":"Tuesday 6th of December 2016 11:08:05 AM","person":"AMICA","message":"this is is the log at 11 07"}]},"status_log":[{"time":"06-Dec-2016 11:11 AM","jobstatus":"Quoted to repair - awaiting result","engineer":"-Not Assigned, -Not Assigned","user":"admin","comments":""},{"time":"06-Dec-2016 11:52 AM","jobstatus":"Booked","engineer":"-Not Assigned, -Not Assigned","user":"admin","comments":""},{"time":"06-Dec-2016 11:53 AM","jobstatus":"Booked","engineer":"-Not Assigned, -Not Assigned","user":"admin","comments":""},{"time":"06-Dec-2016 11:54 AM","jobstatus":"Referred back to Manufacturer","engineer":"-Not Assigned, -Not Assigned","user":"admin","comments":""},{"time":"07-Dec-2016 09:49 AM","jobstatus":"Booked","engineer":"Careys, Stephen Kerry","user":"admin","comments":""},{"time":"07-Dec-2016 09:49 AM","jobstatus":"Booked","engineer":"Careys, Lawrence Carey ","user":"admin","comments":"Engineer Visit Date: 29-Dec-2016"},{"time":"07-Dec-2016 09:55 AM","jobstatus":"Booked","engineer":"Careys, Lawrence Carey ","user":"admin","comments":""},{"time":"07-Dec-2016 09:56 AM","jobstatus":"Booked","engineer":"Careys, Lawrence Carey ","user":"admin","comments":"Engineer Visit Date: 08-Dec-2016"},{"time":"07-Dec-2016 03:40 PM","jobstatus":"Pending More Info","engineer":"Careys, Lawrence Carey ","user":"admin","comments":""},{"time":"07-Dec-2016 03:45 PM","jobstatus":"Message Delivered ","engineer":"Careys, Lawrence Carey ","user":"admin","comments":""}]}}
        ////

        $json_array['data_transport_to_razz_server']=Servicecalls::model()->process_json_data_recived_from_rapport_engineer_desktop($post_data_json);


    }////end of if ($verify_engg)

		
		    echo json_encode($json_array);
		//echo json_encode($post_data_json);
		 
	}////end of public function actionPostdatatorazzserverviaportal()
	
	





}///end of class
