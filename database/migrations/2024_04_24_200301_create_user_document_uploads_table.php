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
        Schema::create('user_document_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            //$table->foreignId('user_id')->constrained('users')->OnUpdate('cascade')->onDelete('cascade');
            $table->string('description');
            $table->string('image_path');
            $table->string('reminder_email_date');
            $table->string('actual_date');
            $table->enum('status',['Inactive','Active'])->default('Active');
            $table->enum('is_deleted',['True','False'])->default('False');
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
        Schema::dropIfExists('user_document_uploads');
    }
};
