<?php
if (!defined('BASEDIR')) {
    exit('File not found');
}

// 所有路由都在这里配置

// 任务api
$app->get('/admin', ['as' => 'task_index', 'uses' => 'App\Controller\Admin\IndexController@index']);
$app->get('/admin/post', ['as' => 'post', 'uses' => 'App\Controller\Admin\PostController@index']);
$app->get('/admin/post_add', ['as' => 'post_add', 'uses' => 'App\Controller\Admin\PostController@add']);
$app->post('/admin/post_add_data', ['as' => 'post_add_data', 'uses' => 'App\Controller\Admin\PostController@addData']);

$app->get('/admin/media', ['as' => 'task_index', 'uses' => 'App\Controller\Admin\MediaController@index']);
$app->get('/admin/media_upload', ['as' => 'task_index', 'uses' => 'App\Controller\Admin\MediaController@mediaUpload']);
$app->post('/admin/media_upload_file', ['as' => '', 'uses' => 'App\Controller\Admin\MediaController@upload']);

$app->get('/admin/login', ['as' => 'login_index', 'uses' => 'App\Controller\Admin\PublicController@login']);
$app->post('/admin/check_login', ['as' => 'check_login', 'uses' => 'App\Controller\Admin\PublicController@checkLogin']);