<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "member_price".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $level_id
 * @property string $price
 */
class MemberPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_price';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['price'], 'required'],
//            [['goods_id', 'level_id'], 'integer'],
//            [['price'], 'number'],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'level_id' => 'Level ID',
            'price' => 'Price',
        ];
    }


    public function add_member_price($data, $id){
        $query = Yii::$app->db;
        foreach($data as $k=>$v){
            $query->createCommand("INSERT INTO `member_price` values(null, $id, $k+1, '{$v}')")->execute();
         }
    }

    public function get_member_price($id){
        $query = new Query();
        return $data = $query->select('a.*, b.level_name, b.rate')->from('member_price a')->leftJoin('member_level b', 'b.id=a.level_id')->where('a.goods_id=:goods_id', [':goods_id'=>$id])->all();
    }

    public function deleteGoodsMemberPirce($goods_id){
        $con = Yii::$app->db;

        $sql = "DELETE FROM `member_price` WHERE `goods_id`=$goods_id";

        $con->createCommand($sql)->execute();
    }
}
