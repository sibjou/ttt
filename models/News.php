<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class News extends ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'news';
    }

    public function rules()
    {
        return [
            [['title', 'slug', 'description', 'text', 'tags'], 'required', 'message' => 'Поле {attribute} обязательно.'],
            [['description', 'text'], 'string'],
            [['tags'], 'string', 'max' => 255],
            [['title', 'slug'], 'string', 'max' => 255],
            
            // Валидация формата slug
            [['slug'], 'match', 
                'pattern' => '/^[a-z0-9-]+$/', 
                'message' => 'Slug должен содержать только латинские буквы, цифры и дефисы.'
            ],
            
            // Проверка на уникальность slug
            [['slug'], 'unique', 
                'targetClass' => self::class, 
                'message' => 'Этот slug уже используется.'
            ],
            
            [['imageFile'], 'file', 
                'extensions' => 'png, jpg, jpeg', 
                'maxSize' => 10 * 1024 * 1024, 
                'message' => 'Вы можете загрузить только изображения с расширением PNG, JPG или JPEG.'
            ],
        ];
    }


    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }


    public function upload()
    {
        if ($this->validate() && $this->imageFile) {
            $uploadDir = \Yii::getAlias('@webroot/uploads'); // Путь к папке uploads
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Создать папку, если она отсутствует
            }

            $filePath = $uploadDir . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($filePath)) {
                $this->image = '/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension; // Сохраняем путь для базы данных
                return true;
            }
        }
        return false;
    }
}



