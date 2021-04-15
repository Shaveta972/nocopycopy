<?php

namespace app\widgets;

use yii\base\Widget;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use app\models\Category;
use yii\helpers\ArrayHelper;

class NavbarMenu extends Widget {
	public function run() {
		
		$preMenus = [];
		
		$catgoryMenus = $this->getCategoryMenu();
			
		$postMenus = [
				[
						'label'=>'Contact',
						'url'=>['site/contact']
				],
				[
						'label'=>'About',
						'url'=>['site/about']
				]
		];
		
		$finalMenu = ArrayHelper::merge($preMenus, $catgoryMenus);
		
		$finalMenu = ArrayHelper::merge($finalMenu, $postMenus);
		
		$result = Menu::widget ( [
				'encodeLabels' => false,
				'activateItems' => true,
				'activateParents' => true,
				'options' => [
						'class' => 'nav navbar-nav navbar-right',
						'data-widget' => 'tree'
				],
				'items' => $finalMenu,
		] );
		
		return $result;
	}
	
	public function getCategoryMenu(){
		
		$categories = Category::find()->all();
		
		$menus = [];
		
		if($categories){
			foreach ($categories as $category){
				$menus[] = [
					'label'=>$category->title,
					'url' => ['plan/index','category'=>$category->slug]
				];
			}
		}
		return $menus;
	}
	
}