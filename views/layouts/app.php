<?php

use app\widgets\Alert;
use app\assets\AppAsset;

AppAsset::register($this);
$this->title = 'App';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" theme="light-mode">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->title ?></title>
        <?php echo $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?php echo $content ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>