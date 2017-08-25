<?php

namespace app\controllers;

use app\models\Address;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Offices;

$of = new Offices();

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
     * @inheritdoc
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $address = new Address();
        $model = new Offices();
        if($model->load(Yii::$app->request->post()) AND $address->load(Yii::$app->request->post())){
            if($address -> addAddress($address -> city, $address -> street, $address ->house_number)) {
                $sql = Address::findBySql("SELECT MAX(`id_address`) AS id FROM address")->asArray()->one();
                $id_address = $sql['id'];
                if ($model->addOffice($model->title_office, $id_address)) {
                    Yii::$app->session->setFlash('success', 'Все данные успешно внесены в бд.');
                } else Yii::$app->session->setFlash('danger', 'Название офиса не было записано в бд.');
            }else Yii::$app->session->setFlash('danger', 'Адрес не был записан бд.');
            return $this->render('contact', [
                'model' => $model,
                'address' => $address,
            ]);
        }else {
            return $this->render('contact', [
                'model' => $model,
                'address' => $address,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
