<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAreaHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_area_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_area_id');
            $table->string('shift');
            $table->string('time_start');
            $table->string('time_end');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('client_area_id')->references('id')->on('client_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_area_hours');
    }
}
