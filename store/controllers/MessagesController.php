<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 07.11.2017
 * Time: 20:22
 */

namespace store\controllers;


use common\models\Chat;
use common\models\FbToken;
use common\models\Shop;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class MessagesController extends BehaviorsController
{

    public function actionIndex()
    {
        if(empty(Shop::findOne(Yii::$app->session->get('shop_id')))) return $this->redirect(['shop/index']);
        $id = !empty(Yii::$app->request->get('im')) ? Yii::$app->request->get('im') : false;
        $messages = [];
        $active = [];
        $chats = Chat::find()->where(['shop_id' => Yii::$app->session->get('shop_id'), 'type' => 'shop'])
            ->groupBy(['user_id'])->orderBy('`created_at` DESC')->all();
        if ($id) {
            if (empty(User::findOne(['id' => $id, 'status' => 10]))) return $this->redirect(['messages/index']);
            $messages = Chat::find()->where(['shop_id' => Yii::$app->session->get('shop_id'), 'user_id' => $id, 'type' => 'shop'])->orderBy('`created_at`')->all();
            if (empty($active = Chat::findOne(['shop_id' => Yii::$app->session->get('shop_id'), 'user_id' => $id, 'type' => 'shop']))) {
                $active = new Chat();
                $active->user_id = $id;
                $active->shop_id = Yii::$app->session->get('shop_id');
                $active->direction = 2;
                $active->is_read = 0;
                $active->type = 'shop';
                $chats = ArrayHelper::merge($chats, [$active]);
            }
            Chat::updateAll(['is_read' => 1], ['user_id' => $id, 'direction' => 1, 'is_read' => 0, 'shop_id' => Yii::$app->session->get('shop_id'), 'type' => 'shop']);
        }


        if (!empty($chats)) {
            usort($chats, function ($a, $b) {
                if ($a->created_at == $b->created_at) {
                    return 0;
                }
                return ($a->created_at < $b->created_at) ? -1 : 1;
            });
        }

        return $this->render('index', [
            'messages' => $messages,
            'chats' => $chats,
            'active' => $active,
        ]);
    }

    public function actionSendMessage()
    {
        if(empty(Yii::$app->session->get('shop_id'))) return $this->redirect(['shop/index']);
        $id = !empty(Yii::$app->request->post('user_id')) ? Yii::$app->request->post('user_id') : false;
        $message = (!empty(Yii::$app->request->post('message')))? Yii::$app->request->post('message'): false;
        if (!$id) return $this->redirect(['messages/index']);
        if (!$message) return $this->redirect(['messages/index']);
        if (empty(User::findOne(['id' => $id, 'status' => 10]))) return $this->redirect(['messages/index']);
        $chat = new Chat();
        $chat->user_id = $id;
        $chat->shop_id = Yii::$app->session->get('shop_id');
        $chat->message = $message;
        $chat->direction = 2;
        $chat->is_read = 0;
        $chat->type = 'shop';
        $chat->save();

            $fbTokens = FbToken::find()->where(['user_id' => $chat->user_id ])->asArray()->all();

            if($fbTokens) {
                $fbTokens = ArrayHelper::map($fbTokens, 'id', 'token');

                $this->pushNotification('Новое сообщение', 'Кликните что бы прочитать', $fbTokens, 'message', base64_encode('shop:'.$chat->shop_id));
            }

        return $this->redirect(['messages/index', 'im' => $id]);
    }


    protected function pushNotification($title, $msg, $tokens = array(), $type, $news_id = null) {
        $note = Yii::$app->fcm->createNotification($title, $msg);

        $chunk = array_chunk($tokens, 1000);

        foreach ($chunk as $v) {
            $message = Yii::$app->fcm->createMessage($v);

            $message->setNotification($note)->setData(['message'=>$msg, 'title'=>$title, 'type'=>$type, 'im'=>$news_id, 'date'=>time()]);

            Yii::$app->fcm->send($message);
        }

        return true;
    }
}