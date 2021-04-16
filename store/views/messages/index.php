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

$this->title = 'Сообщения';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-block">
            <div class="news_body ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header ">
                            <?= $this->title ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 no-pad-right">
                        <div class="news_body no-pad-right">
                            <?php if(!empty($chats)) { ?>
                            <?php foreach ($chats as $chat) {

                                $new_chat = 0;
                                $new_chat = \common\models\Chat::find()->where(['user_id' => $chat->user->id, 'direction' => 1, 'is_read' => 0, 'shop_id' => Yii::$app->session->get('shop_id'), 'type' => 'shop'])->count('id');?>
                                <div class="chat_block">
                                    <a href="<?=Url::to(['messages/index', 'im' => $chat->user->id])?>" <?php if($chat->user->id == $active->user->id) { ?>class="active" <?php } ?>>
                                        <?=$chat->user->name?> <?=($new_chat > 0)? '<span class="badge">'.$new_chat.'</span>':''?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-8 no-pad-left">
                        <form action="<?=Url::to(['messages/send-message'])?>" method="post">
                            <div class="chat_content">
                                <?php if(!empty($active)) { ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?=$active->user->name?>
                                        </div>
                                    </div>
                                    <p class="separator"></p>
                                    <div class="row">
                                        <div class="col-sm-12 chat_content_messages">
                                            <?php if(!empty($messages)) { ?>
                                                <?php foreach ($messages as $message) {
                                                    $class = ($message->direction == 2)? 'bg-primary outgoing_mess': 'bg-secondary income_message'?>
                                                    <div class="<?=$class?>">
                                                        <?=$message->message?>
                                                        <p>
                                                            <small class=" pull-right"><?=date('d.m.Y H:i:s', $message->created_at)?></small>
                                                        </p>
                                                    </div>
                                                <?php } ?>
                                            <?php } else {?>
                                                <p class="text-muted">
                                                    Нет сообщений
                                                </p>
                                                <div class="clearfix"></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else {?>
                                    <p class="text-muted">
                                        Выберите чат
                                    </p>
                                <?php } ?>
                            </div>

                            <?php if(!empty($active)) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="mess"></label>
                                                <textarea name="message" id="mess" cols="30" rows="4" style="resize: none;" placeholder="Введите текст сообщения" class="form-control" required="required"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="<?= $this->renderDynamic('return Yii::$app->request->csrfParam;'); ?>"
                                                       value="<?= $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>"/>
                                                <input type="hidden" value="<?=$active->user->id?>" name="user_id">
                                                <button type="submit" class="btn btn-primary" >Отправить</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </form>
                        <?php } else { ?>
                            <p class="text-muted">
                                Нет сообщений
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
