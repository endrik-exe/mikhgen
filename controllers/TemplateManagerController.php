<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\HotspotUser;
use app\models\Template;
use app\models\User;
use Yii;
use function referrer;

/**
 * Site controller
 */
class TemplateManagerController extends MainController
{
    /**
     * Displays list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //return $this->asJson(Template::getTemplates());
        
        return $this->render('index', [
            
        ]);
    }
    
    public function actionCreate()
    {
        $model = new User();
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(referrer());
            }
            
            Yii::trace($model->errors);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = User::findOne($id);
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(referrer());
            }
            
            Yii::trace($model->errors);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionToggleActive($id)
    {
        $model = User::findOne($id);
        $model->isActive = !$model->isActive;
        
        if ($model->save())
        {
            //PRINT SOMETHING
        } else
        {
            //PRINT SOMETHING
            Yii::trace($model->errors);
        }
        
        return $this->redirect(referrer());
    }
    
    public function actionPrint()
    {
        $users = [];
        
        for ($i = 0; $i < 5; $i++)
        {
            $users[] = new HotspotUser([
                'userName' => 'UserName',
                'password' => 'Password',
                'comment' => 'comment',
                'profileId' => 'id',
                'profileName' => 'V1H',
                'profileAlias' => 'V1H',
                'price' => 5000,
                'uptime' => '1d',
            ]);
        }
        
        return $this->renderPartial('print', [
            'dnsName' => 'nking.net',
            'hotspotName' => 'nKing',
            'profile' => 'profile',
            'id' => 'id',
            'template' => 'big',
            'users' => $users,
        ]);
    }
}
