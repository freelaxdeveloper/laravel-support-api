<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestColumnToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'ip_address']);

            $table->unsignedBigInteger('guest_id')->after('chat_id');
            $table->foreign('guest_id')->references('id')->on('guests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->ipAddress('ip_address')->nullable();

            $table->dropForeign(['guest_id']);
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['guest_id']);
        });
    }
}
