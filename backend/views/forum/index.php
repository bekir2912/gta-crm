<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 14.10.2017
 * Time: 2:34
 */
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t('frontend', 'Forum');

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
                        button.parent().parent().parent().parent().parent().hide();
                        button.parent().parent().parent().parent().parent().remove();
                    }
                }
            });
            return false;
        }
        return false;
    });'
);

?>
<form class="form-inline">
    <div class="form-group" style="width: 100%;">
        <label class="sr-only" for="exampleInputAmount"><?=Yii::t('frontend', 'Search by theme')?></label>
        <div class="input-group" style="width: 100%;">
            <input type="text" name="q" style="border-radius: 25px;" class="form-control" value="<?=$q?>" placeholder="<?=Yii::t('frontend', 'Search by theme')?>">
            <div class="input-group-addon" style="padding: 0;border: 0;"><button type="submit" style="width: 100%" class="btn btn-success"><i class="fa fa-search"></i></button></div>
        </div>
    </div>
</form>

<p></p>
<div class="forum-themes-list">
    <?php for ($i = 0; $i < count($questions); $i++) {
        $ava = $questions[$i]->user->avatar? $questions[$i]->user->avatar: '/uploads/site/default_shop.png';
        ?>
        <a href="<?=Url::to(['forum/show', 'id' => $questions[$i]->id])?>">
            <div class="forum-themes-item">
                <div class="row">
                    <div class="col-md-1">#<?=$questions[$i]->id?></div>
                    <div class="col-md-7">
                        <span class="pull-right"><i class="fa fa-trash-o text-muted pointer delete-theme" style="z-index: 1000;" data-id="<?=$questions[$i]->id?>"></i></span>
                        <?php if ($questions[$i]->is_moderated == 0) { ?>
                            <strong class="text-danger"><?=$questions[$i]->question?></strong>
                        <?php } else { ?>
                            <strong><?=$questions[$i]->question?></strong>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-3"><img src="<?=$ava?>" class="forum__user-image"> <?=$questions[$i]->user->name?></div>
                    <div class="col-md-1 text-right"><i class="fa fa-comment-o"></i> <?=count($questions[$i]->answers)?>
                    <?=(count($questions[$i]->newAnswers) > 0)? '| <strong class="text-danger">'.count($questions[$i]->newAnswers).'</strong>': ''?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="forum-time text-muted"><?=date('d.m.Y, H:i', $questions[$i]->user->created_at)?></span>
                    </div>
                </div>
            </div>
        </a>
    <?php } ?>
</div>

<div class="text-center">
    <?php echo LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>