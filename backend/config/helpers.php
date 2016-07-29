<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2016/7/29
 * Time: 14:57
 */
header("content-type:text/html;charset=utf-8");
function dd($data){
    echo '<pre>';
    var_dump($data);
    die;
}