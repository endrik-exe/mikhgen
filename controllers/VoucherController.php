<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\User;
use app\models\Voucher;
use app\models\VoucherFactory;
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
        //return minifyRos(file_get_contents(Yii::getAlias('@app/ros/onlogin.ros')));
        
        return $this->render('index', [
            
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Voucher();
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(referrer());
            }
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
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionGenerate($id = null)
    {
        $voucherFactory = new VoucherFactory([
            'qty' => 20,
            'agenCode' => 'NEW',
            'profile' => 'V1H-5000',
            'vcAlias' => 'V1H',
        ]);
        
        return $this->asJson($voucherFactory->generate());
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
