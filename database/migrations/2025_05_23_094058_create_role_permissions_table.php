<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id('PermissionID'); // Primary key
            $table->unsignedBigInteger('RoleID'); // Foreign key to user_roles table
            $table->string('Description'); // e.g. Create, Retrieve, Update, Delete
            $table->timestamps();

            // Foreign key constraint to user_roles
            $table->foreign('RoleID')->references('RoleID')->on('user_roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
