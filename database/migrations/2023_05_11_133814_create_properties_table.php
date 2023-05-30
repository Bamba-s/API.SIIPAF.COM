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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('desc');
            $table->string('propertyType');
            $table->string('projectTitle');
            $table->string('propertyStatus');
            $table->string('formattedAddress');
            $table->boolean('featured');
            $table->integer('initialContributionPercentage');
            $table->float('monthlyPayment'); 
            $table->integer('bedrooms');
            $table->integer('rooms');
            $table->timestamps();
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('sale', 10, 2,true);
            $table->decimal('rent',10,2,true);
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
 
        Schema::create('localisations', function (Blueprint $table) {
            $table->id();
            $table->decimal('lat',10,2);
            $table->decimal('lng',10,2, false);
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
  

      
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
        
        
        Schema::create('areaFeatures', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('unit');
            $table->unsignedBigInteger('features_id');
            $table->unsignedBigInteger('property_id');
            $table->foreign('features_id')
                  ->references('id')
                  ->on('features')
                  ->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->timestamps();
        });
        
        
        Schema::create('paymentDeadlines', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('unit');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
        
    
        Schema::create('deliveryTimes', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('unit');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
     

        Schema::create('areaProperties', function (Blueprint $table) {
            $table->id();
            $table->decimal('ground');
            $table->decimal('used');
            $table->string('unit');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
     
        Schema::create('additionalFeatures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('small');
            $table->string('medium');
            $table->string('big');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });

     
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('desc');
            $table->string('image');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
   

       Schema::create('areaPlans', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->string('unit');
            $table->unsignedBigInteger('plans_id');
            $table->unsignedBigInteger('property_id');
            $table->foreign('plans_id')
                  ->references('id')
                  ->on('plans')
                  ->onDelete('cascade');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
            $table->timestamps();
        });
   
   
      Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('videos');
        Schema::dropIfExists('areaPlans');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('additionalFeatures');
        Schema::dropIfExists('areaProperties');
        Schema::dropIfExists('deliveryTimes');
        Schema::dropIfExists('paymentDeadlines');
        Schema::dropIfExists('areaFeatures');
        Schema::dropIfExists('features');
        Schema::dropIfExists('properties');
     
    }
};