<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "type".
 *
 * @property integer $id
 * @property string $type_name
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['type_name'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
        ];
    }

    public function getTypeAttribute(){
        return $this->hasMany(Attribute::className(), ['type_id'=>'id']);
    }

    public function getTypeAttributeData($type_id){
        $query = new Query();
        return $data = $query->select('*')->from('attribute')->where('type_id=:type_id',[':type_id'=>$type_id])->all();
    }
}
