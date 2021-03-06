<?php
/* @var $this SurveyResponseController */
/* @var $model SurveyResponse */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'survey_answer_ID'); ?>
		<?php echo $form->textField($model,'survey_answer_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'choice_letter'); ?>
		<?php echo $form->textField($model,'choice_letter',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'survey_response_time'); ?>
		<?php echo $form->textField($model,'survey_response_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hash'); ?>
		<?php echo $form->textField($model,'hash',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'text'); ?>
		<?php echo $form->textField($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->