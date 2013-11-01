<?php
/* @var $this SurveyController */
/* @var $model Survey */
/* @var $questions_dataProvider CActiveDataProvider*/

?>

<h1>Edit Survey:</h1>

<script>
    
	$(function(){

		$(window).on('click',function(e){
			//check if where we clicked has an parent that is active, or has an active class itself.
			var clickedActiveQuestion = $(e.target).closest('.active').length || $(e.target).hasClass('active');
			if(!clickedActiveQuestion){
				$('.active a.edit').trigger('click');
			}
		});
		
		$('#questions').on('click','a.edit',function(e){
			e.stopPropagation();//allows us to catch window click outside event.
			e.preventDefault();//stops the link from following the url
			//this is a hack to bi-pass browser security of immutable type attributes on inputs.
			var newInput = $(this).closest('li').find('input[name*=text]').clone();
			if(!$(this).closest('li').hasClass('active')){
				$('.active a.edit').trigger('click');
				$(this).closest('li').addClass('active');
				$(this).closest('li').find('.text').hide();
				$(this).closest('li').find('input[type=hidden][name*=text]').replaceWith(newInput.attr('type','text'));
                                newInput.focus();
			}else{
				$(this).closest('li').removeClass('active');
				$(this).closest('li').find('input[type=text][name*=text]').replaceWith(newInput.attr('type','hidden'));
				$(this).closest('li').find('.text').html(newInput.val()).show();
			}
		}).on('click','a.delete',function(e){
			e.preventDefault();//stops the link from following the url
			var listItem = $(this).closest('li');
			// delete new_sortables[listItem.data('sort-key')];
			listItem.remove();
		});

		$('.add-sortable').on('click',function(e){
			e.preventDefault();
			e.stopPropagation();
			var target = $(this).data('target');
			var newItem = $(target).find('.template').clone().removeClass('template');
			newItem.find('input').removeAttr('disabled');
			$(target).append(newItem);
                        fix_sortable_input_names(target);
			newItem.find('.edit').trigger('click');
		});


		//DRAGGABLE CONTENT
		$('ul.sortable').sortable({
                        items: '> li',
                        start:function(event, ui){
                            $(ui.item).addClass('dragging');
                        },
                        stop:function(event, ui){      
                            $(ui.item).removeClass('dragging');
                            fix_sortable_input_names($(this).closest('.sortable'));
                            $(ui.item).filter('input:checked').prop('checked', true);
                        }
		});
                
                function fix_sortable_input_names($sortable){
                    $($sortable).find('li').each(function(newIndex,elem){
                        $(elem).find('input').each(function($idx, input){
                            var name = $(input).attr('name');
                            //Ignore this trickery.. it's bad form.
                            var prevIndex = name.split('[')[1].split(']')[0];
                            var newName = name.replace(prevIndex,newIndex);
                            $(input).attr('name',newName);
                        });
                    });
                }
                
	});

</script>

<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'survey-form',
				'focus'=>array($model, 'title'),
				'enableAjaxValidation'=>true,
				'clientOptions'=>array(
					   'validateOnChange'=>true,
					   'validateOnType'=>true,
				)
		)); ?>
			
			<?php echo $form->errorSummary($model); ?>
			<div class="row buttons">
				<?php echo CHtml::submitButton('Save'); ?>
				<?php echo CHtml::link('Cancel', '/survey') ?>
			</div>

			<div class="row">
				<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100, 'class'=>'title')); ?>
				<span class="arrow-left"></span><?php echo $form->error($model,'title',array('successCssClass','success')); ?>
			</div>
			
			<h4>Questions</h4>
			<ul id="questions" class="sortable">
                            <?php echo $this->renderPartial('/question/update',array('model'=>new SurveyQuestion('template'))); ?>
                            <?php foreach($questions as $record) { ?>
                                <?php echo $this->renderPartial('/question/update',array('model'=>$record)); ?>
                            <?php } ?>   
			</ul>

			<div class="row buttons">
				<a class="add-sortable" data-target="#questions" href="#">Add new question'</a>
			</div>

		<?php $this->endWidget(); ?>
			
</div><!-- form -->