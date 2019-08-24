<?php
namespace app\controllers;

use app\controllers\MainController;
use app\models\Sales;

/**
 * Site controller
 */
class SmsController extends MainController
{
    
    public function beforeAction($action) {
        
        if ($action->id == 'pending') $this->allowGuest = true;
        
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        
    }
    
    public function actionPending()
    {
        Sales::getSalesWith(NULL, null, null, Sales::SOURCE_API);
        
        $model = Sales::find()
            ->where("smsSentDate IS NULL AND saleDate > NOW() - INTERVAL 120 MINUTE")
            ->orderBy("saleDate ASC")
            ->one();
        
        //return $this->asJson($model->agen);
        
        //return "pending.|.085778231463.|.Test sms gateway, kirim otomatis jam:".date('H:i');
        
        if ($model && $model->agen && $model->agen->handphone)
        {
            $model->smsSentDate = date('Y-m-d H:i:s');
            $model->save();
            
            return "pending.|.{$model->agen->handphone}.|.$model->name - $model->agenCode - $model->profileAlias"
                ." Rp. $model->price"
                ."  Aktif pada ".date('d/M H:i', strtotime($model->saleDate));
        }
        
        return "";
    }
}
