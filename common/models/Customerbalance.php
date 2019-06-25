<?php

namespace common\models;

use Yii;

class Customerbalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CUEA$CustomerBalances';
    }
	
	public static function primaryKey()
     {
      return array('CustomerID');
      // For composite primary key, return an array like the following
      // return array('pk1', 'pk2');
     }
}