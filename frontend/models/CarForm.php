<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Car;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * CarForm represents the model for Car create/update form
 *
 * @property integer $categoryId
 * @property integer $status
 * @property string  $title
 * @property string  $image
 * @property integer $price
 * @property integer $year
 * @property string  $url
 *
 * @property UploadedFile $imageFile
 */
class CarForm extends \yii\base\Model
{
    /** @var Car */
    public $model;

    public $id;
    public $categoryId;
    public $status;
    public $title;
    public $image;
    public $price;
    public $year;
    public $url;

    public $imageFile;

    public function __construct(Car $model)
    {
        $this->model = $model;
        $this->setAttributes($model->getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'categoryId', 'price', 'year'], 'integer'],
            [['title', 'image', 'url'], 'string', 'max' => 255],
            [['url'], 'required'],
            ['categoryId', 'in', 'range' => array_keys(Car::getCategoryList())],
            ['status', 'in', 'range' => array_keys(Car::getStatusList())],

            ['imageFile', 'image', 'maxWidth' => 1000, 'maxHeight' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge($this->model->attributeLabels(), [
            'imageFile' => Yii::t('app', 'Изображение'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formModel = null)
    {
        $res = parent::load($data, $formModel);
        if ($res) {
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        }

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $res = ($this->validate() && $this->model->load($this->getAttributes(), '') && $this->model->validate());
        if ($res === true) {
            $relPath = $this->saveFile($this->imageFile);

            if ($this->model->image) {
                $this->deleteModelFile($this->model);
            }

            /*
                Это не очень хороший способ, когда путь к изображению хранится в самой сущности.
                Лучше хранить все загруженные файлы в отдельной таблице file, а в других сущностях использовать идентификаторы file_id.
                Это позволяет изолировать работу с диском в небольшом наборе компонентов.
                Но раз в задании используется путь, переделывать не будем.
            */
            $this->model->image = $relPath;

            if (!$this->model->save()) {
                $this->addErrors($this->model->getErrors());
            }
        } else {
            $this->addErrors($this->model->getErrors());
        }

        return $res;
    }

    /**
     * Save image file to upload directory and return relative path or null on error
     *
     * @param UploadedFile|null $imageFile
     * @return string|null
     */
    public function saveFile($imageFile)
    {
        if ($this->imageFile == null) {
            return null;
        }

        $baseDir = Yii::getAlias('@webroot' . Car::PATH_UPLOAD_PHOTO);
        $randomStr = unpack('H*', random_bytes(10))[1];

        $relPath = implode('/', [substr($randomStr, 0, 2), substr($randomStr, 2, 2), substr($randomStr, 4)]);
        $relPath .= '.' . $imageFile->getExtension();

        $fullPath = $baseDir . '/' . $relPath;
        FileHelper::createDirectory(dirname($fullPath));
        $saved = $imageFile->saveAs($fullPath);
        if (!$saved) {
            return null;
        }

        return $relPath;
    }

    /**
     * Delete image file related to model
     *
     * @param Car $model
     */
    public function deleteModelFile($model)
    {
        $fullPath = Yii::getAlias('@webroot' . $model->getImageRelativePath());
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
