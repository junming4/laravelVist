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

#laravel中使用redis
 1)、请求redis包: composer require predis/predis
 2)、需要修改.env 中CACHE_DRIVER=redis
 3)、纯原生的使用 :
    需要引入:use Illuminate\Support\Facades\Redis; //没有加上前缀
    Redis::set('name','333');
    return Redis::get('name');
 4)、直接使用cache门面使用:不用引入任何插件
     Cache::put('name','hello',10);
     return Cache::get('name');
     
#laravel 安装socket.io ioredis   
  npm install socket.io ioredis --save         
  
#git 设置别名
  git config --global alias.st status
  
#定时任务

 php artisan schedule:run

  app\Console\Kernel.php
  中的schedule 添加你要实现的任务
   protected function schedule(Schedule $schedule)
      {
          // $schedule->command('inspire')
          //          ->hourly();
  
          $schedule->call(function () {
              echo "hello world to php";
          })->daily();
      }
      
#如何然php artisan queue listen 一直运行着可以使用
      Supervisor 是一个 Linux 操作系统上的进程监控软件，它会在 queue:listen 或 queue:work 命令发生失败后自动重启它们。要在 Ubuntu 安装 Supervisor，可以用以下命令
      文档地址：http://d.laravel-china.org/docs/5.1/queues
      http://yansu.org/2014/03/22/managing-your-larrvel-queue-by-supervisor.html
      Supervisor 配置文件通常存放在 /etc/supervisor/conf.d 目录，在该目录中，可以创建多个配置文件指示 Supervisor 如何监视进程，例如，让我们创建一个开启并监视queue:work 进程的 laravel-worker.conf 文件：
      
      [program:laravel-worker]
      process_name=%(program_name)s_%(process_num)02d
      command=php /home/forge/app.com/artisan queue:work sqs --sleep=3 --tries=3
      autostart=true
      autorestart=true
      user=forge
      numprocs=8
      redirect_stderr=true
      stdout_logfile=/home/forge/app.com/worker.log

#laravel 全文索引插件 laravel/scout
    1)、安装 composer require laravel/scout 【5.3】composer require laravel/scout:2.0.x-dev
    providers =>[ Laravel\Scout\ScoutServiceProvider::class,  ]
    php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider" //生成配置文件
    2) 安装 ElasticSearch ： composer require elasticsearch/elasticsearch
    Elasticquent\ElasticquentServiceProvider::class,
    导入:
    php artisan scout:import "App\Article"
    提示:
    [InvalidArgumentException]
    Driver [elasticsearch] not supported.
    说明没有 elasticsearch引擎需要使用另外一个查看
    composer require tamayo/laravel-scout-elastic:2.0.x-dev
    providers =>[ScoutEngines\Elasticsearch\ElasticsearchProvider::class,]
    
    再执行 php artisan scout:import "App\Article"
    使用:dd(App\Article::search('Impedit')->get()); 
    
#发送邮件 
    php artisan make:mail WelcomeLaravel
    Mail/WelcomeLaravel 中执行模板的地址
    然后发送信息
    Mail::to('xiaojunming4@gmail.com')->send(new \App\Mail\WelcomeLaravel())就能发送邮件了  
    
     
     
    **`_****_`**


      

            
            

   
    
 


