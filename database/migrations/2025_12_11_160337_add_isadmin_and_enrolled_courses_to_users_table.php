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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('isadmin')->default(false)->after('admin_id');
            $table->json('enrolled_courses')->nullable()->after('isadmin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('isadmin');
            $table->dropColumn('enrolled_courses');
        });
    }
};
