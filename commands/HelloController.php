<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Job;
use app\models\Outbox;
use app\models\Sales;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
    
    public function actionTest()
    {
        $job = new \app\jobs\NotifyVcStock();
        
        $job->onExecute();
        
        return ExitCode::OK;
    }
    
    public function actionBatchJob()
    {
        $jobs = Job::findAll(['isEnabled' => 1]);
        
        foreach ($jobs as $job)
        {
            if (!$job->lastRunTime || strtotime($job->nextRunTime) <= strtotime('now'))
            {
                echo "\nTry to execute $job->name";
                $job->execute();
            }
        }
        
        return ExitCode::OK;
    }
}
