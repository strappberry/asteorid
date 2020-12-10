<?php

use Crater\Models\Lead;
use Crater\Models\LeadSource;

test('lead source can be created', function () {
    LeadSource::factory()->create();
    $leadSources = LeadSource::count();
    $this->assertEquals(1, $leadSources);
});

test('lead can be created', function () {
    Lead::factory()->create();
    $leads = Lead::count();
    $this->assertEquals(1, $leads);
});

test('lead sources has many leads', function () {
    $leadSource = LeadSource::factory()->hasLeads(4)->create();

    $this->assertTrue($leadSource->leads()->exists());
    $this->assertCount(4, $leadSource->leads);
});