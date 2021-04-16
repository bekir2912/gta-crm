<?php

namespace backend\controllers;

use common\models\Answer;
use common\models\Question;
use Yii;
use yii\data\Pagination;

class ForumController extends BehaviorsController
{
    public function actionIndex()
    {
        $q = Yii::$app->request->get('q', '');

        $query = Question::find()->orderBy('`id` DESC');
        if ($q) {
            $query->where(['like', 'question' , $q]);
        }
        if(Yii::$app->request->get('sort')) {
            $query->orderBy('is_moderated');
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $questions = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        Yii::$app->session->set('found_variants', $pages->totalCount);
        return $this->render('index', [
            'questions' => $questions,
            'pages' => $pages,
            'q' => $q,
            ]);
    }

    public function actionShow($id = null)
    {

        $theme = Question::findOne($id);
        if (!$theme) return $this->redirect(['forum/index']);

//        $model = new AnswerForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $model->addAnswer($id);
//            return $this->refresh();
//        }
        $theme->is_moderated = 1;
        $theme->save();

        $query = Answer::find()->where(['question_id' => $theme->id])->orderBy('`id` ASC');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $answers = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('show', [
//            'model' => $model,
            'question' => $theme,
            'answers' => $answers,
            'pages' => $pages,
            ]);
    }

    public function actionDeleteTheme()
    {
        if (!empty($question_id = Yii::$app->request->post('theme_id'))) {
            $item = Question::findOne(['id' => $question_id]);
            if (empty($item)) return json_encode(['error' => 'empty-item']);
            $item->delete();
            return json_encode(['error' => false]);
        }
        return json_encode(['error' => true]);
    }

    public function actionDeleteAnswer()
    {

        if (!empty($id = Yii::$app->request->post('id'))) {
            $item = Answer::findOne(['id' => $id]);
            if (empty($item)) return json_encode(['error' => 'empty-item']);
            $item->delete();
            return json_encode(['error' => false]);
        }
        return json_encode(['error' => true]);
    }
}
