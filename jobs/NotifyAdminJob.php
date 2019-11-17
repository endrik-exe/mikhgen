<?php

namespace app\jobs;

use app\components\AppJob;
use app\models\DashboardOverview;
use app\models\Outbox;
use app\models\User;

class NotifyAdminJob extends AppJob
{
    public function onExecute()
    {
        $model = new DashboardOverview();
        
        //ACTUALL LOAD POST DATA
        $model->year = intval(date('Y'));
        $model->month = intval(date('m'));
        
        $model->getSales();
        
        $smsText = "Penjualan hari ini $model->thisDaySaleCount VCR Rp. $model->thisDaySaleAmount
Pengguna aktif : ".count($model->activeUsers)." users";
        
        echo $smsText;
        
        $dstUser = User::findOne(['roleId' => 1]);
        $dstNumber = $dstUser->handphone;
        
        $outbox = new Outbox([
            'DestinationNumber' => $dstNumber,
            'TextDecoded' => $smsText,
            'CreatorID' => $dstUser->userName
        ]);

        if (!$outbox->save())
        {
            foreach ($outbox->errors as $error)
            {
                if (is_array($error))
                {
                    foreach ($error as $msg)
                    {
                        echo "\n$msg";
                    }
                } else
                {
                    echo "\n$error";
                }
            }
            return self::STATUS_FAILED;
        }
        
        return self::STATUS_OK;
    }
}