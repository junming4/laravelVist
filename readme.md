# 实现会员管理系统
  # 使用命令创建表
    - 1、创建表文件:php artisan  make:migration create_posts_table --create=posts,
    - 然后进入database\migrations 文件中编辑 --create_posts_table文件 
    - 然后执行生成表，前提数据库必须连接上的： php artisan migrate 
    - 2、填充数据： 进入 database\factories\ModelFactory.php进行编辑
    - 然后执行php artisan tinker会自动 
    - 执行 factory('App\Post')->create(); 可以创建 post数据
   
   #权限验证部分
     -  Providers\AuthServiceProvider.php 下有boot()方法可以创建权限的 ,
     - 然后引入 Illuminate\Contracts\Auth\Access\Gate as GateContract [这里经常会引错的数据为-》Illuminate\Auth\Access\Gate as GateContract]
     -代码如下：
      public function boot(GateContract $gate)
         {
             $this->registerPolicies();
     
             //
             $gate->define('show-post',function ($user,$post){
                   return $user->id === $post->user_id;
             });
     
         }
      
          控制器中调用权限:
         /**
              * Display the specified resource.
              *
              * @param  int $id
              * @return \Illuminate\Http\Response
              */
             public function show($id)
             {
                 //
                 $post = Post::findOrFail($id);
                 Auth::loginUsingId(1);
         
         
                 //方法一
                 /* if (Gate::denies('show-post', $post)) {
                      abort(403, '非法操作');
                  }*/
         
                 //方法二
                 $this->authorize('show-post', $post);
         
                 return $post->title;
             }
             
       视图中权限使用:
             @can('show-post', $post)
                 <a href="#">编辑文字</a>
             @endcan
             
       2、使用策略控制  
           1、创建一个policies/PostPolicy.php
           2、在其中写入一个方法:
           public function update($user, $post)
               {
                   return $user->owns($post);
               }
           3、然后把 policy 注册到权限提供器中
               protected $policies = [
                       'App\Post' => 'App\Policies\PostPolicy',
                   ];
           4、也能实现门面同样的效果，    
               
               php artisan make:middleware MustAdmin
         
  # 创建了sql监听，可以参考个人博客【http://blog.csdn.net/junming4/article/details/52464544】  
   
   https://github.com/romanbican/roles 权限控制系统
   
#api的开发
当提示没有这个函数时可以使用: composer dump-autload

#安装好了dingo/api 和jwt-auth 现在开始一些使用 ，继续开发。。。。  
 
配置具体数据: 到config/api.php
    'auth' => [
        'basic' => function($app){
            return new  Dingo\Api\Auth\Provider\Basic($app['auth']);
        },
        'jwt' => function($app) {
            return  new Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']) ;
        }
    ],
然后去到 Kernel.php把jwt配置上去

创建有效的url连接:
composer require spatie/laravel-url-signer
'providers' => [
    Spatie\UrlSigner\Laravel\UrlSignerServiceProvider::class,
];
'aliases' => [
    'UrlSigner' => Spatie\UrlSigner\Laravel\UrlSignerFacade::class,
];
php artisan vendor:publish --provider="Spatie\UrlSigner\Laravel\UrlSignerServiceProvider"

UrlSigner::sign('https://myapp.com/protected-route', 30);
UrlSigner::validate('https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx');
The package also provides a middleware to protect routes.

#类似postman插件
composer require asvae/laravel-api-tester
After updating composer, add the ServiceProvider to the providers array in config/app.php

Asvae\ApiTester\ServiceProvider::class,
That's it. Go to [your site]/api-tester and start testing routes. It works for Laravel 5.1+.

Config

By default, the package is bound to APP_DEBUG .env value. But you can easily override it. Just publish config:

php artisan vendor:publish --provider="Asvae\ApiTester\ServiceProvider"
And edit config/api-tester.php as you please.

#laravel latrell/swagger 的安装和使用 接口文档
1、composer require latrell/swagger dev-master
2、添加提供类:'providers' => [
        // ...
        'Latrell\Swagger\SwaggerServiceProvider',
    ]
3、移动配置文件:php artisan vendor:publish 
   
#创建带表文件的model: php artisan Article -m
   1）、修改表 文件数据
   2）、生成表 php artisan migrate
#测试插入文件
   1)、修改factories 中文件的数据
   2)、php artisan tinker
   3)、namespace App
   4)、factory(Article::class,20)->create();

#多对多关联
    $tags = \App\Tag::find(2);
    //$article_tag = $tags->articles()->attach(5);  #先关联
    $article_tag = $tags->articles()->detach(5);    #把关联删除
    dd($article_tag);
    
#快速创建event
    1)、在:D:\xiao\xampp\htdocs\laravelVist\app\Providers\EventServiceProvider.php 添加以下代码
    $listen = [
            'App\Events\PostEvent' => [
                'App\Listeners\PostListener',
            ],
    2)、然后运行 php artisan event:generate 会自动生成两个类的        
            
            

   
    
 


