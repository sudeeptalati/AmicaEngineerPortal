<?php

/**
 * This is the model class for table "engineer".
 *
 * The followings are the available columns in table 'engineer':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $active
 * @property string $company
 * @property string $address
 * @property string $town
 * @property string $postcode
 * @property integer $created
 * @property integer $modified
 */
class Engineer extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'engineer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('active, created, modified', 'numerical', 'integerOnly' => true),
            array('email, password, company, address, town, postcode', 'safe'),
            array('email, password, company, address, town, postcode, active', 'required'),

            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, email, password, active, company, address, town, postcode, created, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'active' => 'Active',
            'company' => 'Company',
            'address' => 'Address',
            'town' => 'Town',
            'postcode' => 'Postcode',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('postcode', $this->postcode, true);
        $criteria->compare('created', $this->created);
        $criteria->compare('modified', $this->modified);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Engineer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /*
     *
     * Custom functions
     */

    protected function beforeSave()
    {
        $this->password = hash('sha256', $this->password);
        if ($this->isNewRecord)  // Creating new record
        {
            $this->created = time();
            return true;
        } else {
            $this->modified = time();
            return true;
        }


    }//end of before save


    public function verify($username, $pass)
    {


        $checkenggmodel = Engineer::model()->findByAttributes(array('email' => $username, 'password' => hash('sha256', $pass)));

        ///if local authentication successful, then server authentication
        if (isset($checkenggmodel->id)):

            //echo $checkenggmodel->id;

            $ch = curl_init();
            $sc = Systemconfig::model()->findByAttributes(array('parameter' => 'server_url'));
            $verifyurl = $sc->value;
            $verifyurl = $verifyurl . "index.php?r=authentication/authentication";

            //echo $verifyurl;
            curl_setopt($ch, CURLOPT_URL, $verifyurl);
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS,"email=sweetpullo@gmail.com&pwd=c9ebf569947258fc5263bb8d0b00192a988e99280104d5298e80d1b320deaeba");
            curl_setopt($ch, CURLOPT_POSTFIELDS, "email=" . $username . "&pwd=" . hash('sha256', $pass));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close($ch);
            echo '<hr> Server says: ' . $server_output;
            $j = json_decode($server_output);
            if ($j[0]->{"status"} === 'OK')
                return true;
            else
                return false;

        endif;///// if (isset($checkenggmodel->id)):

        return false;
    }///end of public function verify($username, $password)


}//end of class Engineer
