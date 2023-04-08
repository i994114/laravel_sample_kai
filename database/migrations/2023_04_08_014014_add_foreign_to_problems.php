<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToProblems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problems', function (Blueprint $table) {
            DB::statement('DELETE FROM problems');
            $table->unsignedBigInteger('drill_id')->change();
            $table->foreign('drill_id')->references('id')->on('drills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->dropForeign(['drill_id']);
            $table->unsignedBigInteger('drill_id')->change();
            
        });
    }
}
