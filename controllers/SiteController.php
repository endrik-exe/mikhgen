<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\BonusAdjustment;
use app\models\ContactForm;
use app\models\DashboardOverview;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use const YII_ENV_TEST;

/**
 * Site controller
 */
class SiteController extends MainController
{
    
    public function beforeAction($action) {
        
        if ($action->id == 'test') $this->allowGuest = true;
        
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new DashboardOverview();
        
        //ACTUALL LOAD POST DATA
        $model->agenCode = Yii::$app->user->identity->agenCode;
        $model->year = intval(date('Y'));
        $model->month = intval(date('m'));
        
        $model->load(Yii::$app->request->get());
        
        $model->bonusAdjustment = BonusAdjustment::get($model->agenCode, $model->year, $model->month);
        
        if(Yii::$app->request->post('adjust-bonus'))
            BonusAdjustment::adjust ($model->agenCode, $model->year, $model->month,
                Yii::$app->request->post('adjust-bonus'));
        
        if ($model->month == 6) $model->agenCode .= '-JUN';
        
        //return $this->asJson($model->getSales());
        $model->getSales();
        return $this->render('index', [
            'model' => $model,
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
            
            /*(new User([
                'userName' => $model->userName,
                'passwordHash' => Yii::$app->security->generatePasswordHash($model->password),
            ]))->save();*/
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
    
    public function actionActive()
    {
        $model = new DashboardOverview();
        
        return $this->asJson($model->getActiveUsers());
    }
    
    public function actionTest()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://agen.nking.net/site/login");
        curl_setopt($curl, CURLOPT_REFERER, "http://agen.nking.net/site/login");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        /*$csrf = '';
        $response = curl_exec($curl);
        //return $response;
        $dom = new \DomDocument();
        $dom->loadHTML($response);
        $fields = $dom->getElementsByTagName("input");
        
        for ($i = 0; $i < $fields->length; $i++)
        {
            $field = $fields->item($i);
            if($field->getAttribute('name') == '_csrf')
                $csrf = $field->getAttribute('value');
        }
        
        //return $csrf;
        
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'LoginForm[userName]' => 'endrik.exe',
            'LoginForm[password]' => 'murtiofme',
            '_csrf' => $csrf,
        ]);
        
        $response = curl_exec($curl);
        
        if(curl_errno($curl)){
            throw new Exception(curl_error($curl));
        }
        
        return $response;*/
        
        curl_setopt($curl, CURLOPT_URL, 'http://agen.nking.net/site/index');
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
        
        //We don't want any HTTPS / SSL errors.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //Execute the GET request and print out the result.
        return curl_exec($curl);
    }
}
