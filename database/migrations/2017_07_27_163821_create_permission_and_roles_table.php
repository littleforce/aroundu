<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAndRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //角色表
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('角色名称')->default('');
            $table->string('description', 100)->comment('角色描述')->default('');
            $table->timestamps();
        });

        //权限表
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('权限名称')->default('');
            $table->string('description', 100)->comment('权限描述')->default('');
            $table->timestamps();
        });

        //权限角色表
        Schema::create('admin_permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id');
            $table->integer('role_id');
        });

        //用户角色表
        Schema::create('admin_role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_permission_role');
        Schema::dropIfExists('admin_user_role');
    }
}
