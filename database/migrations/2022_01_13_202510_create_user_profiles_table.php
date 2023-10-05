<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('client_area_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('nip')->nullable();
            $table->string('title')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('address')->nullable();
            $table->string('bpjs_number')->nullable();
            $table->string('npwp_number')->nullable();
            $table->string('relationship_number')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('tribe')->nullable();
            $table->boolean('is_validated')->default(0);
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('client_area_id')->references('id')->on('client_areas')->onDelete('cascade');
            $table->foreign('contract_id')->references('id')->on('user_contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
