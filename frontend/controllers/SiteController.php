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
        $countries = Country::Find()
        ->where(['status' => Country::STATUS_ACTIVE])
        ->all();

        $orderTypes = OrderType::Find()
        ->where(['status' => OrderType::STATUS_ACTIVE])
        ->all();

        $model = new Order();
        $model->status = 1;
        $model->lat = 1;
        $model->lon = 1;
        $model->schedule_date = Yii::$app->request->post()['schedule_date'];
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {

            if ($request->isPost && $model->load($request->post())) {
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

        return $this->render('order', [
            'model' => $model,
            'countries' => $countries,
            'orderTypes' => $orderTypes
        ]);
    }

    /**
     * Load Order.
     *
     * @return mixed
     */
    public function actionLoadorder()
    {
        $orders = Order::Find()->orderBy([
            'id' => SORT_DESC
          ])->all();
        
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'orders' => $orders
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

}
