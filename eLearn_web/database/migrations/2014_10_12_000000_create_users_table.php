<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable(false); 
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->nullable(true);
            $table->string('password');
            $table->string('access_level');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insere registro de administrador ao realizar migrate
        DB::table('users')->insert([
            [
                'msisdn'        => '+5551000000000',
                'name'          => 'Admin',
                'email'         => 'admin@admin.com',
                'access_level'  => 'premium',
                'password'      => Hash::make("12345678"),
                "created_at"    => \Carbon\Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
