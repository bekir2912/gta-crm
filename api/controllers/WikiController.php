<?php

namespace api\controllers;

use api\transformers\BrandsList;
use api\transformers\CategoryList;
use api\transformers\LineupList;
use api\transformers\MetaData;
use api\transformers\WikiLineupList;
use common\models\Brand;
use common\models\Lineup;
use common\models\News;
use common\models\Category;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class WikiController extends Controller
{

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionList($id) {
        $data = $this->getList($id);
        if (isset($data['message'])) {
            return $this->redirect(['site/error', 'message' => $data['message'], 'code' => $data['code']]);
        }

        return $this->asJson([
            'data' => BrandsList::transform($data['brands']),
            'meta' => MetaData::transform($data['pages']),
        ]);
    }

    public function actionCategory() {

        return $this->asJson([
            'data' => CategoryList::transform(Category::find()->where(['status' => 1, 'parent_id' => null, 'on_main' => 0, 'spec' => 0])->orderBy('order')->all()),
        ]);
    }

    public function getList($id)
    {
        $category = $id;
        if (empty($category = Category::findOne(['id' => $category, 'status' => 1]))) $category = false;

        $query = Brand::find();

        if ($category->on_main == 1 || $category->spec == 1) return ['message' => 'Not Found', 'code' => 404];
        if ($category) {
            $temp_category = $category;
            $ids = [$category->id];

            if ($temp_category->activeCategories) {
                $ids = array_merge($ids, $this->getIds($temp_category));
                foreach ($temp_category->activeCategories as $activeCategory) {
                    $ids = array_merge($ids, $this->getIds($activeCategory));
                }
            }
            $query->where(['in', 'category_id', $ids]);
        }

        $q = trim(Yii::$app->request->get('q', ''));

        if ($q) {
            $query->andWhere(['like', 'name' , $q]);
        }

        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 24]);
        $pages->validatePage = false;
        $brands = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('name')
            ->all();

        return [
            'brands' => $brands,
            'pages' => $pages,
        ];
    }

    public function actionShow($id)
    {
        $brand = Brand::findOne(['status' => 1, 'id' => $id]);
        if (empty($brand)) return ['message' => 'Not Found', 'code' => 404];


        $q = trim(Yii::$app->request->get('q', ''));

        $lineups = $brand->lineups;
        $result = [];

        if($q != '') {
            $q = mb_strtolower($q);
            for ($i = 0; $i < count($lineups); $i++) {
                if ((mb_strpos(mb_strtolower($lineups[$i]->translate->name), $q) !== false)) {
                    $result[] = $lineups[$i];
                }
            }
            $lineups = array_values($result);
        }

        usort($lineups, function ($a, $b) {
            return strcmp($a->translate->name, $b->translate->name);
        });

        return $this->asJson([
            'data' => LineupList::transform($lineups? $lineups: [])
        ]);
    }

    public function actionLineup($id)
    {
        $lineup = Lineup::findOne(['status' => 1, 'id' => $id]);
        if (empty($lineup)) return ['message' => 'Not Found', 'code' => 404];

        return $this->asJson([
            'data' => WikiLineupList::transform([$lineup])
        ]);
    }

    protected function getIds($category)
    {
        $ids = ArrayHelper::map(ArrayHelper::toArray($category->activeCategories), 'id', 'user_id');
        return array_keys($ids);
    }
}