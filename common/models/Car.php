<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Автомобили.
 *
 * @property integer $id         Id
 * @property integer $status     Статус видимости (0 - не опубликован, 1-опубликован)
 * @property integer $categoryId Модельный ряд
 * @property string  $title      Название
 * @property string  $image      Изображение
 * @property integer $price      Цена
 * @property integer $year       Год
 * @property string  $url        Ссылка на автомобиль
 * @property integer $created_at Дата создания
 * @property integer $updated_at Дата обновления
 *
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * Количество отображаемых элементов в списке.
     */
    public $pageSize = 5;

    /**
     * Путь к папке с загруженными фото.
     */
    const PATH_UPLOAD_PHOTO = '/upload/car/img';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%car}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'categoryId', 'price', 'year'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
            [['url'], 'required'],
            [['url'], 'unique'],
            ['categoryId', 'in', 'range' => array_keys(self::getCategoryList())],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::className(),
        ];
    }

    /**
     * List of car categories
     *
     * Need to be removed when car category table will be added
     */
    public static function getCategoryList()
    {
        return [
            1 => Yii::t('app', 'Ниссан'),
            2 => Yii::t('app', 'Вольво'),
            3 => Yii::t('app', 'Форд'),
        ];
    }

    /**
     * List of car statuses
     *
     * Need to be removed when car status table will be added
     */
    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Активно'),
            self::STATUS_INACTIVE => Yii::t('app', 'Неактивно'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'status' => Yii::t('app', 'Статус'),
            'title' => Yii::t('app', 'Название'),
            'image' => Yii::t('app', 'Изображение'),
            'categoryId' => Yii::t('app', 'Модельный ряд'),
            'price' => Yii::t('app', 'Цена'),
            'url' => Yii::t('app', 'Ссылка на страницу'),
            'year' => Yii::t('app', 'Год выпуска'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    /**
     * Return image relative path from webroot
     * @return string|null
     */
    public function getImageRelativePath()
    {
        return ($this->image ? self::PATH_UPLOAD_PHOTO . '/' . $this->image : null);
    }
}
