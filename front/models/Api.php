<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "op_api".
 *
 * @property integer $id
 */
class Api extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'op_api';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
       
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	
    }
}