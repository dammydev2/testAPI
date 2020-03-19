<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestAPISTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_a_p_i_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reg_no');
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('gender');
            $table->string('date_of_birth');
            $table->string('religion');
            $table->string('residential_address');
            $table->string('home_phone');
            $table->string('state_of_origin');
            $table->string('sponsor_name');
            $table->string('sponsor_address');
            $table->string('sponsor_phone');
            $table->string('sponsor_email');
            $table->string('proposed_class');
            $table->string('school_attended');
            $table->string('student_type');
            $table->string('cbt_mode');
            $table->string('cbt_day');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_a_p_i_s');
    }
}
