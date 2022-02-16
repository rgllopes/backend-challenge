<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable(false); 
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('access_level');
            $table->rememberToken();
            $table->timestamps();
        });

        //Insert record in the table
        DB::table('users')->insert([
            [
                'msisdn'        => "+5551999999999",
                'name'          => "Admin",
                'email'         => 'admin@admin.com',
                'access_level'  => 2,
                'password'      => Hash::make("12345678"),
                "created_at"    => \Carbon\Carbon::now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
