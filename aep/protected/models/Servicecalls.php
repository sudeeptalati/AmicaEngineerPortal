<?php

/**
 * This is the model class for table "servicecalls".
 *
 * The followings are the available columns in table 'servicecalls':
 * @property integer $id
 * @property integer $service_reference_number
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
			array('service_reference_number, engineer_email', 'required'),
			array('service_reference_number, jobstatus_id, created, modified', 'numerical', 'integerOnly'=>true),
			array('callcenter_account_id, customer_fullname, customer_address, customer_postcode, communications, data_recieved, data_sent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, service_reference_number, engineer_email, callcenter_account_id, customer_fullname, customer_address, customer_postcode, communications, data_recieved, data_sent, jobstatus_id, created, modified', 'safe', 'on'=>'search'),
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
			'engineer_email' => 'Engineer Email',
			'callcenter_account_id' => 'Callcenter Account',
			'customer_fullname' => 'Customer Fullname',
			'customer_address' => 'Customer Address',
			'customer_postcode' => 'Customer Postcode',
			'communications' => 'Communications',
			'data_recieved' => 'Data Recieved',
			'data_sent' => 'Data Sent',
			'jobstatus_id' => 'Jobstatus',
			'created' => 'Created',
			'modified' => 'Modified',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('service_reference_number',$this->service_reference_number);
		$criteria->compare('engineer_email',$this->engineer_email,true);
		$criteria->compare('callcenter_account_id',$this->callcenter_account_id,true);
		$criteria->compare('customer_fullname',$this->customer_fullname,true);
		$criteria->compare('customer_address',$this->customer_address,true);
		$criteria->compare('customer_postcode',$this->customer_postcode,true);
		$criteria->compare('communications',$this->communications,true);
		$criteria->compare('data_recieved',$this->data_recieved,true);
		$criteria->compare('data_sent',$this->data_sent,true);
		$criteria->compare('jobstatus_id',$this->jobstatus_id);
		$criteria->compare('created',$this->created);
		$criteria->compare('modified',$this->modified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Servicecalls the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
