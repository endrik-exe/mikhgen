<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outbox".
 *
 * @property string $UpdatedInDB
 * @property string $InsertIntoDB
 * @property string $SendingDateTime
 * @property string $SendBefore
 * @property string $SendAfter
 * @property string $Text
 * @property string $DestinationNumber
 * @property string $Coding
 * @property string $UDH
 * @property int $Class
 * @property string $TextDecoded
 * @property string $ID
 * @property string $MultiPart
 * @property int $RelativeValidity
 * @property string $SenderID
 * @property string $SendingTimeOut
 * @property string $DeliveryReport
 * @property string $CreatorID
 * @property int $Retries
 * @property int $Priority
 * @property string $Status
 * @property int $StatusCode
 */
class Outbox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbox';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->dbsms;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UpdatedInDB', 'InsertIntoDB', 'SendingDateTime', 'SendBefore', 'SendAfter', 'SendingTimeOut'], 'safe'],
            [['Text', 'Coding', 'UDH', 'TextDecoded', 'MultiPart', 'DeliveryReport', 'CreatorID', 'Status'], 'string'],
            [['Class', 'RelativeValidity', 'Retries', 'Priority', 'StatusCode'], 'integer'],
            [['TextDecoded', 'CreatorID'], 'required'],
            [['DestinationNumber'], 'string', 'max' => 20],
            [['SenderID'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UpdatedInDB' => 'Updated In Db',
            'InsertIntoDB' => 'Insert Into Db',
            'SendingDateTime' => 'Sending Date Time',
            'SendBefore' => 'Send Before',
            'SendAfter' => 'Send After',
            'Text' => 'Text',
            'DestinationNumber' => 'Destination Number',
            'Coding' => 'Coding',
            'UDH' => 'Udh',
            'Class' => 'Class',
            'TextDecoded' => 'Text Decoded',
            'ID' => 'ID',
            'MultiPart' => 'Multi Part',
            'RelativeValidity' => 'Relative Validity',
            'SenderID' => 'Sender ID',
            'SendingTimeOut' => 'Sending Time Out',
            'DeliveryReport' => 'Delivery Report',
            'CreatorID' => 'Creator ID',
            'Retries' => 'Retries',
            'Priority' => 'Priority',
            'Status' => 'Status',
            'StatusCode' => 'Status Code',
        ];
    }
}
