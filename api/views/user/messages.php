<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 12.10.2017
 * Time: 16:34
 */
use frontend\widgets\WProduct;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Messages');
?>
<?php if(!empty($chats)) { ?>
<section class="lk-message">
    <div class="lk-message__message-bar">
        <?php foreach ($chats as $chat) {
            $new_chat = 0;

            if($chat->type == 'shop') {
                $new_chat = \common\models\Chat::find()->where(['user_id' => Yii::$app->getUser()->identity->id, 'type' => 'shop', 'direction' => '2', 'is_read' => 0])->count();
            } else {
                $new_chat = \common\models\Chat::find()->where(['user_id' => $chat->shop_id, 'shop_id' => Yii::$app->getUser()->identity->id, 'type' => 'user', 'is_read' => 0])->count();
            } ?>
            <?php if ($chat->type == 'shop') { ?>
            <div class="message-bar__item <?php if($chat->shop->id == $active->shop_id && $active->type == 'shop') { ?> message-bar__item_active <?php } ?>">
                <a href="<?=Url::to(['user/messages', 'im' => base64_encode($chat->type.':'.$chat->shop->id)])?>" style="color: inherit">
                <img src="<?=$chat->shop->logo?>" class="lk-message__user-image">
                <p class="lk-message__user-name">
                    <?=$chat->shop->name?> <?=($new_chat > 0)? '<span class="badge">'.$new_chat.'</span>':''?>
                </p>
                </a>
            </div>
            <?php } elseif ($chat->type == 'user') {
                $user = \common\models\User::findOne($chat->shop_id);
                ?>
                <div class="message-bar__item <?php if($chat->shop_id == $active->shop_id && $active->type == 'user') { ?> message-bar__item_active <?php } ?>">
                    <a href="<?=Url::to(['user/messages', 'im' => base64_encode($chat->type.':'.$chat->shop_id)])?>" style="color: inherit">
                        <img src="<?=$user->avatar? $user->avatar: '/uploads/site/default_shop.png'?>" class="lk-message__user-image">
                        <p class="lk-message__user-name">
                            <?=$user->name?> <?=($new_chat > 0)? '<span class="badge">'.$new_chat.'</span>':''?>
                        </p>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="lk-message__dialog">
        <?php if(!empty($active)) { ?>
        <?php if ($active->type == 'shop') {
            $name = $active->shop->name;
            $ava = $active->shop->logo;
            } elseif ($active->type == 'user') {
            $user = \common\models\User::findOne($active->shop_id);
                $name = $user->name;
                $ava = $user->avatar? $user->avatar: '/uploads/site/default_shop.png';
            ?>
            <?php } ?>
        <div class="dialog__info">
            <button href="#" class="dialog__back">
                <i class="flaticon-back"></i>
            </button>
            <h3 class="dialog__heading">
                <?=$name?>
            </h3>
            <img src="<?=$ava?>" class="dialog__user-image">
        </div>
        <div class="dialog__top">
            <?php if(!empty($messages)) { ?>
                <?php foreach ($messages as $message) {
                    if ($message->type == 'shop') {
                        $class = ($message->direction == 1)? 'message-out': 'message-in';
                    } else {
                        if ($message->user_id ==  Yii::$app->user->id) {
                            $class = 'message-out';
                        } else {
                            $class = 'message-in';
                        }
                    }
                    $ava = ($message->direction == 1)? ($message->user->avatar? $message->user->avatar: '/uploads/site/default_shop.png'): $message->shop->logo?>
                    <div class="dialog__message-item <?=$class?>">
                        <img src="<?=$ava?>" class="lk-message__user-image">
                        <div class="message-item__text">
                            <?=$message->message?>
                        </div>
                        <span class="message-item__time">
                                        <?=date('d.m.Y H:i:s', $message->created_at)?>
                                    </span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="dialog__bottom">
            <form action="<?=Url::to(['user/send-message'])?>" method="post" class="dialog_form">
                <?php
                $send_id = ($active->shop_id == Yii::$app->user->id)? $active->user_id: $active->shop_id;
                ?>
                    <input type="hidden" name="<?= $this->renderDynamic('return Yii::$app->request->csrfParam;'); ?>"
                           value="<?= $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>"/>
                    <input type="hidden" value="<?=base64_encode($active->type.':'.$send_id)?>" name="chat_id">
                <textarea rows="1" class="dialog__input" name="message" placeholder="<?=Yii::t('frontend', 'Write a message')?>"></textarea>
<!--                <div class="dialog__file-button dialog__button" id="file">-->
<!--                    <i class="flaticon-paper-clip"></i>-->
<!--                </div>-->
<!--                <input type="file" class="hide" id="image">-->
                <button class="dialog__mail-button dialog__button">
                    <i class="flaticon-mail"></i>
                </button>
            </form>
        </div>
<?php } ?>
    </div>
</section>
<?php } else { ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <p>
                <?=Yii::t('frontend', 'No messages')?>
            </p>
        </div>
    </div>
<?php } ?>