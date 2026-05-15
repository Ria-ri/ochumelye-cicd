<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_page_loads_successfully()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('category.show', $category));
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    /** @test */
    public function category_page_shows_master_classes()
    {
        $category = Category::factory()->create();
        $masterClass = MasterClass::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('category.show', $category));
        // В шаблоне отображаются стоимость и описание, но не заголовок
        $response->assertSee($masterClass->cost);
        $response->assertSee($masterClass->description);
    }

    /** @test */
    public function category_page_shows_free_places()
    {
        $category = Category::factory()->create();
        $masterClass = MasterClass::factory()->create([
            'category_id' => $category->id,
            'capacity' => 10,
        ]);

        $response = $this->get(route('category.show', $category));
        $response->assertSee('Свободно мест: 10');
    }

    /** @test */
    public function category_page_shows_login_link_when_not_authenticated()
    {
        $category = Category::factory()->create();
        // Создаём мастер-класс, чтобы кнопка появилась
        MasterClass::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('category.show', $category));
        $response->assertSee('Войдите, чтобы записаться');
    }

    /** @test */
    public function category_page_shows_book_button_when_authenticated_and_places_available()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $masterClass = MasterClass::factory()->create([
            'category_id' => $category->id,
            'capacity' => 5,
        ]);

        $response = $this->actingAs($user)->get(route('category.show', $category));
        $response->assertSee('записаться');
    }
}