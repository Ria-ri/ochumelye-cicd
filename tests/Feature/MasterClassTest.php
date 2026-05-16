<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterClassTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function master_can_create_master_class()
    {
        $master = User::factory()->master()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($master)->post('/master-class', [
            'category_id' => $category->id,
            'title' => 'Test Class',
            'description' => 'Description',
            'date' => now()->addDays(5)->format('Y-m-d'),
            'time_slot' => '13-15',
            'capacity' => 10,
            'cost' => 1500,
        ]);

        $response->assertRedirect(route('cabinet'));
        $this->assertDatabaseHas('master_classes', ['title' => 'Test Class']);
    }

    /** @test */
    public function master_cannot_create_duplicate_time_slot_on_same_day()
    {
        $master = User::factory()->master()->create();
        $category = Category::factory()->create();
        $date = now()->addDays(5)->format('Y-m-d');
        $slot = '13-15';

        MasterClass::factory()->create([
            'master_id' => $master->id,
            'category_id' => $category->id,
            'date' => $date,
            'time_slot' => $slot,
        ]);

        $response = $this->actingAs($master)->post('/master-class', [
            'category_id' => $category->id,
            'title' => 'Another Class',
            'description' => 'Desc',
            'date' => $date,
            'time_slot' => $slot,
            'capacity' => 10,
            'cost' => 1000,
        ]);

        $response->assertSessionHasErrors('time_slot');
    }

    /** @test */
    public function capacity_must_be_between_1_and_20()
    {
        $master = User::factory()->master()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($master)->post('/master-class', [
            'category_id' => $category->id,
            'title' => 'Invalid Capacity',
            'description' => 'Desc',
            'date' => now()->addDays(5)->format('Y-m-d'),
            'time_slot' => '13-15',
            'capacity' => 30,
            'cost' => 1000,
        ]);

        $response->assertSessionHasErrors('capacity');
    }

    /** @test */
    public function cost_must_be_between_0_and_5000()
    {
        $master = User::factory()->master()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($master)->post('/master-class', [
            'category_id' => $category->id,
            'title' => 'High Cost',
            'description' => 'Desc',
            'date' => now()->addDays(5)->format('Y-m-d'),
            'time_slot' => '13-15',
            'capacity' => 10,
            'cost' => 6000,
        ]);

        $response->assertSessionHasErrors('cost');
    }
}
