<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('categories')->insert([
            ['name' => 'Electronics'],
            ['name' => 'Books'],
            ['name' => 'Clothes'],
            ['name' => 'Furniture'],
            ['name' => 'Toys'],
            ['name' => 'Tools'],
            ['name' => 'Sports'],
            ['name' => 'Other'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
