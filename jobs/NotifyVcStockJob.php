<?php

namespace app\jobs;

use app\components\AppJob;
use app\models\HotspotUser;
use app\models\Outbox;
use app\models\User;
use app\models\Voucher;

class NotifyVcStockJob extends AppJob
{
    public function onExecute()
    {
        $users = User::findAll(['roleId' => 2]);
        $vcProfiles = Voucher::getVoucher();
        $searchModel = new HotspotUser();
        
        $smsTexts = ["Peringatan stk vc\n"];
        $urgentLevel = 0;
        
        $i = 0;
        foreach ($users as $user)
        {
            foreach ($vcProfiles as $profile)
            {
                $searchModel->profileName = $profile->name;
                $searchModel->agenCode = $user->agenCode;
                
                $hsUserCount = count($searchModel->search());
                if ($hsUserCount < 9)
                {
                    $appendText = "$searchModel->agenCode $searchModel->profileName, sisa $hsUserCount vcr;\n";
                    
                    if (strlen($smsTexts[$i]) + strlen($appendText) > 153)
                    {
                        $i++;
                        $smsTexts[] = "";
                    }
                    
                    $smsTexts[$i] .= $appendText;
                    $urgentLevel++;
                }
            }
        }
        
        if ($urgentLevel > 5)
        {
            $dstUser = User::findOne(['roleId' => 1]);
            $dstNumber = $dstUser->handphone;
            
            foreach ($smsTexts as $smsText)
            {
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
            }
            
            if ($urgentLevel >= 8) $this->delayedSeconds = 60 * 60 * 15;//delayed 15 hours for next run time
            else $this->delayedSeconds = 60 * 60 * 48;//delayed 2 days (48 h) for next run time
            
            return self::STATUS_OK_DELAYED;
        }
        
        return self::STATUS_OK;
    }
}