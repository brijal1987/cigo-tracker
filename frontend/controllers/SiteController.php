<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Order;
use common\models\Country;
use common\models\OrderType;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use Geocodio;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'order'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Order Management.
     *
     * @return mixed
     */
    public function actionOrder()
    {
        try { 
            $countries = Country::Find()
            ->where(['status' => Country::STATUS_ACTIVE])
            ->all();

            $orderTypes = OrderType::Find()
            ->where(['status' => OrderType::STATUS_ACTIVE])
            ->all();
            $model = new Order();

            $request = \Yii::$app->getRequest();
            if ($request->isAjax) {

                if ($request->isPost && $model->load($request->post())) {
                    $geocoder = new Geocodio\Geocodio();
                    $geocoder->setApiKey('e65be9046f4064e5056cf69565eee5fe955d5ee');
                    $country_name = "";
                    foreach($countries as $country){
                        if($country->id == $request->post()['country_id']){
                            $country_name = $country->name;
                        }
                    }
                    $address = $request->post()['Order']['street_address'] ." ".
                    $request->post()['Order']['city'] . " ".
                    $request->post()['Order']['state'] . " ".
                    $request->post()['Order']['zip_code'] . " ". $country_name;
                    $geoResponse = $geocoder->geocode($address);
                    if(isset($geoResponse->results)){
                        $model->status = 1;
                        $model->lat = $geoResponse->results[0]->location->lat;
                        $model->lon = $geoResponse->results[0]->location->lng;
                        $model->schedule_date = $request->post()['schedule_date'];
                        \Yii::$app->response->format = Response::FORMAT_JSON;
                        if($model->validate())
                            return ['success' => $model->save()];
                    }
                    return $this->renderAjax('order', [
                        'model' => $model,
                        'countries' => $countries,
                        'orderTypes' => $orderTypes
                    ]);
                }
            }

            return $this->render('order', [
                'model' => $model,
                'countries' => $countries,
                'orderTypes' => $orderTypes
            ]);
        } catch (Geocodio\Exceptions\GeocodioException $exception) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'error' => $exception->getMessage()
            ];

        }
    }

    /**
     * Order Management.
     *
     * @return mixed
     */
    public function actionPreviewmap()
    {
        try {

            $request = \Yii::$app->getRequest();
            if ($request->isAjax) {
                if ($request->isPost) {
                    $countries = Country::Find()
                    ->where(['status' => Country::STATUS_ACTIVE])
                    ->all();

                    $geocoder = new Geocodio\Geocodio();
                    $geocoder->setApiKey('e65be9046f4064e5056cf69565eee5fe955d5ee');
                    $country_name = "";
                    foreach($countries as $country){
                        if($country->id == $request->post()['country_id']){
                            $country_name = $country->name;
                        }
                    }
                    $address = $request->post()['Order']['street_address'] ." ".
                    $request->post()['Order']['city'] . " ".
                    $request->post()['Order']['state'] . " ".
                    $request->post()['Order']['zip_code'] . " ". $country_name;
                    $geoResponse = $geocoder->geocode($address);
                    if(isset($geoResponse->results)){
                        \Yii::$app->response->format = Response::FORMAT_JSON;
                        return [
                            'success' => true,
                            'order' => $request->post()['Order'],
                            'geocode' => $geoResponse->results[0]->location
                        ];
                    }
                }
            }
        } catch (Geocodio\Exceptions\GeocodioException $exception) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'error' => $exception->getMessage()
            ];

        }
    }

    /**
     * Load Order.
     *
     * @return mixed
     */
    public function actionLoadorder()
    {
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {
            $sort = [
                'id' => SORT_DESC
            ];
            if($request->get()['order_by'] != ""){
                $sort = [
                    $request->get()['order_by'] => ($request->get()['order']=='4' ? SORT_ASC: SORT_DESC)
                ];
            }

            $orders = Order::Find()->orderBy($sort)->all();

            \Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'orders' => $orders,
                'sort' => $sort
            ];
        }
        return ["Invalid Request"];
    }

    /**
     * Change Order Status.
     *
     * @return mixed
     */
    public function actionChangestatus()
    {
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {
            $order = Order::findOne($request->post()['orderId']);
            $order->status = $request->post()['status'];
            if ($order->save()) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ['order' => $order];
            }
        }
        return ['Invalid Request'];
    }

    /**
     * Remove Order
     *
     * @return mixed
     */
    public function actionRemoveorder()
    {
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {
            $order = Order::findOne($request->post()['orderId']);
            if ($order->delete()) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => 1];
            }
        }
        return ['Invalid Request'];
    }

}
