<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/static/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/static/js/jquery.js" type="text/javascript"></script>
</head>
<body>
<?php 
	if(Yii::$app->getUser()->getIdentity()){
?>
	 <div class="login-header">
		<div id="pub-logo">
			<span class="logo f_l"><img width='130px' src="/static/img/login_logo.jpg"/><span class='logo-txt'>时趣-开放平台</span></span>
		</div>
		<div id="top-msg">

		
				<span><?php echo Yii::$app->getUser()->getIdentity()->username ?></span>
				<a href="/user/logout">[ 退出登录 ]</a>
		
		</div>
	</div>
<?php }else{?>
	<div class="login-header">
		<span class="logo f_l"><img width='130px' src="/static/img/login_logo.jpg"/><span class='logo-txt'>时趣-开放平台</span></span>
		<span class="tel f_r"><em class="tel-icon"></em>400-609-2655</span>
	</div>
<?php }?>

    <?= $content ?>


    <footer class="footer">
		<div class="footerbox">
			<div class="adr-tel f-mod"><p class="f-item">地址：北京市朝阳区广渠路38号北京一轻大厦东区4层</p><p class="f-item">联系电话：400 609 2655   邮箱：service@social-touch.com</p></div>
		</div>
	</footer>

</body>
</html>
<?php $this->endPage() ?>
