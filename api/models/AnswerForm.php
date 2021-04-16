<?php
namespace api\models;

use common\models\Answer;
use common\models\Question;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class AnswerForm extends Model
{
    public $answer;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['answer', 'trim'],
            ['answer', 'required'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer' => Yii::t('frontend', 'Answer text'),
        ];
    }

    public function addAnswer($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $question = Question::findOne($id);
        if($question) {
            $answer = new Answer();

            $answer->file = null;
            $file = UploadedFile::getInstanceByName('file');
            if($file){
                $dir = (__DIR__).'/../../uploads/users/';
                $path = $file->baseName.'.'.$file->extension;
                if($file->saveAs($dir.$path)) {
                    $image_name = uniqid().'.'.$file->extension;
                    rename($dir.$path, $dir.$image_name);
//                    $resizer->save($dir.$image_name);
                    $answer->file = '/uploads/users/'.$image_name;
                    if(file_exists($dir.$path)) unlink($dir.$path);
                }
            }

            $answer->user_id = Yii::$app->user->identity->id;
            $answer->question_id = $id;
            $answer->answer = $this->answer;

            $head = Yii::$app->request->headers;
            $auth = $head->get('authorization');
            $user = null;
            if(isset($auth)) {
                $auth = str_replace('Basic ', '', $auth);
                $auth = base64_decode($auth);
                $auth = explode(':', $auth);
                if(isset($auth[0])) {
                    $user = User::findByUsername($auth[0]);
                }
            }
            if (($user) && ($question->user_id == Yii::$app->user->identity->id)) {
                $answer->is_read = 1;
            }

            return $answer->save() ? $answer : null;
        }
        return null;
    }
}
