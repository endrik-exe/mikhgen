<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\User;
use app\models\Voucher;
use Yii;
use function referrer;

/**
 * Site controller
 */
class VoucherController extends MainController
{
    /**
     * Displays list.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //return $this->asJson(Voucher::getVoucher());
        
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
        $model = Voucher::getVoucher($id);
        
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
}
