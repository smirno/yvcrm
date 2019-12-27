<?php

use yii\helpers\Html;
use app\assets\SiteAsset;
use app\widgets\Alert;

SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->title ?></title>
        <?= $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="app" class="wrap">
            <div class="container">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
        <?php $this->endBody() ?>
        <script>
            var csrf = {
                param: '<?= $this->request->csrfParam ?>',
                token: '<?= $this->request->csrfToken ?>'
            }
        </script>
    </body>
</html>
<?php $this->endPage() ?>
