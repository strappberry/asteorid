<?php

use Crater\Http\Controllers\V1\Lead\LeadsController;
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

test('get lead sources', function  () {
    $response = getJson('api/v1/lead-sources');

    $response
        ->assertOk()
        ->assertJsonStructure([
            'lead_sources'
        ]);
});