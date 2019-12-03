<?php

use App\Chat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnToChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Chat::whereNotNull('id')->forceDelete();

        Schema::table('chats', function (Blueprint $table) {
            $table->string('slug')->unique()->after('support_id');
            $table->unsignedBigInteger('client_id')->nullable()->change();
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
            $table->dropColumn('slug');
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
        });
    }
}
