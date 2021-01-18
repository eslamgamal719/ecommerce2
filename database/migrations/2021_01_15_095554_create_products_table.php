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
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('photo')->nullable();
            $table->longText('other_data')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('price', 5, 2)->default(0);
            $table->enum('status', ['pending', 'refused', 'active'])->default('pending');
            $table->longText('reason')->nullable();  //reason of being refused

            $table->date('start_at')->nullable();  //start and end of showing the product
            $table->date('end_at')->nullable();

            $table->decimal('price_offer', 5, 2)->default(0);
            $table->date('start_offer_at')->nullable();
            $table->date('end_offer_at')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->unsignedBigInteger('trade_id')->nullable();
            $table->foreign('trade_id')->references('id')->on('trade_marks')->onDelete('cascade');

            $table->unsignedBigInteger('manu_id')->nullable();
            $table->foreign('manu_id')->references('id')->on('manufacturers')->onDelete('cascade');

           /* $table->unsignedBigInteger('mall_id')->nullable();
            $table->foreign('mall_id')->references('id')->on('malls')->onDelete('cascade');*/

            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');

            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');

            $table->string('weight')->nullable();
            $table->unsignedBigInteger('weight_id')->nullable();
            $table->foreign('weight_id')->references('id')->on('weights')->onDelete('cascade');

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('countries');

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
