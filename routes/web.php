<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Redis;
Route::get('/', function () {
    //$collection = collect(['Desk', 'Sofa', 'Chair']);
    //$intersect = $collection->intersect(['Desk', 'Chair', 'Bookcase']);
    #print_r($intersect);
    return view('welcome');
});

//Route::resource('/post', 'PostController');


//原生的api
/*Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1'], function () {
    Route::resource('lesson', 'LessonController');
});*/

//dingo/api 来写的

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers'], function ($api) {

        /*$api->get('test',function (){
            \App\User::create([
                'name' => 'admin',
                'email' => '2284876299@qq.com',
                'password' => bcrypt(123456)
            ]);

        });*/

        $api->get('lessons', 'LessonController@index');
        $api->get('lessons/{id}', 'LessonController@show');

        $api->post('authenticate','AuthenticateController@authenticate');

    });
});

//api
Route::get('/test','Doc\UserController@index');

Route::group(['namespace' => 'Doc','prefix' => 'swagger'], function () {
    Route::get('json', 'SwaggerController@getJSON');
    Route::get('my-data', 'SwaggerController@getMyData');
});

Route::get('/test2',function (){

    /*$article = \App\Article::find(3);
    $article_tag = $article->tags()->attach(2);
    dd($article_tag);*/

    $tags = \App\Tag::find(2);
    $article_tag = $tags->articles()->detach(5);
    dd($article_tag);

});


//redis 学习
Route::get('redis',function (){


   /* Redis::set('name','333');

    return Redis::get('name');*/

    Cache::put('name','hello',10);

    return Cache::get('name');

});


//实现订阅
Route::get('/subscribe',function (){

    $data = [
        'event' => 'addNewMessage',
        'data' => [
            'name' => 'junming'
        ]
    ];
    Redis::publish('test-channel',json_encode($data));

    return view('subscribe');

});


//全文索引测试
Route::get('/search',function (){
   // dd(App\Article::search('Impedit')->get());
    dd(App\Lesson::search('Quam')->get());


    /*App\Article::where('id', 2)
        ->update(['title' => '肖张']);*/
});




