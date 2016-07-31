<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $cat_name
 * @property integer $p_id
 */
class Category extends \yii\db\ActiveRecord
{
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name', 'p_id'], 'required'],
            ['cat_name', 'unique', 'class'=>'\backend\models\Category', 'on'=>'create'],
            [['p_id'], 'integer'],
//            ['p_id', function($attribute, $params){
//                if(in_array($this->attribute, $this->findChildren($this->attribute))){
//                    $this->addError($attribute, '不能将自己设为自己的子类');
//                }
//            }],
            [['cat_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => '类型名',
            'p_id' => '父级分类',
        ];
    }


    public function getTree(){
        $data = Category::find()->asArray()->all();

        $res =  $this->_getTree($data);

        return $res;
    }
    public function _getTree($data, $p_id = 0, $level = 0){
       static $res = array();

        foreach($data as $k=>$v){

            if($v['p_id'] == $p_id){
               $v['level'] = $level;
                $res[] = $v;
                $this->_getTree($data, $v['id'], $level+1);
            }
        }
        return $res;
    }


    public function scenarios(){
        $sescenarios =  [
            self::SCENARIOS_CREATE => ['cat_name', 'p_id'],
            self::SCENARIOS_UPDATE => ['cat_name', 'p_id'],
        ];

        return array_merge(parent::scenarios(),$sescenarios);

    }




    public function findChildren($id){
        $data = $data = Category::find()->asArray()->all();
        $res = $this->_findChildren($data, $id);
        return array_merge($res, array($id));
    }
    //找到某个分类下的子分类
    public function _findChildren($data, $id){

        static $res = [];
        foreach($data as $v){
            if($v['p_id'] == $id){
                $res[] = $v['id'];
                $this->_findChildren($data, $v['id']);
            }
        }
        return $res;
    }
}
