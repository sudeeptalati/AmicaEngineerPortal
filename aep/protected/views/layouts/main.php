<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print">
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection">
    <![endif]-->

	<!-- Font Awesome-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

    <title><?php echo CHtml::encode( $this->pageTitle ); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo">

            <table style="margin-bottom:0; ">
                <tr>
                    <td>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>"> <?php echo CHtml::encode( Yii::app()->name ); ?></a>
                    </td>
                    <td style="text-align: right;"><img style="width:150px;height:45px;"src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png">
                    </td>
                </tr>
            </table>


        </div>

    </div><!-- header -->

    <div id="mainmenu">
        <?php
        $this->widget( 'zii.widgets.CMenu', array(
            'items' => array(
                /*				*
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'User', 'url'=>array('/user')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),

                */
                array('label' => 'Rights', 'url' => array('/rights'), 'visible' => UserModule::isAdmin()),
                array('label' => 'Users', 'url' => array('/user/admin/search'), 'visible' => UserModule::isAdmin()),
                array('label' => 'All Calls', 'url' => array('/servicecalls/admin'), 'visible' => UserModule::isAdmin()),
      
                array('label' => 'Servicecalls', 'url' => array('/servicecalls/mycalls'), 'visible' => !Yii::app()->user->isGuest),
                array('label' => 'My Account', 'url' => array('/user/profile'), 'visible' => !Yii::app()->user->isGuest),
                array('label' => 'Login', 'url' => array('/user/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
            ),
        ) ); ?>
    </div><!-- mainmenu -->
    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget( 'zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        ) ); ?><!-- breadcrumbs -->
    <?php endif ?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">
        Copyright &copy; <?php echo date( 'Y' ); ?> by UK Whitegoods Ltd.<br/>
        All Rights Reserved.<br/>
        <?php //echo Yii::powered(); ?>
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
