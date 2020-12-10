<?php

use Crater\Http\Controllers\V1\Lead\LeadsController;
use Crater\Http\Requests\DeleteLeadsRequest;
use Crater\Http\Requests\LeadsRequest;
use Crater\Models\Lead;
use Crater\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{postJson, putJson, getJson, deleteJson};

beforeEach(function () {
    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
    Artisan::call('db:seed', ['--class' => 'DemoSeeder', '--force' => true]);

    $user = User::find(1);
    $this->withHeaders([
        'company' => $user->company_id,
    ]);
    Sanctum::actingAs(
        $user,
        ['*']
    );
});

test('get leads', function () {
    $response = getJson('api/v1/leads');

    $response
        ->assertOk()
        ->assertJsonStructure([
            'leads',
        ]);
});

test('store validates using a LeadsRequest', function () {
    $this->assertActionUsesFormRequest(
        LeadsController::class,
        'store',
        LeadsRequest::class
    );
});

test('create lead', function () {
    $lead = Lead::factory()->raw();

    $response = postJson('api/v1/leads', $lead);

    $response->assertOk();
    $this->assertDatabaseHas('leads', $lead);
});

test('get lead', function () {
    $lead = Lead::factory()->create();
    $lead->load('leadSource');

    $response = getJson('api/v1/leads/' . $lead->id);
    $response
            ->assertOk()
            ->assertJson([
                'lead' => $lead->toArray(),
            ]);
});

test('update validates using a LeadsRequest', function () {
    $this->assertActionUsesFormRequest(
        LeadsController::class,
        'update',
        LeadsRequest::class
    );
});

test('update lead', function () {
    $lead = Lead::factory()->create();
    $lead1 = Lead::factory()->raw();

    $response = putJson('api/v1/leads/' . $lead->id, $lead1);

    $response
            ->assertOk()
            ->assertJsonFragment([
                'success' => true,
            ]);
});

test('destroy lead', function () {
    $lead = Lead::factory()->create();

    $response = deleteJson('/api/v1/leads/' . $lead->id);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    $this->assertEquals(0, Lead::count());    
});

test('delete validates using a DeleteLeadRequest', function () {
    $this->assertActionUsesFormRequest(
        LeadsController::class,
        'delete',
        DeleteLeadsRequest::class
    );
});

test('delete leads', function () {
    $lead1 = Lead::factory()->create();
    $lead2 = Lead::factory()->create();

    $response = postJson('api/v1/leads/delete', [
        'ids' => [$lead1->id, $lead2->id],
    ]);
    $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    $this->assertEquals(0, Lead::count());
});