<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $goods_name
 * @property integer $cat_id
 * @property string $shop_price
 * @property string $market_price
 * @property integer $is_promote
 * @property string $promote_price
 * @property integer $promote_start_time
 * @property integer $promote_end_time
 * @property integer $is_delete
 * @property integer $is_on_sale
 * @property integer $is_hot
 * @property integer $is_new
 * @property integer $is_best
 * @property integer $type_id
 * @property string $logo
 * @property string $sm_logo
 * @property integer $addtime
 * @property string $goods_desc
 */
class Goods extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_name', 'cat_id', 'shop_price', 'market_price', 'goods_desc'], 'required'],
            [['cat_id', 'is_promote', 'promote_start_time', 'promote_end_time', 'is_delete', 'is_on_sale', 'is_hot', 'is_new', 'is_best', 'type_id', 'addtime'], 'integer'],
            [['shop_price', 'market_price', 'promote_price'], 'number'],
            [['goods_desc'], 'string'],
            [['goods_name'], 'string', 'max' => 20],
            [['logo'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_name' => '商品名称',
            'cat_id' => '所属分类',
            'shop_price' => '本店价',
            'market_price' => '市场',
            'is_promote' => '是否促销',
            'promote_price' => '促销价',
            'promote_start_time' => '促销起始时间',
            'promote_end_time' => '促销结束时间',
            'is_delete' => '是否放入回收站',
            'is_on_sale' => '是否上架',
            'is_hot' => '是否热卖',
            'is_new' => '是否新品',
            'is_best' => '是否精品',
            'type_id' => '所属类型',
            'logo' => '商品图片',
            'sm_logo' => '略缩图片',
            'goods_desc' => '商品描述',
        ];
    }

    public function getCategory(){

        return Category::find()->where(['id'=>$this->cat_id])->one();
    }

    public function getId(){
        return $this->id;
    }
    public function deleteGoodsLogo($goods_id){
        $images = Goods::find()->where('id=:id', [':id'=>$goods_id])->asArray()->one();
        deleteImage($images['logo'], $images['sm_logo']);
        $con = Yii::$app->db;
        $sql = "DELETE FROM `goods_pics` WHERE `goods_id`=$goods_id";
        $con->createCommand($sql)->execute();
    }


    public function get_crazy_data(){
        $time = time();

        //取出促销结束时间大于当前时间的商品
        return $data = Goods::find()->where('promote_end_time>:time',[':time'=>$time])->asArray()->all();
    }
}
