<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('chiller_id');
            $table->string('chiller_photo')->nullable();
            $table->boolean('chiller_placement')->nullable();
            $table->text('chiller_placement_note')->nullable();
            $table->boolean('chiller_branding')->nullable();
            $table->text('chiller_branding_note')->nullable();
            $table->boolean('chiller_cleanliness')->nullable();
            $table->text('chiller_cleanliness_note')->nullable();
            $table->enum('chiller_condition', ["A", "B", "C"])->nullable();
            $table->text('chiller_condition_note')->nullable();
            $table->boolean('chiller_maintenance')->nullable();
            $table->text('chiller_maintenance_note')->nullable();
            $table->boolean('planogram')->nullable();
            $table->text('planogram_note')->nullable();
            $table->string('planogram_photo')->nullable();
            $table->timestamps();

            $table->unique(['survey_id', 'chiller_id']);
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('chiller_id')->references('id')->on('chillers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_details');
    }
}
