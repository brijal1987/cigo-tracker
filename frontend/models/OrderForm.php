<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\order;

/**
 * Orders form
 */
class OrderForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $order_type;
    public $order_value;
    public $schedule_date;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $country;


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

            ['order_type', 'trim'],
            ['order_type', 'required'],

            ['order_value', 'trim'],
            ['order_value', 'number'],

            [
                'schedule_date',
                'date',
                'message' => '{attribute}: is not a date!',
            ],

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

            ['country', 'trim'],
            ['country', 'required'],
            [
                'country',
                'in',
                'range'=>array('Canada','United States','Mexico'),
            ],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function order()
    {
        if (!$this->validate()) {
            return null;
        }

        $order = new Order();
        $order->first_name = $this->first_name;
        $order->last_name = $this->last_name;
        $order->email = $this->email;
        return $order->save();

    }

}
