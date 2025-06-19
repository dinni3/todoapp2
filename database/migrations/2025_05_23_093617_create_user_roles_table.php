<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id('RoleID');             // Primary key  // Foreign key to users table
            $table->string('RoleName');
            $table->text('Description')->nullable();
            $table->timestamps();

            // Foreign key constraint (optional but recommended
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
