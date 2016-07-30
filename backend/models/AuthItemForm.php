<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2016/7/29
 * Time: 11:39
 */
namespace backend\models;


use yii\base\Exception;
use yii\db\ActiveRecord;

class AuthItemForm extends ActiveRecord
{
    public $name;

    public $child;

    public $type;

    public $description;

    const T_ROLE = 1;
    const T_POWER = 2;

    //场景
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';
    const SCENARIOS_DELETE = 'delete';

    public static function tableName()
    {
        return 'auth_item';
    }

    public function rules(){
        return [
            [['name', 'type'], 'required'],
            ['name', 'filter', 'filter'=>'trim'],
            ['name', 'unique', 'targetClass' => AuthItem::className(), 'message'=> '此名称已经被占用', 'on'=>self::SCENARIOS_CREATE],
            [['name', 'description'], 'string', 'max'=>255],
        ];
    }

    public function attributeLabels(){
        return [
            'name' => '名称',
            'description' => '描述'
        ];
    }

    public function scenarios(){
        $sescenarios =  [
            self::SCENARIOS_CREATE => ['name', 'type', 'description', 'child'],
            self::SCENARIOS_UPDATE => ['name', 'type', 'description', 'child'],
            self::SCENARIOS_DELETE => ['name']
        ];

        return array_merge(parent::scenarios(),$sescenarios);

    }

    //method of create role or permission
    public function addItem(){
        //角色或者权限名会在实例化这个model的时候load给该model
        $auth = \Yii::$app->authManager;
        //如果添加的是角色
        if($this->type == self::T_ROLE){
           $item = $auth->createRole($this->name);
            $item->description = $this->description?:'创建['.$this->name.']角色';
        }else{
            $item = $auth->createPermission($this->name);
            $item->description = $this->description?:'创建['.$this->name.']权限';

        }
        return $auth->add($item);
    }

    public function getItem($id){
        $model = AuthItem::find()->where(['name'=>$id])->one();
        if($model){
            $this->name = $model->name;
            $this->type = $model->type;
            $this->description = $model->description;
            return $this;
        }else{
            throw new Exception('编辑的角色不存在!');
        }
    }

    public function updateItem($item_name){
        $auth = \Yii::$app->authManager;
        if($this->type == self::T_ROLE){
            $item = $auth->createRole($this->name);
            $item->description = $this->description?:'创建['.$this->name.']角色';
        }else{
            $item = $auth->createPermission($this->name);
            $item->description = $this->description?:'创建['.$this->name.']权限';
        }
        $auth->update($item_name, $item);
    }

    public function removeItem(){
        if($this->validate()){
            $auth = \Yii::$app->authManager;

            $item = $auth->getRole($this->name)?:$auth->getPermission($this->name);

            return $auth->remove($item);

        }
        return false;
    }
}