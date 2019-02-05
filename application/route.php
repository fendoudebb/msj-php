<?php

use think\Route;

Route::get('/404', 'index/RouterNotFound/routerNotFound', ['ext' => 'html']);

Route::any('/admin/insert/batch', 'admin/BatchInsert/batchInsert', ['method' => 'get|post']);

Route::post('/admin/login', 'admin/Login/login');

Route::post('/admin/statistics', 'admin/Statistics/statistics');

//---Topic api start---
Route::post('/admin/topic', 'admin/Topic/topicList');
Route::post('/admin/topic/add', 'admin/TopicAdd/addTopic');
Route::post('/admin/topic/modify/sort', 'admin/TopicModifySort/modifyTopicSort');
Route::post('/admin/topic/modify/name', 'admin/TopicModifyName/modifyTopicName');
Route::post('/admin/topic/modify/parent', 'admin/TopicModifyParent/modifyTopicParent');
//---Topic api end---


//---Post api start---
Route::post('/admin/post', 'admin/Post/postList');
Route::post('/admin/post/topic', 'admin/PostTopic/postTopic');
Route::post('/admin/post/topic/add', 'admin/PostTopicAdd/addPostTopic');
Route::post('/admin/post/topic/delete', 'admin/PostTopicDelete/deletePostTopic');
Route::post('/admin/post/comment', 'admin/PostComment/postComment');
Route::post('/admin/post/comment/switch', 'admin/PostCommentSwitch/switchPostComment');
//---Post api end---

Route::get('/', 'index/Index/index');
Route::get('/post/:postId', 'index/Post/post', ['ext' => 'html'], ['postId' => '\d+']);
Route::get('/example/js_control', 'index/Example/jsControl', ['ext' => 'html']);
Route::get('/tool/json/format', 'index/Tool/formatJson', ['ext' => 'html']);

return [

];
