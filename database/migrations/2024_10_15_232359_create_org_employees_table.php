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
        Schema::create('org_employees', function (Blueprint $table) {
            $table->id();
            $table->string('internal_id', 6)->unique()->nullable();
            $table->string('name', 60);
            $table->string('email', 50)->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->boolean('status');
            $table->text('remarks', 255)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            //Constraints
            $table->foreign('department_id')->references('id')->on('org_departments');
            $table->foreign('location_id')->references('id')->on('org_locations');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_employees');
    }
};
