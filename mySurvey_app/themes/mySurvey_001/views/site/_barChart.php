<h3 class="reports-headline">Survey Responses</h3>
<form method="POST" action="" style="display:inline-block;">
    <?php 
    echo CHtml::hiddenField('Survey[id]',$currentSurvey->id);
    echo "<div class='toggle-bar'>";
    echo CHtml::linkButton('View as Bar Charts', array('submit'=>array('/site/reports/type/bar'),'class'=>'toggle bar-charts selected'));
    echo CHtml::linkButton('View as Pie Charts', array('submit'=>array('/site/reports/type/pie'),'class'=>'toggle'));
    echo "</div>";?>
</form>

<?php
foreach ($currentSurvey->questions as $question) {
    
    //show charts for all non-short answer questions
    if ($question->type != 0) {
        
        $chartArray = array();
        $answerArray = array();
        $responseCount = 0;

        foreach ($question->answers as $answer) {
            $chartArray[] = array($answer->text, count($answer->responses));
            $answerArray[] = array($answer->text);
            $responseCount += count($answer->responses);
        }
		echo '<h2>' . $question->text . '</h2>';
        if ($responseCount == 0) {
            echo '<h4>Currently there are no responses</h4></br>';
        } else {
            //bar chart
            $this->Widget('ext.highcharts.HighchartsWidget', array(
                'scripts' => array('highcharts-more', 'modules/exporting', 'themes/grid'),
                'options' => array(
                    'chart' => array('type' => 'bar'),
                    'credits' => array('enabled' => false),
                    'title' => array(''),
                    'xAxis' => array('categories' => $answerArray, 'title' => array('text' => 'Answers')),
                    'yAxis' => array('title' => array('text' => 'Nr. of Responses', 'align' => 'high', 'margin' => 8),
                    'gridLineDashStyle' => 'longdash',
                    'tickInterval' => 1,
                    'min' => 0,
                    'labels' => array('overflow' => 'justify')),
                    'legend' => array('enabled' => false),
                    'tooltip' => array('formatter' => "js:function(){return '<b>' + this.y + ' people chose this answer</b>'}"),
                    'plotOptions' => array(
                        'bar' => array('groupPadding' => 0, 'pointPadding' => 0.33,
                            'dataLabels' => array('enabled' => true, 'align' => 'right', 'color' => '#FFFFFF', 'x' => -10)),
                        'series' => array('minPointLength' => 2, 'colorByPoint' => false, 'color' => '#1aadce', 'shadow' => true, 'cursor' => 'pointer')),
                    'series' => array(array('data' => $chartArray)),
                    'navigation' => array('buttonOptions' => array('height' => 34, 'width' => 42, 'symbolSize' => 18, 'symbolX' => 19, 'symbolY' => 17, 'symbolStrokeWidth' => 2)),
                    'exporting' => array('enabled' => false, 'filename' => 'MySurvey-report'),
                )
            ));
            echo '</br></br>';
        }
    }
    //short answers
    else {
        
        //get all the answer texts
        $answersText = '';
        foreach ($question->answers as $answer) {
            foreach ($answer->responses as $response)
            {
                $answersText = $answersText . ' ' . $response->text;
            }
        }
        
        //count the words
        $wordsArray = array_count_values(str_word_count($answersText, 1));
        arsort($wordsArray);
        
        $chartArray = array();
        $answerArray = array();
        $responseCount = 0;
        
        foreach(array_slice($wordsArray, 0, 10) as $w => $c) {
            $chartArray[] = array($w, $c);
            $answerArray[] = array($w);
            $responseCount = count($wordsArray);
        }
		echo '<h2>' . $question->text . '</h2>';
        if ($responseCount == 0) {
            echo '<h4>Currently there are no responses.</h4></br>';
        } else {
            echo '<h5>Top 10 words used. To see all the responses, download the full report above.</h5>';
            //bar chart
            $this->Widget('ext.highcharts.HighchartsWidget', array(
                'scripts' => array('highcharts-more', 'modules/exporting', 'themes/grid'),
                'options' => array(
                    'chart' => array('type' => 'bar'),
                    'credits' => array('enabled' => false),
                    'title' => array(''),
                    'xAxis' => array('categories' => $answerArray, 'title' => array('text' => 'Words')),
                    'yAxis' => array('title' => array('text' => 'Word Counter', 'align' => 'high', 'margin' => 8),
                    'gridLineDashStyle' => 'longdash',
                    'tickInterval' => 1,
                    'min' => 0,
                    'labels' => array('overflow' => 'justify')),
                    'legend' => array('enabled' => false),
                    'tooltip' => array('formatter' => "js:function(){return '<b>' + this.y + ' people used this word in their response</b>'}"),
                    'plotOptions' => array(
                        'bar' => array('groupPadding' => 0, 'pointPadding' => 0.33,
                            'dataLabels' => array('enabled' => true, 'align' => 'right', 'color' => '#FFFFFF', 'x' => -10)),
                        'series' => array('minPointLength' => 2, 'colorByPoint' => false, 'color' => '#1aadce', 'shadow' => true, 'cursor' => 'pointer')),
                    'series' => array(array('data' => $chartArray)),
                    'navigation' => array('buttonOptions' => array('height' => 34, 'width' => 42, 'symbolSize' => 18, 'symbolX' => 19, 'symbolY' => 17, 'symbolStrokeWidth' => 2)),
                    'exporting' => array('enabled' => false, 'filename' => 'MySurvey-report'),
                )
            ));
            echo '</br>';
        }
    }
}