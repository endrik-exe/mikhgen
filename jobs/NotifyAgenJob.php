<?php

namespace app\jobs;

use app\components\AppJob;
use app\models\Outbox;
use app\models\Sales;

class NotifyAgenJob extends AppJob
{
    public function onExecute()
    {
        Sales::getSalesWith(NULL, null, null, Sales::SOURCE_API);
        
        $models = Sales::find()
            ->where("smsSentDate IS NULL AND saleDate > NOW() - INTERVAL 120 MINUTE")
            ->orderBy("saleDate ASC")
            //->limit(1)
            ->all();
        
        foreach ($models as $model)
        {
            if ($model && $model->agen && $model->agen->handphone)
            {
                $smsText = "$model->name - $model->agenCode - $model->profileAlias"
                        . "\nRp. $model->price"
                        . "\nAktif pada ".date('d/M H:i', strtotime($model->saleDate));
                
                $outbox = new Outbox([
                    'DestinationNumber' => $model->agen->handphone,
                    'TextDecoded' => $smsText,
                    'CreatorID' => $model->id
                ]);
                
                if ($outbox->save())
                {
                    $model->smsSentDate = date('Y-m-d H:i:s');
                    $model->save();
                }
            }
        }
        
        return self::STATUS_OK;
    }
}