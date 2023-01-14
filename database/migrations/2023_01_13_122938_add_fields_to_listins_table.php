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
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->unsignedTinyInteger('beds')
                ->comment('Count of beds in apartment');
            $table->unsignedTinyInteger('baths')
                ->comment('Count of bath in apartment');
            $table->unsignedSmallInteger('area')
                ->comment('Total area of apartment');

            $table->tinyText('city');
            $table->tinyText('code')
                ->comment('Post code of apartment address');
            $table->tinyText('street');
            $table->tinyText('street_nr');

            $table->unsignedBigInteger('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropColumns('listings', [
            'beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'
        ]);
    }
};
