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
        Schema::table('tasks', function (Blueprint $table) {
            // すでに user_id カラムが存在する場合は追加しない
            if (!Schema::hasColumn('tasks', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');

                // 外部キー制約の設定
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'user_id')) {
                $table->dropForeign(['user_id']); // 外部キー制約を削除
                $table->dropColumn('user_id');    // カラムを削除
            }
        });
    }
};
