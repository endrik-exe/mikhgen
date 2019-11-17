<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $action
 * @property string $nextRunTime
 * @property string $expectedLastRunTime
 * @property string $lastRunTime
 * @property string $lastRunStatus
 * @property int $repeatEvery
 * @property int $isEnabled
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'repeatEvery', 'isEnabled'], 'integer'],
            [['nextRunTime', 'expectedLastRunTime', 'lastRunTime'], 'safe'],
            [['name', 'action', 'lastRunStatus'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'action' => 'Action',
            'nextRunTime' => 'Next Run Time',
            'expectedLastRunTime' => 'Expected Last Run Time',
            'lastRunTime' => 'Last Run Time',
            'lastRunStatus' => 'Last Run Status',
            'repeatEvery' => 'Repeat Every',
            'isEnabled' => 'Is Enabled',
        ];
    }
    
    public function execute()
    {
        $className = "\app\jobs\\".$this->name;
        
        echo "\nTrying to find $className";
        
        if (class_exists($className))
        {
            echo "\nClass exist, creating instance of $className";
            $appJob = new $className();
            
            //STAMP IT
            $this->expectedLastRunTime = $this->nextRunTime;
            $this->lastRunTime = date('Y-m-d H:i:s');
            
            //ACTUALLY EXECUTE THE JOB
            $this->lastRunStatus = $appJob->onExecute();
            
            if ($this->lastRunStatus == \app\components\AppJob::STATUS_OK_DELAYED)
            {
                $this->nextRunTime = date('Y-m-d H:i:s', strtotime("$this->lastRunTime +$appJob->delayedSeconds seconds"));
            } else {
                $this->nextRunTime = date('Y-m-d H:i:s', strtotime("$this->lastRunTime +$this->repeatEvery seconds"));
            }
            
            $this->save();
        } else
        {
            echo "\n$className Doesn't exist";
        }
    }
}
