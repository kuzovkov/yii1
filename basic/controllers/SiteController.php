<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MyForm;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\web\Cookie;
use app\models\Comments;
use app\models\ImportForecastsForm;


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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHello($message='Hello world')
    {
        return $this->render('hello', ['message' => $message]);
    }

    public function actionForm($message='Hello world')
    {
        $form = new MyForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            //var_dump($_FILES);
            $name = Html::encode($form->name);
            $email = Html::encode($form->email);
            $form->file = UploadedFile::getInstance($form, 'file');
            $form->file->saveAs('photo/'.$form->file->baseName.'.'.$form->file->extension);
        }else{
            $name = $email = '';
        }

        return $this->render('form', ['form' => $form, 'name' => $name, 'email' => $email]);
    }

    public function actionForm2()
    {
        $model = new ImportForecastsForm();
        if ($model->load(Yii::$app->request->post())){
            var_dump($_FILES);
            var_dump($model->validate());
            //var_dump($model->errors);
            /*$analyst_id = intval($model->analyst_id);
            $file = UploadedFile::getInstance($model, 'file');
            $analyst = Analyst::findOne(['id' => $analyst_id]);
            if (!$analyst)
                $error[] = Yii::t('app', 'Analyst not found!');
            if ($file->hasError)
                $error[] = $file->error;
            file_put_contents('/var/www/html/debug.txt', print_r($analyst, true), FILE_APPEND);
            file_put_contents('/var/www/html/debug.txt', print_r($file->hasError, true), FILE_APPEND);
            if ($analyst && !$file->hasError){

                $message = ImportController::importForecastsFromCSV($analyst, $file->tempName);
            }*/
        }
        return $this->render('import', [
            'model' => $model
        ]);

    }

    public function actionComments(){

        $comments = Comments::find();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $comments->count()]);
        $comments = $comments->offset($pagination->offset)->limit($pagination->limit)->all();
        $sessions = Yii::$app->session;
        $name = $sessions->get('name');
        $cookies = Yii::$app->request->cookies;
        $cookiename = $cookies->getValue('name');
        return $this->render('comments', ['comments'=> $comments, 'pagination' => $pagination, 'name' => $name, 'cookiename' => $cookiename]);

    }

    public function actionUser(){
        $user = Yii::$app->request->get('name', 'Unknown');
        $sessions = Yii::$app->session;
        $sessions->set('name', $user);
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie(['name' => 'name', 'value' => 'cookie-'.$user]));
        return $this->render('user', ['user' => $user]);
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

        $model->password = '';
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
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
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
