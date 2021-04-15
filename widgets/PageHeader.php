<?php

namespace app\widgets;

use yii\base\Widget;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

class PageHeader extends Widget {
	public $title;
	public $subtitle;
	public function run() {
		$this->title = Html::encode ( $this->title );
		$this->subtitle = Html::encode ( $this->subtitle );
		$breadCrumb = Breadcrumbs::widget ( [ 
				'homeLink' => [ 
						'label' => Yii::t ( 'app', 'Dashboard' ),
						'url' => Url::to ( [ 
								'/admin/dashboard/' 
						] ) 
				],
				'links' => isset ( \Yii::$app->view->params ['breadcrumbs'] ) ? \Yii::$app->view->params ['breadcrumbs'] : [ ] 
		] );
		
		\Yii::$app->view->beginBlock ( 'pageHeader' );
		echo "<section class='content-header'>
				<h1>
					{$this->title} <small>{$this->subtitle}</small>
				</h1>
				$breadCrumb
			</section>";
		\Yii::$app->view->endBlock ();
	}
}