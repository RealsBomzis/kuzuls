<?php

namespace Tests\Feature;

use App\Models\Pasakums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_does_not_show_unpublished_event(): void
    {
        $published = Pasakums::factory()->create(['publicets' => 1, 'nosaukums' => 'PUB']);
        $hidden = Pasakums::factory()->create(['publicets' => 0, 'nosaukums' => 'HID']);

        $this->get('/pasakumi')->assertSee('PUB')->assertDontSee('HID');
        $this->get("/pasakumi/{$hidden->id}")->assertStatus(404);
    }
}