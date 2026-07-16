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
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->string('banque_partenaire_nom')->nullable()->after('motif');
            $table->decimal('courtage_frais_dossier', 10, 2)->nullable()->after('banque_partenaire_nom');
            $table->decimal('apport_personnel_montant', 10, 2)->nullable()->after('courtage_frais_dossier');
            $table->boolean('assurance_incluse')->default(false)->after('apport_personnel_montant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->dropColumn([
                'banque_partenaire_nom',
                'courtage_frais_dossier',
                'apport_personnel_montant',
                'assurance_incluse'
            ]);
        });
    }
};
