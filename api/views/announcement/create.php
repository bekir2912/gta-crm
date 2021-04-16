<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t('frontend', 'Announce');
?>
<section class="lk-setting">
    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'brand' => $brand,
        'lineup' => $lineup,
        'info' => $info,
        'info_uz' => $info_uz,
        'info_oz' => $info_oz,
        'info_en' => $info_en,
    ]) ?>

</section>
