<?php

/**
 * This is the model class for table "survey_creator".
 *
 * The followings are the available columns in table 'survey_creator':
 * 
 *  integer $id
 * 
 *  string $email
 * 
 *  string $password
 * 
 *  string $first_name
 * 
 *  string $last_name
 * 
 *  integer $level
 *
 * The followings are the available model relations:
 * 
 *  Survey[] $surveys
 */
class SurveyCreator extends Model
{
        //used for registration.
        public $password_repeat;
        public $new_password;
        public $new_password_repeat;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'survey_creator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password', 'required'),
                        array('email', 'unique'),
			array('level', 'numerical', 'integerOnly'=>true),
                        array('email','email'),
                        array('password','length','min' => 8,'tooShort'=>'{attribute} is too short ({min} characters min.).'),
			array('email, password, first_name, last_name', 'length', 'max'=>45),
                        //registration scenario validation
                        array('email', 'unique','on'=>'register'), 
                        array('password_repeat', 'compare', 'compareAttribute'=>'password', 'on'=>'register', 'message'=>'Password must be repeated exactly.'),
                        array('password_repeat', 'required', 'on'=>'register'),
                        array('new_password', 'length', 'min' => 8, 'allowEmpty'=> true, 'tooShort'=>'{attribute} is too short ({min} characters min.).'),
                        array('new_password_repeat', 'compare', 'compareAttribute'=>'new_password', 'on'=>'update', 'message'=>'Password must be repeated exactly.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, first_name, last_name, level', 'safe', 'on'=>'search'),
		);
	}
        
        public function beforeSave() {
            parent::beforeSave();
            switch($this->scenario){
                case 'register':
                    $this->password = sha1($this->password);
                    break;
                case 'update':
                	if($this->new_password!=null){
                		$this->password= sha1($this->new_password);
                	}
                	else{
                		$this->password = sha1($this->password);
                	}
                	break;
            }
            return true;
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'surveys' => array(self::HAS_MANY, 'Survey', 'survey_creator_ID','alias'=>'creator_survey'),
		);
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
			'password_repeat' => 'Repeat Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'level' => 'Level',
			'new_password' => 'New Password',
			'new_password_repeat' => 'Repeat New Password',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurveyCreator the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
