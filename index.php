<?php
error_reporting(E_ALL ^ E_NOTICE);
require './vendor/autoload.php';

use QL\QueryList;

$url = "http://www.wenzhangba.com/qingganwenzhang";
$rule = [
    'title' => ['.subBox strong a','text'],
    'url'   => ['.subBox strong a','href']
];

$list = craw_data($url,$rule);
// dd($list);
foreach ($list as $key => $value) {
    $html = $value['url'];
    $detail = QueryList::Query($html,array(
            'content' => array('.a_detail','html','a')
        ))->getData(function($item){
            $item['content'] = QueryList::run('DImage',[
                'content' => $item['content'],
                'image_path' => 'images/'.date('Y-m-d'),
                'www_root' => dirname(__FILE__)
            ]);
            return $item;
        });

    $data['title'] = $list[$key]['title'];
    $data['content'] = $detail[0]['content'];
    echo "<pre>";
    print_r($data);
}

function craw_data($url,$rule) {
    ##解决乱码问题
    // $data = QueryList::Query($url,$rule,'','UTF-8','GB2312')->data;
    $data = QueryList::Query($url,$rule)->data;
    return $data;
}


