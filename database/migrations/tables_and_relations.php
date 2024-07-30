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
        Schema::dropIfExists('users');
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('email');
            $table->string('pasword');
            $table->integer('prefix');
            $table->integer('phone');
            $table->string('position');

            $table->timestamps();
        });

        Schema::create('storages',function(Blueprint $table){
            $table->id();
            $table->string('adress');
            $table->integer('prefix');
            $table->integer('phone');
            $table->double('dimensions');
            $table->string('unity');

            $table->timestamps();
        });
        
        Schema::create('stoktakings',function(Blueprint $table){
            $table->id();
            $table->integer('size');

            $table->timestamps();
        });

        Schema::create('products',function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->double('prize');
            $table->double('tax');

            $table->timestamps();
        });

        Schema::create('packs',function(Blueprint $table){
            $table->id();
            $table->integer('id_tipo'); //0: comanda, 1: reserva, 2: disponible
            $table->string('description');
            $table->integer('size');

            $table->timestamps();
        });

        Schema::create('orders',function(Blueprint $table){
            $table->id();
            $table->string('description');
            $table->double('final_prize');

            $table->timestamps();
        });

        Schema::table('users',function(Blueprint $table){
            $table->unsignedBigInteger('storage_id')->nullable(false)->after('position');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
        });

        Schema::table('storages',function(Blueprint $table){
            $table->unsignedBigInteger('stoktaking_id')->nullable()->after('id');
            $table->foreign('stoktaking_id')->references('id')->on('stoktakings')->onDelete('cascade');
        });

        Schema::table('stoktakings',function(Blueprint $table){
            $table->unsignedBigInteger('storage_id')->nullable(false)->after('id');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable(false)->after('storage_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('products',function(Blueprint $table){
        });

        Schema::table('packs',function(Blueprint $table){
            $table->unsignedBigInteger('product_id')->nullable(false)->after('id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable(false)->after('product_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('orders',function(Blueprint $table){
            $table->unsignedBigInteger('pack_id')->nullable(false)->after('id');
            $table->foreign('pack_id')->references('id')->on('packs')->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('storages');
        Schema::dropIfExists('stoktakings');
        Schema::dropIfExists('products');
        Schema::dropIfExists('packs');
        Schema::dropIfExists('orders');

    }
};
