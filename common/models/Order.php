<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Order extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['first_name', 'match' ,'pattern'=>'/^[A-Za-z0-9_]+$/u',
                'message'=> 'Firstname can contain only alphanumeric characters and hyphens(-).'],

            ['last_name', 'trim'],
            ['last_name', 'match' ,'pattern'=>'/^[A-Za-z0-9_]+$/u',
                'message'=> 'Lastname can contain only alphanumeric characters and hyphens(-).'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'number', 'min' => 10],

            ['order_type_id', 'required'],

            ['order_value', 'trim'],
            ['order_value', 'number'],

            ['schedule_date', 'required'],

            ['street_address', 'trim'],
            ['street_address', 'required'],
            ['street_address', 'string'],

            ['city', 'trim'],
            ['city', 'required'],
            ['city', 'string'],

            ['state', 'trim'],
            ['state', 'required'],
            ['state', 'string'],

            ['zip_code', 'trim'],
            ['zip_code', 'match' ,'pattern'=>'/^[A-Za-z0-9]+$/u',
                'message'=> 'Zipcode can contain only alphanumeric characters.'],

            ['country_id', 'required'],

            ['status', 'required'],
            [
                'status',
                'in',
                'range'=>array(1,2,3,4,5),
            ],
            ['lat', 'required'],
            ['lon', 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

}
