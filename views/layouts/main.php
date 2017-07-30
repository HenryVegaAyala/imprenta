<?php

/* @var $this \yii\web\View */
/* @var $content string */

use kartik\widgets\Growl;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Cache-control" content="public">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="<?php echo Yii::$app->getHomeUrl(); ?>favicon.ico" type="image/x-icon"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php if (Yii::$app->user->isGuest) { ?>
<body class="login">
<?php } else { ?>
<body class="nav-md">
<?php } ?>
<?php $this->beginBody() ?>
<?php if (Yii::$app->user->isGuest) {
    echo $content; ?>
<?php } else { ?>

    <?php foreach (Yii::$app->session->getAllFlashes() as $message) { ?>
        <?php
        echo Growl::widget([
            'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
            'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
            'showSeparator' => true,
            'delay' => 1,
            'pluginOptions' => [
                'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000,
                'placement' => [
                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                ],
            ],
        ]);
        ?>
    <?php } ?>

    <?= $this->render('header.php') ?>
    <?= $this->render('activity.php') ?>
    <?= $content ?>
    <?= $this->render('footer.php') ?>
<?php } ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
