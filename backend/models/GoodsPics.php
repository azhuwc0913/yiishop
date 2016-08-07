<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "goods_pics".
 *
 * @property integer $id
 * @property string $pic
 * @property string $sm_pic
 * @property integer $goods_id
 */
class GoodsPics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_pics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'required'],
            [['goods_id'], 'integer'],
            [['pic', 'sm_pic'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pic' => 'Pic',
            'sm_pic' => 'Sm Pic',
            'goods_id' => 'Goods ID',
        ];
    }

    public function add_goods_pic($files, $goods_pic_model, $id){
        $con = Yii::$app->db;
        foreach($files as $file){
         $image = uploadFile($goods_pic_model,[[120,120]], $file) ;
         $sql = "INSERT INTO `goods_pics` values (null, '{$image[0]}', '{$image[1]}', $id)";
         $con->createCommand($sql)->execute();
        }
    }

    public function get_goods_pics($id){
        $query = new Query();
        return $data = $query->select('a.id,a.pic,a.sm_pic')
                                ->from('goods_pics a')
                                ->where('a.goods_id=:goods_id', [':goods_id'=>$id])
                                ->all();
    }

    public function deleteGoodsPics($goods_id){
        $con = Yii::$app->db;
        $sql = "DELETE FROM `goods_pics` WHERE `goods_id`=$goods_id";
        $con->createCommand($sql)->execute();
    }
}
