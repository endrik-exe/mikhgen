<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bonusadjustment".
 *
 * @property int $userId
 * @property int $year
 * @property int $month
 * @property double $value
 */
class BonusAdjustment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonusadjustment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agenCode', 'year', 'month'], 'required'],
            [['year', 'month'], 'integer'],
            [['agenCode'], 'string', 'max' => 45],
            [['value'], 'number'],
            [['agenCode', 'year', 'month'], 'unique', 'targetAttribute' => ['agenCode', 'year', 'month']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'year' => 'Year',
            'month' => 'Month',
            'value' => 'Value',
        ];
    }
    
    public static function adjust($agenCode, $year, $month, $value) 
    {
        $bonus = self::findOne(['agenCode' => $agenCode, 'year' => $year, 'month' => $month]);
        
        if (!$bonus) $bonus = new BonusAdjustment ([
            'agenCode' => $agenCode,
            'year' => $year,
            'month' => $month,
        ]);
                
        $bonus->value = $value;
        
        $bonus->save();
    }
    
    public static function get($agenCode, $year, $month)
    {
        $bonus = self::findOne(['agenCode' => $agenCode, 'year' => $year, 'month' => $month]);
        
        if ($bonus) return $bonus->value;
        
        return 0;
    }
}
