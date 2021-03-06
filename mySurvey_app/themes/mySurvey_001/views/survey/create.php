<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<!--======== CREATE SURVEY ========-->
<div class="stripe">
	<div class="page-name">
		<h1>Create Survey</h1>
		<p class="intro-text instructions"><span>1</span> Enter the title of the survey below. <span class="two">2</span> Use the Survey Editor to add questions.</p>
	</div>
</div>

<div class="content-width">
<div class="form" id="create-survey-form">

    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'survey-form',
            'enableAjaxValidation'=>false,
    )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

            <div class="row">
                    <?php echo $form->labelEx($model,'title'); ?>
                    <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
                    <span class="arrow-left"></span><?php echo $form->error($model,'title'); ?>
            </div>

            <div class="row buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
                    <input type="button" onclick="window.location='<?php echo Yii::app()->request->baseUrl; ?>/survey';" value="Cancel" />
            </div>   

    <?php $this->endWidget(); ?>

</div><!-- form -->
</div>