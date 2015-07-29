<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "op_api_apply".
 *
 * @property integer $id
 */
class Apply extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'op_api_apply';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    		[['uid', 'aid','rate'], 'required'],
    	];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
    	return array_merge(parent::attributes(), ['api_name', 'type', 'api_url']);
    }
}