<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\MasterClass;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_book_a_master_class()
    {
        $user = User::factory()->create();
        $masterClass = MasterClass::factory()->create(['capacity' => 5]);

        $response = $this->actingAs($user)->post('/booking/' . $masterClass->id);

        $response->assertRedirect(route('category.show', $masterClass->category_id));
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'master_class_id' => $masterClass->id,
        ]);
    }

    /** @test */
    public function user_cannot_book_full_master_class()
    {
        $user = User::factory()->create();
        $masterClass = MasterClass::factory()->create(['capacity' => 1]);
        // заполняем единственное место
        Booking::factory()->create(['master_class_id' => $masterClass->id]);

        $response = $this->actingAs($user)->post('/booking/' . $masterClass->id);

        $response->assertSessionHas('error', 'Места закончились.');
        $this->assertDatabaseMissing('bookings', [
            'user_id' => $user->id,
            'master_class_id' => $masterClass->id,
        ]);
    }

    /** @test */
    public function user_cannot_book_twice()
    {
        $user = User::factory()->create();
        $masterClass = MasterClass::factory()->create();
        Booking::factory()->create([
            'user_id' => $user->id,
            'master_class_id' => $masterClass->id,
        ]);

        $response = $this->actingAs($user)->post('/booking/' . $masterClass->id);

        $response->assertSessionHas('error', 'Вы уже записаны.');
    }

    /** @test */
    public function master_cannot_book_own_master_class()
    {
        $master = User::factory()->master()->create();
        $masterClass = MasterClass::factory()->create(['master_id' => $master->id]);

        $response = $this->actingAs($master)->post('/booking/' . $masterClass->id);

        $response->assertSessionHas('error', 'Вы не можете записаться на собственный мастер-класс.');
    }
}