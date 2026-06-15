<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_tidak_mampu', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('id');
        });

        Schema::table('permohonan_kematian', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_tidak_mampu', function (Blueprint $table) {
            $table->dropColumn('nomor_surat');
        });

        Schema::table('permohonan_kematian', function (Blueprint $table) {
            $table->dropColumn('nomor_surat');
        });
    }
};