<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "goods_attr".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $attr_id
 * @property string $attr_value
 * @property string $attr_price
 */
class GoodsAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'attr_id', 'attr_value'], 'required'],
            [['goods_id', 'attr_id'], 'integer'],
            [['attr_price'], 'number'],
            [['attr_value'], 'string', 'max' => 20],
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
            'attr_id' => 'Attr ID',
            'attr_value' => 'Attr Value',
            'attr_price' => 'Attr Price',
        ];
    }

    public function add_goods_attr($ga, $gp, $id){
        $con = Yii::$app->db;

        foreach($ga as $k=>$v){

            foreach($v as $k1=>$v1){
                if(empty($v1)){

                    continue;
                }
                $price = isset($gp[$k][$k1])?$gp[$k][$k1]:'0.00';
                if($price)
                $sql = "INSERT INTO `goods_attr` values (null, $id, $k, '{$v1}', $price)";
                else
                $sql = "INSERT INTO `goods_attr` (id, goods_id, attr_id, attr_value) values (null, $id, $k, '{$v1}')";

                $con->createCommand($sql)->execute();
            }


        }
    }

    public function get_goods_attr($id){
        $query = new Query();

        $_data = $query->select('a.*, b.attr_name, b.attr_value as value, b.attr_type')
            ->from('goods_attr a')
            ->leftJoin('attribute b', 'b.id=a.attr_id')
            ->where('a.goods_id=:goods_id', [':goods_id'=>$id])
            ->all();
        $data = [];
        //将该数组以相同属性id为健值,构筑新的二维数组
        foreach($_data as $k=>$v){
            $data[$v['attr_id']][] = $v;
        }

        return $data;
    }

    public function getGoodsAttrIds($goods_id){
        $query = new Query();
        return $data =    $query->select('a.id')
                                ->from('goods_attr a')
                                ->where('a.goods_id=:goods_id', [':goods_id'=>$goods_id])
                                ->all();
    }

    public function deleteGoodsAttrIds($ids){
        $con = Yii::$app->db;

        $ids = implode(',', $ids);

        $sql = "DELETE FROM `goods_attr` WHERE id in ($ids)";

        $con->createCommand($sql)->execute();
    }

    public function updateGoodsAttr($gas, $gps, $goods_id){

        $con = Yii::$app->db;
        foreach($gas as $k=>$v){

            foreach($v as $k1=>$v1){
               if(empty($v1)){
                  continue;
               }

                $price = isset($gps[$k][$k1])?$gps[$k][$k1]:'0.00';

                $sql = "UPDATE `goods_attr` SET attr_value='$v1',attr_price='$price' WHERE id=$k";


                $con->createCommand($sql)->execute();

            }

        }
    }

    public function deleteGoodsAttrs($goods_id){
        $con = Yii::$app->db;

        $sql = "DELETE FROM `goods_attr` WHERE `goods_id`=$goods_id";

        $con->createCommand($sql)->execute();
    }
}
