<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;


/**
 * Created by PhpStorm.
 * User: mike
 * Date: 27/06/16
 * Time: 12:20
 */

use yii\web\AssetBundle;


class YiiFormAsset extends AssetBundle
{
	public $sourcePath = '@bower';
	
	public $js = [
		'js/yii.activeForm.js',
//        'datatables.net-bs/js/jquery.dataTables.min.js',
        'js/yii.captcha.js',
        'js/yii.gridView.js',
        'js/yii.js',
        'js/yii.validation.js',


	];
	public $depends = [
		'yii\web\JqueryAsset'
	];
}