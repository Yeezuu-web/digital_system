<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            // $table->datetime('reviewed_at')->nullable()->after('deleted_at');
            // $table->datetime('approved_at')->nullable()->after('reviewed_at');
            // $table->unsignedBigInteger('reviewed_by')->nullable()->after('reviewed_at');
            // $table->unsignedBigInteger('approved_by')->nullable()->after('reviewed_by');
            // $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable()->after('status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            //
        });
    }
}
