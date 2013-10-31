<?php

class QuestionController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($survey_id)
	{
		$model=new SurveyQuestion();
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SurveyQuestion']))
		{
			$model->attributes=$_POST['SurveyQuestion'];
                        $model->survey_ID = $survey_id;
                        $model->order_number = count(SurveyQuestion::model()->findAllByAttributes(array('survey_ID'=>$survey_id)));
			if($model->validate() && $model->save())
				$this->redirect(array('survey/update/' . $model->survey_ID));
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
		
        $answer_dataProvider=new CActiveDataProvider('SurveyAnswer');
		$answer_criteria = new CDbCriteria(array(
			'condition'=>'survey_question_ID = ' . $model->id,
			'order'=>'order_number'
		));
		$answer_dataProvider->setCriteria($answer_criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SurveyQuestion']))
		{
			$model->attributes=$_POST['SurveyQuestion'];
			if($model->save()){
				$answers=SurveyAnswer::model()->findAllByAttributes(array('survey_question_ID'=>$id));
				if($answers){
					foreach ($answers as $idx => $answer) {
						$answer->setAttribute('text',$_POST['SurveyAnswer'][$answer->id]['text']);
						$answer->setAttribute('order_number',$_POST['SurveyAnswer'][$answer->id]['order_number']);
						$answer->setAttribute('survey_answer_choice_letter',1);
						$answer->save();
					}
				}
				$this->redirect(array('survey/update/' . $model->survey_ID));
			}
		}

		$this->render('update',array(
			'model'=>$model, 'answer_dataProvider'=>$answer_dataProvider,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
                $model->delete();

                $this->redirect(array('survey/update/' . $model->survey_ID));
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SurveyQuestion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SurveyQuestion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SurveyQuestion']))
			$model->attributes=$_GET['SurveyQuestion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SurveyQuestion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SurveyQuestion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SurveyQuestion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='survey-question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
