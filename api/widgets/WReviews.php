<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 18.09.2017
 * Time: 6:08
 */
namespace frontend\widgets;

use common\models\OrderProduct;
use yii\bootstrap\Widget;

class WReviews extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('review/view', [
            'reviews' => OrderProduct::find()->where('`comment_status` > 0')->orderBy('`created_at` DESC')->limit(8)->all()
        ]);
    }
}