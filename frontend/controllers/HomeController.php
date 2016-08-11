<?php
	/**
	 * Created by PhpStorm.
	 * User: wc
	 * Date: 16/8/9
	 * Time: 下午9:46
	 */
namespace frontend\controllers;

use yii\rest\Controller;

class HomeController extends Controller
{
	public function setPageInfo($title, $description, $keywords, $css=array(), $js=array(), $showNav=1){

		return array(
				'page_title'            => $title,
				'page_keywords'         => $keywords,
				'page_description'      => $description,
				'show_nav'              => $showNav,
				'page_css'              => $css,
				'page_js'               => $js
		);
	}
}