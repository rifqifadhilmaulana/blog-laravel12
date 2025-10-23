<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Tambahkan kolom is_hidden, default false
            $table->boolean('is_hidden')->default(false)->after('body');

            // Tambahkan index untuk performa query
            $table->index('is_hidden');
            $table->index('parent_id');
            $table->index('post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Hapus kolom dan index
            $table->dropIndex(['is_hidden']);
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['post_id']);
            $table->dropColumn('is_hidden');
        });
    }
};
