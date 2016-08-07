<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_number".
 *
 * @property string $id
 * @property string $goods_id
 * @property string $goods_attr_id
 * @property integer $number
 */
class GoodsNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'goods_attr_id', 'number'], 'required'],
            [['goods_id', 'number'], 'integer'],
            [['goods_attr_id'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'goods_attr_id' => 'Goods Attr ID',
            'number' => 'Number',
        ];
    }

    public function deleteGoodsNumber($goods_id){
        $con = Yii::$app->db;

        $sql = "DELETE FROM `goods_number` WHERE `goods_id`=$goods_id";

        $con->createCommand($sql)->execute();
    }
}
