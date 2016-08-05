<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "member_level".
 *
 * @property integer $id
 * @property string $level_name
 * @property integer $bottom_num
 * @property integer $top_num
 * @property integer $rate
 */
class MemberLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_name', 'bottom_num', 'top_num'], 'required'],
            [['bottom_num', 'top_num', 'rate'], 'integer'],
            [['level_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_name' => '级别名称',
            'bottom_num' => '积分下限',
            'top_num' => '积分上线',
            'rate' => '折扣率',
        ];
    }
}
