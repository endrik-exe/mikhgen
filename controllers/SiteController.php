<?php
namespace app\controllers;

use app\controllers\MainController;
use app\components\AppHelper;
use app\models\LoginForm;
use DateTime;
use app\models\ContactForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use const YII_ENV_TEST;

/**
 * Site controller
 */
class SiteController extends MainController
{
    

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
     * @return mixed
     */
    public function actionIndex()
    {
        $sales = [];
        $thisMonthSale = 0;
        $thisMonthSaleCount = 0;
        $thisDaySale = 0;
        $thisDaySaleCount = 0;
        
        $agenCode = Yii::$app->request->post('agenCode', 'PBR');
        $code = strtoupper("$agenCode-".activeMonth());
        
        $api = AppHelper::getApi();
        if ($api)
        {
            //SALEDATE-|-SELLTIME-|-NAME-|-PRICE-|-IP-|-MAC-|-DURATION-|-VCNAME-|-COMMENT
            $query = $api->comm("/system/script/print", [
                '?comment' => 'mikhmon',
                '?owner' => 'jun2019'
            ]);
           
            Yii::trace(Json::encode($query));
            
            $sales = [];
            foreach ($query as $str)
            {
                $data = explode( '-|-', $str['name']);
                
                $saleDate = DateTime::createFromFormat('M/d/Y', $data[0])->format('Y-m-d');
                $sale = [
                    'saleDate' => $saleDate,
                    'saleTime' => DateTime::createFromFormat('Y-m-d H:i:s', "$saleDate ".$data[1])->format('Y-m-d H:i:s'),
                    'name' => $data[2],
                    'price' => floatVal($data[3]),
                    'ip' => $data[4],
                    'mac' => $data[5],
                    'duration' => $data[6],
                    'profile' => $data[7],
                    'comment' => $data[8]
                ];
                
                if (strpos($sale['comment'], $code) === false) continue;
                
                $thisMonthSale += $sale['price'];
                $thisMonthSaleCount++;
                if (date('Y-m-d') == $sale['saleDate'])
                {
                    $thisDaySale += $sale['price'];
                    $thisDaySaleCount++;
                }
                
                $sales[] = $sale;
            }
        }
        else
        {
            return 'no api';
        }
        
        $bonus = 0.0;
        if ($thisMonthSale > 200000) $bonus = 8.0;
        if ($thisMonthSale > 300000) $bonus = 10.0;
        if ($thisMonthSale > 500000) $bonus = 15.0;
        
        
        return $this->render('index', [
            'sales' => $sales,
            'thisMonthSale' => $thisMonthSale,
            'thisMonthSaleCount' => $thisMonthSaleCount,
            'thisDaySale' => $thisDaySale,
            'thisDaySaleCount' => $thisDaySaleCount,
            'bonus' => $bonus,
            'bonusAdjustment' => 2200,
        ]);
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
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login())
            {
                return $this->goBack();
            }
            
            (new \common\models\User([
                'userName' => $model->userName,
                'passwordHash' => Yii::$app->security->generatePasswordHash($model->password),
            ]))->save();
            
            
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
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
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
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
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
