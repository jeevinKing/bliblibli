<?php 
error_reporting(E_ALL ^ E_NOTICE);
require './vendor/autoload.php';

use QL\QueryList;

function init() {
	$url = "http://www.szwj72.cn/t/shuqingsanwen/";
	

	$rule = [
		'title' => ['.excerpt header h2 a','text'],
		'url'   => ['.excerpt header h2 a','href'],
		'desc'   => ['.excerpt p.note','text']
	];
	$list_data = craw_data($url,$rule);
	
	$reg = [
	 'content' => array('.article-content','html')
	];
	foreach ($list_data as $key => $value) {
		// $detail = craw_data($value['url'],['content' =>['.article-content','html']]);
		
		$data = QueryList::Query($value['url'],$reg,'.content')->getData(function($item){
		    //图片本地化
		    $item['content'] = QueryList::run('DImage',[
		            'content' => $item['content'],
		            'image_path' => '/img/'.date('Y-m-d'),
		            'www_root' => dirname(__FILE__)
		        ]);
		    return $item;
		});


		// $data['title'] = $list_data[$key]['title'];
		// $data['url'] = $list_data[$key]['url'];
		// $data['desc'] = $list_data[$key]['desc'];
		print_r("<pre>");
		print_r($data);
	}
	
}

	function craw_data($url,$rule) {
		$data = QueryList::Query($url,$rule,'','UTF-8','GB2312')->data;
		return $data;
	}
	$url = "http://web.jobbole.com/category/career/";
	$rule = [
		'title' => ['.archive-title','text'],
		'url'   => ['.archive-title','href']
	];
	$list_data = craw_data($url,$rule);
	print_r("<pre>");
	print_r($data);
	
	// foreach ($list_data as $key => $value) {
	// 	$reg = [
	// 		'content' => ['.article-content','html']
	// 	];
	// 	$data = QueryList::Query($value['url'],$reg,'.content')->getData(function($item){
	// 	    //图片本地化
	// 	    $item['content'] = QueryList::run('DImage',[
	// 	            'content' => $item['content'],
	// 	            'image_path' => '/images/'.date('Y-m-d'),
	// 	            'www_root' => dirname(__FILE__)
	// 	        ]);
	// 	    return $item;
	// 	});
	// 	print_r("<pre>");
	// 	print_r($data);
	// }

	// $url = "http://www.goodmood.cc/life/23551.html";
	// $rule = [
	// 	'content' => ['.article-content','html']
	// ];
	// $data = QueryList::Query($url,$rule,'.content')->getData(function($item){
	//     //图片本地化
	//     $item['content'] = QueryList::run('DImage',[
	//             'content' => $item['content'],
	//             'image_path' => '/images/'.date('Y-m-d'),
	//             'www_root' => dirname(__FILE__)
	//         ]);
	//     return $item;
	// });

// init();

