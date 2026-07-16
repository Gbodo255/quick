<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 32)->unique();
            $table->uuid('access_token')->unique();
            $table->string('status', 32)->default('draft');
            $table->unsignedTinyInteger('processing_step')->default(0);

            $table->unsignedInteger('montant');
            $table->unsignedSmallInteger('duree_mois');
            $table->decimal('taux_annuel', 5, 2);
            $table->decimal('mensualite', 12, 2);
            $table->decimal('cout_total', 12, 2)->nullable();
            $table->decimal('total_rembourse', 12, 2)->nullable();

            $table->string('situation_pro', 32)->nullable();
            $table->string('situation_logement', 32)->nullable();
            $table->decimal('revenu_net', 12, 2)->nullable();
            $table->decimal('charges_mensuelles', 12, 2)->nullable();
            $table->boolean('is_eligible')->nullable();

            $table->string('civilite', 8)->nullable();
            $table->string('prenom', 100)->nullable();
            $table->string('nom', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('telephone', 32)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance', 150)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('code_postal', 16)->nullable();
            $table->string('ville', 100)->nullable();

            $table->string('employeur', 150)->nullable();
            $table->string('anciennete', 32)->nullable();
            $table->string('motif', 32)->nullable();
            $table->string('piece_identite_type', 32)->nullable();

            $table->boolean('consent_1')->default(false);
            $table->boolean('consent_2')->default(false);
            $table->boolean('consent_3')->default(false);
            $table->timestamp('consented_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });

        Schema::create('credit_application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained()->cascadeOnDelete();
            $table->string('type', 32);
            $table->string('disk', 32)->default('local');
            $table->string('path');
            $table->string('original_filename');
            $table->string('mime_type', 128);
            $table->unsignedBigInteger('size_bytes');
            $table->string('status', 32)->default('received');
            $table->timestamps();

            $table->unique(['credit_application_id', 'type']);
        });

        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_application_id')->constrained()->cascadeOnDelete();
            $table->string('code_hash');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
        Schema::dropIfExists('credit_application_documents');
        Schema::dropIfExists('credit_applications');
    }
};
