<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DealSubmissionTest extends TestCase
{
    use WithFaker;

    public function test_can_submit_deal_form_successfully()
    {
        

        $payload = [
            'account_name' => 'Test Company LLC',
            'account_phone' => '+123456789',
            'account_website' => 'https://example.com',
            'deal_name' => 'Big Deal 2025',
            'stage' => 'Qualification',
        ];

        $response = $this->post('/zoho-form', $payload);

       
        $response->assertStatus(200); 

        
        $response->assertSessionHas('success');

        
    }

    public function test_validation_errors_on_missing_required_fields()
    {
        $response = $this->post('/zoho-form', []);

        $response->assertSessionHasErrors([
            'account_name',
            'deal_name',
            'stage',
        ]);
    }
}
