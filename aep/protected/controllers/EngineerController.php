<?php

class EngineerController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{

        /*
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
        */
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);

	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Engineer the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Engineer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Engineer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engineer']))
		{
			$model->attributes=$_POST['Engineer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Engineer']))
		{
			$model->attributes=$_POST['Engineer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Engineer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Engineer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Engineer']))
			$model->attributes=$_GET['Engineer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
     *login form for engineers
     */
    public function actionLogin()
    {
        $model = new Engineer;

        $message = "";
        if (isset($_POST['Engineer'])) {
            $model->attributes = $_POST['Engineer'];

            ///Logic to verify engineer, If it is true, go to admin screen
            if ($model->verify($model->email, $model->password)) {
                $loggedinenggmodel = Engineer::model()->findByAttributes(array('email' => $model->email));
                if (isset($loggedinenggmodel->id)) {
                    $message = "Login successful";
                    $this->redirect(array('engineer/showmyjobs', 'id' => $loggedinenggmodel->id));
                } else
                    $message = "Incorrect Login credentials. If problem persists, please contact support.";

            } else {
                $message = "Incorrect Login credentials. If problem persists, please contact support.";
            }


        }//end of if(isset($_POST['Engineer']))


        $this->render('login', array(
            'model' => $model, 'message' => $message
        ));

    }


    /*
     *Custom functions
     */

    public function actionShowmyjobs($id)
    {

        echo '<h1>Show my jobs</h1>' . $id;
    }///end of 	protected function actionEngineerlogin()

    /**
     * Performs the AJAX validation.
     * @param Engineer $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'engineer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


}///end of cEngineerController class
