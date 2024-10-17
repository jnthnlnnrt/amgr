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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('subtype_id')->nullable();
            $table->string('asset_tag', 9)->unique()->nullable();
            $table->unsignedBigInteger('manufacturer_id');
            $table->string('model', 50);
            $table->string('serial', 50);
            $table->string('imei', 15)->nullable();
            $table->string('mac_address', 50)->nullable();
            $table->string('ip_address', 15)->nullable();
            $table->string('ipmi_address', 15)->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('location_id');
            $table->boolean('require_maintenance');
            $table->unsignedBigInteger('frequency_id')->nullable();
            $table->date('last_maintenance')->nullable();
            $table->integer('carry_authorization');
            $table->text('remarks', 255)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            //Constraints
            $table->foreign('category_id')->references('id')->on('cat_asset_categories');
            $table->foreign('type_id')->references('id')->on('cat_asset_types');
            $table->foreign('subtype_id')->references('id')->on('cat_asset_subtypes'); 
            $table->foreign('manufacturer_id')->references('id')->on('cat_manufacturers');
            $table->foreign('status_id')->references('id')->on('cat_asset_statuses');
            $table->foreign('employee_id')->references('id')->on('org_employees');
            $table->foreign('location_id')->references('id')->on('org_locations');
            $table->foreign('frequency_id')->references('id')->on('cat_maintenance_frequencies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
