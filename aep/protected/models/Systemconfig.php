<?php

/**
 * This is the model class for table "systemconfig".
 *
 * The followings are the available columns in table 'systemconfig':
 * @property integer $id
 * @property string $parameter
 * @property string $value
 * @property string $name
 */
class Systemconfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'systemconfig';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parameter, value, name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parameter, value, name', 'safe', 'on'=>'search'),
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
			'parameter' => 'Parameter',
			'value' => 'Value',
			'name' => 'Name',
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
		$criteria->compare('parameter',$this->parameter,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Systemconfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public function callurl($url,$data,$method)
	{
		$ch = curl_init();

		$remote_url = $this->get_valueforparameter('server_url');

		$final_url = $remote_url.$url;

		//echo '<hr>'.$final_url;
		//echo '<hr>'.$data;
		curl_setopt($ch, CURLOPT_URL, $final_url);

		curl_setopt($ch, CURLOPT_POST, 1);
		if ($method==='POST')
			curl_setopt($ch, CURLOPT_POST, 1);
		else
			curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close($ch);

		return $server_output;

	}//end of 	public function callurl()


    public function callurlforsecuredata($engg_email,$url,$data,$method)
    {

        $e=$engg_email;
        $user=User::model()->notsafe()->findByAttributes(array('email'=>$engg_email));
        $p=$user->password;
        $data="engineer_email=".$e."&pwd=".$p."&data=".$data;
        //echo $data;
        return $this->callurl($url,$data,$method);

    }////    public function callurlforsecuredata()


	public function verifyengg($e, $p)
	{
		$url = "index.php?r=authentication/authentication";
				
		$data="email=".$e."&pwd=".$p;
		$method='POST';
		
		
		
		$result=$this->callurl($url,$data,$method);
		
		$json=json_decode($result);
		
		if ($json[0]->status=="OK")
			return true;
		else
			return false;
		
	}////end of public function verifyengg()
	
	public function get_valueforparameter($param)
	{
		$model=Systemconfig::model()->findByAttributes(array('parameter' => $param));	
		
		return $model->value;
	}///end of 	public function get_apikey()




}//end of class
