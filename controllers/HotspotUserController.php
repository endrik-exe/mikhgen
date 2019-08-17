<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\HotspotUser;
use app\models\User;
use Yii;
use function referrer;

/**
 * Site controller
 */
class HotspotUserController extends MainController
{
    /**
     * Displays list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new HotspotUser();
        
        return $this->render('index', [
            'model' => $model,
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
        $model = HotspotUser::getUsers(['?.id' => $id]);
        if (count($model) > 0) $model = $model[0];
        
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
        $users = HotspotUser::getUsers([
            '?comment' => 'vc.|.NEW.|.V2H.|.2019-08-16 00:13:33.|.x1.|.q100'
        ]);
        
        /*return $this->asJson(array_map(function($x){
            return $x->profile;
        }, $users));
        return $this->asJson($users);*/
        
        return $this->renderPartial('print', [
            'dnsName' => 'nking.net',
            'hotspotName' => 'nKing',
            'template' => 'big',
            'users' => $users,
        ]);
    }
}
