<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 12.10.2017
 * Time: 20:30
 */
use common\models\Category;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Html;
use yii\helpers\Url;

$cats = Category::find()->where(['status' => 1, 'parent_id' => null])->orderBy('order')->all();
$new_chat = \common\models\Chat::find()->where(['user_id' => Yii::$app->user->id, 'direction' => 2, 'is_read' => 0])->count('id');

?>

<div class="dropdown profile-cat-menu">
    <a class="text-secondary" href="<?=Url::to(['category/list'])?>" type="button" id="catLvl_0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <strong><?= Yii::t('frontend', 'Product catalogue') ?> <?= FA::i('folder-open')->addCssClass('pull-right text-muted') ?></strong>
    </a>
    <ul class="dropdown-menu" aria-labelledby="catLvl_0">
        <?php if (!empty($cats)) { ?>
            <?php foreach ($cats as $cat) { ?>
                <li class="lcm-title">
                    <a href="<?= Url::to(['category/index', 'id' => $cat->url]) ?>" class="lcm-link">
                        <?= $cat->translate->name ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
        <div class="separator"></div>
<ul class="list-unstyled profile-menu">
    <li>
        <a href="<?= Url::to(['user/index']) ?>">
            <?php if (Yii::$app->requestedAction->id == 'index') { ?>
            <span class="text-secondary">
                <?php } ?>
                <?= FA::i('user-circle-o') . '&nbsp;' . Yii::t('frontend', 'Profile') ?>
                <?php if (Yii::$app->requestedAction->id == 'index') { ?>
            </span>
        <?php } ?>
        </a>
    </li>
    <li>
        <a href="<?= Url::to(['user/addresses']) ?>">
            <?php if (Yii::$app->requestedAction->id == 'addresses') { ?>
            <span class="text-secondary">
                <?php } ?>
                <?= FA::i('map-marker') . '&nbsp;&nbsp;' . Yii::t('frontend', 'Addresses') ?>
                <?php if (Yii::$app->requestedAction->id == 'addresses') { ?>
            </span>
        <?php } ?>
        </a>
    </li>
    <li>
        <a href="<?= Url::to(['user/reviews']) ?>">
            <?php if (Yii::$app->requestedAction->id == 'reviews' || Yii::$app->requestedAction->id == 'review') { ?>
            <span class="text-secondary">
                <?php } ?>
                <?= FA::i('comment') . '&nbsp;' . Yii::t('frontend', 'Reviews') ?>
                <?php if (Yii::$app->requestedAction->id == 'reviews') { ?>
                </span>
        <?php } ?>
        </a>
    </li>
    <li>
        <a href="<?= Url::to(['user/purchases']) ?>">
            <?php if (Yii::$app->requestedAction->id == 'purchases' || Yii::$app->requestedAction->id == 'purchase') { ?>
            <span class="text-secondary">
                <?php } ?>
                <?= FA::i('shopping-cart') . '&nbsp;' . Yii::t('frontend', 'Purchases') ?>
                <?php if (Yii::$app->requestedAction->id == 'purchases') { ?>
            </span>
        <?php } ?>
        </a>
    </li>
    <li>
        <a href="<?= Url::to(['user/messages']) ?>" >
            <?php if (Yii::$app->requestedAction->id == 'messages') { ?>
            <span class="text-secondary">
                <?php } ?>
                <?= FA::i('wechat') . '&nbsp;' . Yii::t('frontend', 'Messages') ?> <?=($new_chat > 0)? '<span class="badge">'.$new_chat.'</span>':''?>
                <?php if (Yii::$app->requestedAction->id == 'messages') { ?>
            </span>
        <?php } ?>
        </a>
    </li>
    <li class="separator" role="separator"></li>
    <li>
        <?= Html::beginForm(['/site/logout'], 'post') .
        Html::submitButton(
            FA::icon('sign-out')->addCssClass('text-danger') . ' ' . Yii::t('frontend', 'Sign out'),
            ['class' => 'btn-link logout-btn logout']
        )
        . Html::endForm()
        ?>
    </li>
</ul>
