<?php 
require './vendor/autoload.php';

use QL\QueryList;

$url = "http://www.lunwenstudy.com/tags/35475.html";
$rule = [
    'title' => ['p.title a','text'],
    'url'   => ['p.title a','href'],
    'desc'  => ['p.miaoshu','text']
];

$list = craw_data($url,$rule);
// dd($list);
foreach ($list as $key => $value) {
	$reg = [
		'content' => ['.neirong_text','html'],
		'author'  => ['.neirong_title span','text']
	];
    $detail = craw_data($value['url'],$reg);

    $data['title'] = $list[$key]['title'];
    $data['desc'] = str_replace("[全文]", "", $list[$key]['desc']);
    $data['content'] = $detail[0]['content'];
    $data['author'] = "未知";
    echo "<pre>";
    print_r($data);
}

function craw_data($url,$rule) {
    ##解决乱码问题
    $data = QueryList::Query($url,$rule,'','UTF-8','GB2312')->data;
    
    return $data;
}
