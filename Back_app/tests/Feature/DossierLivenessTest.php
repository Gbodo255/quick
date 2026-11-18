<?php

namespace Tests\Feature;

use App\Models\CreditApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DossierLivenessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.didit' => ['api_key' => 'key', 'workflow_id' => 'wf-1', 'base_url' => 'https://didit.test']]);
    }

    private function dossier(): CreditApplication
    {
        $res = $this->postJson('/api/v1/dossiers', ['montant' => 5000, 'duree_mois' => 24, 'motif' => 'autre'])->assertCreated();

        return CreditApplication::where('reference', $res->json('dossier.reference'))->firstOrFail();
    }

    private function headers(CreditApplication $d): array
    {
        return ['X-Dossier-Token' => $d->access_token];
    }

    public function test_creates_session_bound_to_dossier(): void
    {
        Http::fake(['didit.test/*' => Http::response(['session_id' => 'sess-1', 'url' => 'https://verify.didit.me/s/abc', 'status' => 'Not Started'], 201)]);
        $d = $this->dossier();

        $this->postJson("/api/v1/dossiers/{$d->reference}/liveness", [], $this->headers($d))
            ->assertOk()->assertExactJson(['url' => 'https://verify.didit.me/s/abc']);

        $this->assertSame('sess-1', $d->fresh()->liveness_session_id);
        Http::assertSent(fn (Request $r) => $r->url() === 'https://didit.test/v3/session/'
            && $r->hasHeader('x-api-key', 'key')
            && $r['workflow_id'] === 'wf-1'
            && $r['vendor_data'] === $d->reference);
    }

    public function test_status_polls_decision_until_final(): void
    {
        Http::fakeSequence('didit.test/*')
            ->push(['session_id' => 'sess-1', 'url' => 'u', 'status' => 'Not Started'], 201)
            ->push(['status' => 'In Progress'])
            ->push(['status' => 'Approved']);
        $d = $this->dossier();
        $h = $this->headers($d);

        $this->getJson("/api/v1/dossiers/{$d->reference}/liveness", $h)->assertJson(['status' => 'not_started']);
        $this->postJson("/api/v1/dossiers/{$d->reference}/liveness", [], $h)->assertOk();
        $this->getJson("/api/v1/dossiers/{$d->reference}/liveness", $h)->assertJson(['status' => 'pending']);
        $this->getJson("/api/v1/dossiers/{$d->reference}/liveness", $h)->assertJson(['status' => 'passed']);
        // décision finale : plus d'appel à Didit
        $this->getJson("/api/v1/dossiers/{$d->reference}/liveness", $h)->assertJson(['status' => 'passed']);
        Http::assertSentCount(3);
    }

    public function test_declined_maps_to_failed_and_errors_map_to_503(): void
    {
        Http::fakeSequence('didit.test/*')
            ->push(['session_id' => 'sess-1', 'url' => 'u', 'status' => 'Not Started'], 201)
            ->push(['status' => 'Declined'])
            ->push(['detail' => 'You don\'t have enough credits'], 400);
        $d = $this->dossier();
        $h = $this->headers($d);

        $this->postJson("/api/v1/dossiers/{$d->reference}/liveness", [], $h);
        $this->getJson("/api/v1/dossiers/{$d->reference}/liveness", $h)->assertJson(['status' => 'failed']);
        $this->postJson("/api/v1/dossiers/{$d->reference}/liveness", [], $h)->assertStatus(503);
    }

    public function test_requires_configuration_and_token(): void
    {
        Http::fake();
        $d = $this->dossier();
        $this->postJson("/api/v1/dossiers/{$d->reference}/liveness")->assertStatus(401);

        config(['services.didit.api_key' => null]);
        $this->postJson("/api/v1/dossiers/{$d->reference}/liveness", [], $this->headers($d))->assertStatus(503);
        Http::assertNothingSent();
    }
}
