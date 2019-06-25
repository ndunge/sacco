<?php

namespace common\models;

use Yii;

class SupportCRM extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CUEA$Customer Relationship';
    }

    public function getCategorylabel() {
    	return $this->hasOne(Categorylabel::className(), [ 'CategoryID' => 'CategoryID' ]);
    }

    public function getResolutions() {
        return $this->hasMany(Customeresolutions::className(), [ 'CaseID' => 'CaseID' ]);
    }
}