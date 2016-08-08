<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "attribute".
 *
 * @property integer $id
 * @property string $attr_name
 * @property integer $attr_type
 * @property string $attr_value
 * @property integer $type_id
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_type', 'type_id'], 'required'],
            [['attr_type', 'type_id'], 'integer'],
            [['attr_name', 'attr_value'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attr_name' => 'Attr Name',
            'attr_type' => 'Attr Type',
            'attr_value' => 'Attr Value',
            'type_id' => 'Type ID',
        ];
    }

    public function getType(){
        return $this->hasOne(Type::className(), ['id'=>'type_id']);
    }

    public function findAddGoodsAttrData($ids){
        $query = new Query();

        return $data = $query->select('a.id, a.attr_name, a.attr_type, a.attr_value value')->from('attribute a')->where(['id'=>$ids])->all();

    }
}
