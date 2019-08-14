<?php
namespace app\models;

use app\components\AppHelper;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use function minifyRos;
use function str_replaces;

/**
 * Used to generate voucher
 *
 * @property string $profile
 * @property string $server
 * @property string $agen
 * @property integer $qty
 * @property string $vcAlias
 */
class VoucherFactory extends Voucher
{
    public $profile;
    public $server;
    public $agenCode;
    public $qty = 1;
    public $vcAlias = '';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['profile', 'server', 'agenCode'], 'string', 'max' => 45],
            [['qty'], 'integer'],
        ]);
    }
    
    public function generate()
    {
        $allNames = array_map(function($x) { return $x->name; }, HotspotUser::getUsers());
        
        $timestamp = date('Y-m-d H:i:s');
        $comment = "vc.|.$this->agenCode.|.$this->vcAlias.|.$timestamp.|.x1.|.q$this->qty";
                
        //vc.|.AGEN.|.VC_ALIAS.|.TIMESTAMP.|.xMONTH_GEN_COUNT.|.qGEN_QTY
        //vc.|.PBR.|.V2H.|.2019-07-20 12:06:32.|.x1.|.q27
        
        $generated = [];
        for($i = 0; $i < $this->qty; $i++)
        {
            $newName = random(4, RAND_ALPHA).random(4, RAND_NUMERIC);
            while (in_array($newName, $allNames)) $newName = random(4, RAND_ALPHA).random(4, RAND_NUMERIC);
            
            $newUser = new HotspotUser([
                'server' => $this->server,
                'profile' => $this->profile,
                'name' => $newName,
                'password' => $newName,
                'comment' => $comment,
            ]);
            
            //$newUser->save();
            
            $generated[] = $newUser;
        }
        
        return $generated;
    }
}
