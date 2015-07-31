<?php

namespace app\modules\api\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "op_api_apply".
 *
 * @property integer $id
 */
class Stats extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'op_api_stat';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    		[['secret_key', 'access_num','stat_time','create_time'], 'required'],
    	];
    }

     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	
    }
}