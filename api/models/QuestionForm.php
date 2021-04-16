<?php
namespace api\models;

use common\components\SimpleImage;
use common\models\Question;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class QuestionForm extends Model
{
    public $question;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['question', 'trim'],
            ['question', 'required'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question' => Yii::t('frontend', 'Forum Theme'),
        ];
    }

    public function addQuestion()
    {
        if (!$this->validate()) {
            return null;
        }
        $question = new Question();

        $question->file = null;
        $file = UploadedFile::getInstanceByName('file');
        if($file){
            $dir = (__DIR__).'/../../uploads/users/';
            $path = $file->baseName.'.'.$file->extension;
            if($file->saveAs($dir.$path)) {
                $image_name = uniqid().'.'.$file->extension;
                rename($dir.$path, $dir.$image_name);
//                    $resizer->save($dir.$image_name);
                $question->file = '/uploads/users/'.$image_name;
                if(file_exists($dir.$path)) unlink($dir.$path);
            }
        }

        $question->user_id = Yii::$app->user->identity->id;
        $question->question = $this->question;
        return $question->save() ? $question : null;
    }
}
