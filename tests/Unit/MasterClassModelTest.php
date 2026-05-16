<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\MasterClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterClassModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function free_places_calculates_correctly()
    {
        $masterClass = MasterClass::factory()->create(['capacity' => 10]);
        Booking::factory()->count(3)->create(['master_class_id' => $masterClass->id]);

        $this->assertEquals(7, $masterClass->freePlaces());
    }

    /** @test */
    public function is_full_returns_true_when_no_free_places()
    {
        $masterClass = MasterClass::factory()->create(['capacity' => 2]);
        Booking::factory()->count(2)->create(['master_class_id' => $masterClass->id]);

        $this->assertTrue($masterClass->isFull());
    }
}
