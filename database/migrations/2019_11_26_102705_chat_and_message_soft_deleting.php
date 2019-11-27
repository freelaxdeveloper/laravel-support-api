<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChatAndMessageSoftDeleting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->softDeletes();
        });
       Schema::table('messages', function (Blueprint $table) {
            $table->softDeletes();
        });
       Schema::table('suggestions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('suggestions', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
