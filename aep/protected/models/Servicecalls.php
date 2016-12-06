<?php

/**
 * This is the model class for table "servicecalls".
 *
 * The followings are the available columns in table 'servicecalls':
 * @property integer $id
 * @property integer $service_reference_number
 * @property string $engineer_user_id
 * @property string $engineer_email
 * @property string $callcenter_account_id
 * @property string $customer_fullname
 * @property string $customer_address
 * @property string $customer_postcode
 * @property string $communications
 * @property string $data_recieved
 * @property string $data_sent
 * @property integer $jobstatus_id
 * @property integer $created
 * @property integer $modified
 */
class Servicecalls extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'servicecalls';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('service_reference_number, engineer_user_id, engineer_email', 'required'),
            array('service_reference_number, engineer_user_id, jobstatus_id, created, modified', 'numerical', 'integerOnly' => true),
            array('callcenter_account_id, customer_fullname, customer_address, customer_postcode, communications, data_recieved, data_sent, status_log', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, service_reference_number, engineer_user_id, engineer_email, callcenter_account_id, customer_fullname, customer_address, customer_postcode, communications, data_recieved, data_sent, jobstatus_id, created, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jobstatus' => array(self::BELONGS_TO, 'Jobstatus', 'jobstatus_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'service_reference_number' => 'Service Reference Number',
            'engineer_user_id' => 'Engineer User Id',
            'engineer_email' => 'Engineer Email',
            'callcenter_account_id' => 'Account',
            'customer_fullname' => 'Customer Fullname',
            'customer_address' => 'Customer Address',
            'customer_postcode' => 'Customer Postcode',
            'communications' => 'Communications',
            'data_recieved' => 'Data Recieved',
            'data_sent' => 'Data Sent',
            'jobstatus_id' => 'Jobstatus',
            'created' => 'Created',
            'modified' => 'Modified',
            'status_log' => 'Status Log',
            
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('service_reference_number', $this->service_reference_number);
        $criteria->compare('engineer_user_id', $this->engineer_user_id);
        $criteria->compare('engineer_email', $this->engineer_email, true);
        $criteria->compare('callcenter_account_id', $this->callcenter_account_id, true);
        $criteria->compare('customer_fullname', $this->customer_fullname, true);
        $criteria->compare('customer_address', $this->customer_address, true);
        $criteria->compare('customer_postcode', $this->customer_postcode, true);
        $criteria->compare('communications', $this->communications, true);
        $criteria->compare('data_recieved', $this->data_recieved, true);
        $criteria->compare('data_sent', $this->data_sent, true);
        $criteria->compare('jobstatus_id', $this->jobstatus_id);
        $criteria->compare('created', $this->created);
        $criteria->compare('modified', $this->modified);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function savemyservicecalldata($data)
    {
        $j_result = json_decode($data);
        $servicecalls = $j_result->details;

        foreach ($servicecalls as $servicecall) {

            if ($this->ifservicecallexists($servicecall->service_reference_number)) {
                ///update

                //check first if its a message or servicecall_data
                if ($servicecall->type == 'servicecall_data') {
                    $this->updateservicecall($servicecall);
                } else {
                    ////its a message then
                    $this->saveservicechatmessage($servicecall);
                }

            } else {
                ///insert
                $this->insertservicecall($servicecall);
            }

        }////end of foreach

    }

    public function ifservicecallexists($s_r_n)
    {
        $m = Servicecalls::findByAttributes(array('service_reference_number' => $s_r_n));
        if ($m)
            return true;
        else
            return false;
    }//end of	public function savemyservicecalldata($data)

    public function updateservicecall($updateservice)
    {

        $service_id = $this->getserviceidbyservicerefrencenumber($updateservice->service_reference_number);

        $model = Servicecalls::model()->findByPk($service_id);

        $model->engineer_email = $updateservice->engineer_email;
        $model->engineer_user_id = $this->getuseridofengineerbyengineeremail($updateservice->engineer_email);
        $model->callcenter_account_id = $updateservice->gomobile_account_id;
        $model->customer_fullname = $updateservice->customer_fullname;
        $model->customer_address = $updateservice->customer_address;
        $model->customer_postcode = $updateservice->customer_postcode;
        $model->data_recieved = json_encode($updateservice->data);
        $model->jobstatus_id = 2;///for new job

        if ($model->save()) {
            return 'Successfully saved';
        } else {
            return 'Error in saving Please call support';
        }


    }////end of public function ifservicecallexists($service_reference_number)

    public function getserviceidbyservicerefrencenumber($service_reference_number)
    {

        $model = Servicecalls::model()->findByAttributes(array('service_reference_number' => $service_reference_number));
        if ($model)
            return $model->id;
        else
            return null;

    }///edn of 	public function insertservicecall($data)

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Servicecalls the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }//end of public function updateservicecall()

    public function getuseridofengineerbyengineeremail($user_email)
    {

        $user_model = User::model()->findByAttributes(array('email' => $user_email));
        if ($user_model)
            return $user_model->id;
        else
            return null;
    }///end of public function saveservicechatmessage($servicemessage)

    public function saveservicechatmessage($servicemessage)
    {

       $service_id = $this->getserviceidbyservicerefrencenumber($servicemessage->service_reference_number);

       $model = Servicecalls::model()->findByPk($service_id);

       $model->jobstatus_id=$servicemessage->claim_status;

       $chat_array = array();
       $chat_array['date'] = $servicemessage->communications->date;
       $chat_array['person'] = $servicemessage->communications->person;
       $chat_array['message'] = $servicemessage->communications->message;

       $fullchat = $model->communications;
       $full_chat_array = json_decode( $fullchat, true );
       array_push( $full_chat_array['chats'], $chat_array );
       $model->communications = json_encode( $full_chat_array );
       if ($model->save()) {
            return 'Successfully saved';
        } else {
            return 'Error in saving Please call support';
        }

    }///end of public function saveservicechatmessage($servicemessage)


    public function insertservicecall($service)
    {

        $model = new Servicecalls();
        $model->service_reference_number = $service->service_reference_number;
        $model->engineer_email = $service->engineer_email;
        $model->engineer_user_id = $this->getuseridofengineerbyengineeremail($service->engineer_email);
        $model->callcenter_account_id = $service->gomobile_account_id;
        $model->customer_fullname = $service->customer_fullname;
        $model->customer_address = $service->customer_address;
        $model->customer_postcode = $service->customer_postcode;
        $model->data_recieved = json_encode($service->data);
        $model->jobstatus_id = 1;///for new job

        ///communications needs to be initialised here
        //echo json_encode($service->allchatmessage);

        $chatarray['chats'] = array();
        $amica_chat_array = array();
        $amica_chat_array['date'] = $service->allchatmessage->chats->date;
        $amica_chat_array['person'] = $service->allchatmessage->chats->person;
        $amica_chat_array['message'] = $service->allchatmessage->chats->message;
        array_push($chatarray['chats'], $amica_chat_array);


        $model->communications = json_encode($chatarray);
        if ($model->save()) {
            return 'Successfully saved';
        } else {
            return 'Error in saving Please call support';
        }


    }///end of myservicecallsearch

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();

        $this->modified = time();

        return parent::beforeSave();
    }///end of 	public function senddatatoserver()

    public function myservicecallsearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('service_reference_number', $this->service_reference_number);
        $criteria->compare('engineer_user_id', Yii::app()->user->id);
        $criteria->compare('customer_fullname', $this->customer_fullname, true);
        $criteria->compare('customer_address', $this->customer_address, true);
        $criteria->compare('customer_postcode', $this->customer_postcode, true);
        $criteria->compare('communications', $this->communications, true);
        $criteria->compare('data_recieved', $this->data_recieved, true);
        $criteria->compare('data_sent', $this->data_sent, true);
        $criteria->compare('jobstatus_id', $this->jobstatus_id);
        $criteria->compare('created', $this->created);
        $criteria->compare('modified', $this->modified);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'service_reference_number DESC',
            ),
        ));
    }//end of getserviceidbyservicerefrencenumber

    public function senddatatoserver($data_type)
    {
        ////prepare data for sending
		$return_msg='NOTHING';
        $return_data_array = array();

        $return_data_array['type'] = $data_type;///is it a message or  servicecall_data

        $return_data_array['engineer_email'] = $this->engineer_email;
        $return_data_array['service_reference_number'] = $this->service_reference_number;
        $return_data_array['gomobile_account_id'] = Systemconfig::model()->get_valueforparameter('api_key');
         
        $return_data_array['sent_data'] = array('data_sent' => $this->data_sent, 'communications' => $this->communications , 'status_log' => $this->status_log);
		
        $data_to_be_sent_string = json_encode(array('data' => $return_data_array));

        $url = "index.php?r=server/getdatafromportal";
        $method = 'POST';
	 	
		$data_to_be_sent_string=urlencode($data_to_be_sent_string);
		//echo $data_to_be_sent_string;
		
		 
        $result = Systemconfig::model()->callurlforsecuredata( $this->engineer_email, $url, $data_to_be_sent_string, "POST");
		 
		$result_json=json_decode($result);
		
		
	
		if ($result_json->status =='OK')
			$return_msg= '<div class="flash-success">'.$result_json->status_message.'</div>';
		else
			$return_msg= '<div class="flash-error">'.$result_json->status_message.'</div>';
		 					
		  	
		
		return $return_msg;
		
		
        //echo '<h2> RESIUT IS ' . $result . '</h2>';
    }///end of public function getuseridofengineerbyengineeremail($user_email)


	/*This is a dirty data mining of finding payment date*/
    public function findpaymentdate($communicationsdata)
    {
        //echo $communicationsdata;

        ///will be paid in month of June, 2016"},{"date

        $communications_json=json_decode($communicationsdata, true);

        $findme   = 'paid in month of';

        $payment_months=array();
        foreach ($communications_json['chats'] as $c)
        {
            $mystring= $c['message'];
            $pos=strpos($mystring, $findme);
            if ($pos!==false)
            {
                $pos=$pos+16;
                $payment_months[]=substr($mystring, $pos);
            }
        }

        if (count ($payment_months)>0)
            return "<h4>".$payment_months[count($payment_months)-1].'</h4>';///last element of array
        else
            return "";



    }//end of public function findpaymentdate($communicationsdata)



}//end of class model
