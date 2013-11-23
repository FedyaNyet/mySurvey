<div class="stripe">
	<div class="page-name">
		<h1>Reports</h1>
		<p class="intro-text">Choose data source to view statistical report.</p>
    	
    	<!-- Data source select form prototype, data should be retrieved from MySQL 
    	     This form submits selected value to the current page -->
     	<form method="POST" action=""> 
		  <select name="selectReport" style="width:200px" onChange="this.form.submit()">
		      <?php if ($surveys==null){
		      	$currentSurvey=null;	
		      ?>
		      <option> no surveys</option>
		      <?php }
		      	else{
 		       foreach ($surveys as $key => $survey) { ?>
 		          <option value=<?php echo $survey->id; ?> <?php 
 		          if(isset($_POST['selectReport'])&&($_POST['selectReport'] == $survey->id)||$key==0){
 		          	echo  " selected='selected'";
 		          	$currentSurvey=$survey;
 		          }?>>
 		             <?php echo $survey->title;?>
 		          </option>
    	      <?php }
 		       }?>
	      
	      </select>  
	    </form>
	</div>
</div>
<div class="content-width">
	</br>
	<?php
        
    	//output report
    	if($currentSurvey!=null){
    	$questions_criteria = new CDbCriteria(array(
                        'condition'=>'survey_ID = ' . $currentSurvey->id,
                        'order'=>'order_number'
                         ));
        $questions = SurveyQuestion::model()->findAll($questions_criteria);
    	foreach ($questions as $question){
    		echo '<h1>'.$question->text.'</h1></br>';
    		//show piechart for all non-short answer questions
    		if($question->type!=0){
	    		$chartArray=array();
				$answerCount=0;
				
	    		foreach ($question->answers as $answer){
						$answerCount+=count($answer->responses);
	    				$chartArray[]=array($answer->text,count($answer->responses));
	    		}
				
				if($answerCount==0){
					echo '<h2>Currently there are no responses</h2></br>';
				} else {
	    		$this->Widget('ext.highcharts.HighchartsWidget', array(
	    		            //'scripts' => array('highcharts-more', 'modules/exporting', 'themes/grid'),
	    		            'options' => array(
	    		                    'gradient' => array('enabled'=> true),
	    		                    'credits' => array('enabled' => false),
	    		                    'exporting' => array('enabled' => true),
	    		                    'chart' => array(
	    		                            'plotBackgroundColor' => null,
	    		                            'plotBorderWidth' => null,
	    		                            'plotShadow' => true,
	    		                    ),
	    		                    'legend' => array( 'enabled' => false),
	    		                    'title' => array( 'text' => 'Survey Pie Chart'),
	    		                    'tooltip' => array(
	    		                            'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
	    		                            'percentageDecimals' => 1,
	    		                    ),
	    		                    'plotOptions' => array(
	    		                            'pie' => array(
	    		                                    'allowPointSelect' => true,
	    		                                    'cursor' => 'pointer',
	    		                                    'dataLabels' => array(
	    		                                            'enabled' => true,
	    		                                            'color' => '#000000',
	    		                                            'connectorColor' => '#000000',
	    		                                            'formatter' => "js:function(){return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';}",
	    		                                    ),
	    		                            )
	    		                    ),
	    		                    'series' => array(
	    		                            array(
	    		                                    'type' => 'pie',
	    		                                    'name' => '% d\'utilisation',
	    		                                    'data' => $chartArray,
	    		                            )
	    		                    ),
	    		            )
	    		    ));
	    	}}
    	    //short answers
    		else{
    			echo 'short answer report goes here!!';
    		}
    	}
    	}
    	//end of output report
	?>
	
</div>