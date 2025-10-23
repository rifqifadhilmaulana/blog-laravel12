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
        Schema::create('post_user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'post_id']); // agar tidak double favorite
        });

        Schema::table('posts',function(Blueprint $table){
            $table->unsignedBigInteger('favorites_count')->default(0);
        });
    }
     
     

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('post_user_favorite');
       Schema::table('posts',function(Blueprint $table){
        $table->dropColumn('favorite_count');
       });
    }
};
