<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phone', function (Blueprint $table) {
            $table->foreign("user_id", "fk_phone_user_idx")->references("id")->on("user");
        });

        Schema::table('address', function (Blueprint $table) {
            $table->foreign("user_id", "fk_address_user_idx")->references("id")->on("user");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phone', function (Blueprint $table) {
            $table->dropForeign("fk_phone_user_idx");
        });

        Schema::table('address', function (Blueprint $table) {
            $table->dropForeign("fk_address_user_idx");
        });
    }
};
