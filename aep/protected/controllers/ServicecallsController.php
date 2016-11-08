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
        $result = Systemconfig::model()->callurlforsecuredata( $url, $data, $method );
        //echo $result;

        $model->savemyservicecalldata( $result );


        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Servicecalls']))
            $model->attributes = $_GET['Servicecalls'];

        $this->render( 'mycalls', array(
            'model' => $model,
        ) );
        ////Insert into table

    }

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
                    $wco_array['spares_array'] = $workcarriedoutmodel->spares_array;

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
                        ///$system_message.= var_dump( $model->getErrors() );
                        $system_message.='<div class="flash-error">Data cannot be successfully Saved</div>';

                    //return;
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
        $system_message= 'I am called';

        if(isset($_POST['servicecalls_id']))
        {
            $id=$_POST['servicecalls_id'];
            $data_type='chat_message';


            $chat_msg=$_POST['chat_msg'];

            $model=$this->loadModel($id);

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
                $system_message .= '<div class="flash-success">Data successfully Saved</div>';
                $system_message .=$model->senddatatoserver($data_type);

            } else
                ///$system_message.= var_dump( $model->getErrors() );
                $system_message.='<div class="flash-error">Data cannot be successfully Saved</div>';

        }//end of if(isset($_POST['servicecalls_id'])

        echo $system_message;

    }//end of actionSendmessagetoamica()

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


}
