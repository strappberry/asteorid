<?php

namespace Database\Seeders;

use Crater\Models\LeadSource;
use Illuminate\Database\Seeder;

class LeadSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadSources = [
            [
                'name' => 'Google AdWords'
            ],
            [
                'name' => 'Facebook Ads',
            ],
            [
                'name' => 'BNI',
            ],
            [
                'name' => 'Google Organic',
            ],
            [
                'name' => 'LinkedIn Ads',
            ],
            [
                'name' => 'Organic Facebook',
            ],
        ];

        foreach ($leadSources as $leadSource) {
            LeadSource::create($leadSource);
        }
    }
}
