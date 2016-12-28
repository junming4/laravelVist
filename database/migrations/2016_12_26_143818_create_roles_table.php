<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {      //权限操作表
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });
        Schema::create('permission_role', function (Blueprint $table) {  //权限操作关联表
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id')    //外键
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade') ;
            $table->foreign('role_id')    //外键
            ->references('id')
                ->on('roles')
                ->onDelete('cascade') ;
            $table->timestamps();
            $table->primary(['permission_id','role_id']) ;
        });
        Schema::create('role_user', function (Blueprint $table) {  //用户关联表
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('user_id')    //外键
            ->references('id')
                ->on('users')
                ->onDelete('cascade') ;
            $table->foreign('role_id')    //外键
            ->references('id')
                ->on('roles')
                ->onDelete('cascade') ;
            $table->timestamps();
            $table->primary(['user_id','role_id']) ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
