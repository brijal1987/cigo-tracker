<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Order model
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property number $phone
 * @property enum $order_type
 * @property float $order_value
 * @property integer $schedule_date
 * @property string $street_address
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property enum $country
 * @property integer $created_at
 * @property integer $updated_at
 */
class Order extends Model
{
    const ORDER_TYPE_DELIVERY = 'Delivery';
    const ORDER_TYPE_SERVICING = 'Servicing';
    const ORDER_TYPE_INSTALLATION = 'Installation';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['order_type', 'default', 'value' => self::ORDER_TYPE_DELIVERY],
            ['order_type', 'in', 'range' => [self::ORDER_TYPE_DELIVERY, self::ORDER_TYPE_SERVICING, self::ORDER_TYPE_INSTALLATION]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
}
