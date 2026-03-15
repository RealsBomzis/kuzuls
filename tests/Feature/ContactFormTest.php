<?php

namespace Tests\Feature;

use App\Models\KontaktZinojums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_message(): void
    {
        $this->post('/kontakti', [
            'vards' => 'Test',
            'epasts' => 'test@example.com',
            'tema' => 'Sveiki',
            'zinojums' => 'Test message',
        ])->assertRedirect('/kontakti');

        $this->assertDatabaseHas('kontakt_zinojumi', [
            'epasts' => 'test@example.com',
            'statuss' => 'jauns',
        ]);
    }
}