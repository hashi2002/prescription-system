<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
    $table->string('address')->nullable()->after('email');
    $table->string('contact_no')->nullable()->after('address');
    $table->date('dob')->nullable()->after('contact_no');
    $table->enum('user_type', ['user', 'pharmacy'])->default('user')->after('dob');
});

    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'contact_no', 'dob', 'user_type']);
        });
    }
}