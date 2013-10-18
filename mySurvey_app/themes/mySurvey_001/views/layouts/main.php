<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/main.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div class="content-area">			
			<div id="logo-container"><img id="headerLogo" src="<?php echo Yii::app()->request->baseUrl; ?>/static/img/logo-white.png"></div>
		
		
			<div id="logout">
                            <?php echo Yii::app()->user->name?><a href="<?php echo $this->createUrl('/logout')?>">Logout</a>
			</div><!-- logout -->
		
		</div>
	</div><!-- header -->


	<div class="content-area">
		<div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
                            'items'=>array(
                                    array('label'=>'Surveys', 'url'=>array('/survey')),
                                    array('label'=>'Reports', 'url'=>array('/reports')),
                                    array('label'=>'Account Settings', 'url'=>array('/settings'))
                            ),
                        )); ?>
		</div><!-- mainmenu -->
	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
                
        <div id="content">
            <?php echo $content; ?>
        </div>
    </div>          


	<div id="footer">
		<p>Footer content tk...</p>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
