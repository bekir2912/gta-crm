<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 14.10.2017
 * Time: 2:34
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $question->question;
$ava = $question->user->avatar? $question->user->avatar: '/uploads/site/default_shop.png';

$this->registerJs(
    '$(\'.delete-theme\').on(\'click\', function () {
        var r = confirm("'.Yii::t('frontend', 'Confirm deleting').'");
        if (r == true) {
            var button = $(this);
            $.ajax({
                url: "/forum/delete-theme",
                data: {\'theme_id\': button.data(\'id\')}, //data: {}
                type: "post",
                success: function (t) {
                    t = JSON.parse(t);
                    if (t.error !== true) {
                           window.location.href = "'.Url::to(['forum/index']).'"
                    }
                }
            });
            return false;
        }
        return false;
    });
    $(\'.delete-answer\').on(\'click\', function () {
        var r = confirm("'.Yii::t('frontend', 'Confirm deleting').'");
        if (r == true) {
            var button = $(this);
            $.ajax({
                url: "/forum/delete-answer",
                data: {\'id\': button.data(\'id\')}, //data: {}
                type: "post",
                success: function (t) {
                    t = JSON.parse(t);
                    if (t.error !== true) {
                        button.parent().parent().parent().hide();
                        button.parent().parent().parent().remove();
                    }
                }
            });
            return false;
        }
        return false;
    });
    '
);
?>

<div class="forum-themes-list">
    <div class="forum-themes-item">
        <div class="row">
            <div class="col-md-1">#<?=$question->id?></div>
            <div class="col-md-7">
                <?php if(!Yii::$app->user->isGuest && Yii::$app->user->id == $question->user_id) { ?>
                    <span class="pull-right"><i class="fa fa-trash-o text-muted pointer delete-theme" style="z-index: 1000;" data-id="<?=$question->id?>"></i></span>
                <?php } ?>
                <strong><?=$question->question?></strong>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3"><img src="<?=$ava?>" class="forum__user-image"> <?=$question->user->name?></div>
            <div class="col-md-1"><i class="fa fa-comment-o"></i> <?=count($question->answers)?></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span class="forum-time text-muted"><?=date('d.m.Y, H:i', $question->user->created_at)?></span>
            </div>
        </div>
    </div>
    <?php if(!empty($answers)) { ?>
        <div class="forum-answer-list">
    <?php for($i = 0; $i < count($answers); $i++) {
        $ava = $answers[$i]->user->avatar? $answers[$i]->user->avatar: '/uploads/site/default_shop.png';
        ?>
            <div class="forum-answer-item">
                <p class="user-name">
                    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->id == $answers[$i]->user_id) { ?>
                        <span class="pull-right"><i class="fa fa-trash-o text-muted pointer delete-answer" style="z-index: 1000;" data-id="<?=$answers[$i]->id?>"></i></span>
                    <?php } ?>
                    <img src="<?=$ava?>" class="forum__user-image"> <?=$answers[$i]->user->name?> <span class="forum-time text-muted"><?=date('d.m.Y, H:i', $answers[$i]->created_at)?></span>
                <span class="clearfix"></span>
                </p>
                <p class="user-answer"><?=$answers[$i]->answer?></p>
            </div>
    <?php } ?>
        </div>
    <?php } ?>

    <?php if(Yii::$app->user->isGuest) { ?>
        <p class="text-center">
            <a href="<?= Url::to(['site/login']) ?>"><?=Yii::t('frontend', 'Auth to add answer')?></a>
        </p>
    <?php } else { ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'answer')->textarea(['placeholder' => Yii::t('frontend', 'Answer text')])->label(false) ?>
        <p>
            <button class="btn btn-success"><?=Yii::t('frontend', 'Add answer')?></button>
        </p>
        <?php ActiveForm::end(); ?>
    <?php } ?>

    <div class="text-center">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
</div>