<?php

/**
 * This is the model class for table "survey_response".
 *
 * The followings are the available columns in table 'survey_response':
 * 
 *  integer $id
 * 
 *  integer $survey_ID
 * 
 *  integer $survey_question_ID
 * 
 *  integer $survey_answer_ID
 * 
 *  string $choice_letter
 * 
 *  string $survey_response_time
 * 
 *  string $hash
 * 
 *  string $text
 *
 * The followings are the available model relations:
 * 
 *  Survey $survey
 * 
 *  SurveyQuestion $surveyQuestion
 * 
 *  SurveyAnswer $surveyAnswer
 */
class SurveyResponse extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'survey_response';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('survey_answer_ID', 'required', 'on'=>'save'),
			array('text', 'required', 'on'=>'template','message'=>'All reponses are required.'),
			array('survey_answer_ID', 'numerical', 'integerOnly'=>true),
			//array('choice_letter', 'length', 'max'=>5),
                  
			array('hash', 'length', 'max'=>45),
			array('survey_response_time, text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, survey_answer_ID, survey_response_time, hash, text', 'safe', 'on'=>'search'),
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
			'answer' => array(self::BELONGS_TO, 'SurveyAnswer', 'survey_answer_ID','alias'=>'response_answer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'survey_answer_ID' => 'Survey Answer',
			'survey_response_time' => 'Survey Response Time',
			'hash' => 'Survey Response Responder Hash',
			'text' => 'Your Response:',
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
		$criteria->compare('survey_answer_ID',$this->survey_answer_ID);
		$criteria->compare('survey_response_time',$this->survey_response_time,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurveyResponse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
