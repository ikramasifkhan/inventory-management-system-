<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('suplier_id');
//            $table->unsignedBigInteger('unit_id');
//            $table->unsignedBigInteger('category_id');
            $table->foreignId('suplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name', 124)->unique();
            $table->double('quantity', 124)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('create_by')->nullable(1);
            $table->integer('updated_by')->nullable(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
