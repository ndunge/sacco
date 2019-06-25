<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Statement';
$this->params['breadcrumbs'][] = $this->title;
$Total = 0;
if (!empty($dataProvider->getModels())) 
{
 foreach ($dataProvider->getModels() as $key => $val) 
 {
  $Total += $val['Amount'];
    }
}
$Total = number_format($Total,2);
?>
<div class="custledgerentry-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php// print_r($dataProvider); ?>
	<?php// print_r($dataProvider); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'showOnEmpty' => false,
		'showFooter' => true,
		//'footerOptions' => ['style' => 'text-align:right; font-weight:bold'],
		'layout' => '{items}',
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'Date:date',
			
			
			'Description',
			[
				'label' => 'Amount',
				'attribute' => 'Amount',
				//'headerOptions' => ['width' => '15%','style'=>'color:black; text-align:right'],
				'format' => ['decimal', 2],
				'contentOptions' => ['style' => 'text-align: right;'],
				'footer'=>$Total,
                'footerOptions'=>['style' => 'text-align: right; width:15%'],
				
			],
		],
		
		//'footer' => $Total,
   

		'tableOptions' => [
			'class' => 'dataTable striped border hovered bordered',
			'data-role' => 'datatable',
			'data-searching' => 'true',
			'data-paging' => 'true',
			'data-ordering' => 'false',
			'data-info' => 'true'
		],
		'pager' => [
			'maxButtonCount' => 10,

			// Customzing options for pager container tag
			'options' => [
				'class' => 'pagination'
			],

			// Customzing CSS class for pager link
			'activePageCssClass' => 'item current',
			'disabledPageCssClass' => 'item disabled',
			'pageCssClass' => 'item',

			// Customzing CSS class for navigating link
			'prevPageCssClass' => 'item',
			'nextPageCssClass' => 'item',
			'firstPageCssClass' => 'item',
			'lastPageCssClass' => 'item'
		],
		
		
		

	]); ?>
	<div class="pure-u-1"></div>
</div>
