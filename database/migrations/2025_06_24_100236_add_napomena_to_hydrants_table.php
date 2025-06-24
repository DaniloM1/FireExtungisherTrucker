<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNapomenaToHydrantsTable extends Migration
{
    public function up()
    {
        Schema::table('hydrants', function (Blueprint $table) {
            $table->text('napomena')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('hydrants', function (Blueprint $table) {
            $table->dropColumn('napomena');
        });
    }
}
