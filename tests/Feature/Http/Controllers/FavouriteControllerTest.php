<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FavouriteController
 */
class FavouriteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $favourites = Favourite::factory()->count(3)->create();

        $response = $this->get(route('favourite.index'));

        $response->assertOk();
        $response->assertViewIs('favourite.index');
        $response->assertViewHas('favourites');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('favourite.create'));

        $response->assertOk();
        $response->assertViewIs('favourite.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FavouriteController::class,
            'store',
            \App\Http\Requests\FavouriteStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $user_id = $this->faker->randomNumber();
        $title = $this->faker->sentence(4);

        $response = $this->post(route('favourite.store'), [
            'user_id' => $user_id,
            'title' => $title,
        ]);

        $favourites = Favourite::query()
            ->where('user_id', $user_id)
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $favourites);
        $favourite = $favourites->first();

        $response->assertRedirect(route('favourite.index'));
        $response->assertSessionHas('favourite.id', $favourite->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $favourite = Favourite::factory()->create();

        $response = $this->get(route('favourite.show', $favourite));

        $response->assertOk();
        $response->assertViewIs('favourite.show');
        $response->assertViewHas('favourite');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $favourite = Favourite::factory()->create();

        $response = $this->get(route('favourite.edit', $favourite));

        $response->assertOk();
        $response->assertViewIs('favourite.edit');
        $response->assertViewHas('favourite');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FavouriteController::class,
            'update',
            \App\Http\Requests\FavouriteUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $favourite = Favourite::factory()->create();
        $user_id = $this->faker->randomNumber();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('favourite.update', $favourite), [
            'user_id' => $user_id,
            'title' => $title,
        ]);

        $favourite->refresh();

        $response->assertRedirect(route('favourite.index'));
        $response->assertSessionHas('favourite.id', $favourite->id);

        $this->assertEquals($user_id, $favourite->user_id);
        $this->assertEquals($title, $favourite->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $favourite = Favourite::factory()->create();

        $response = $this->delete(route('favourite.destroy', $favourite));

        $response->assertRedirect(route('favourite.index'));

        $this->assertDeleted($favourite);
    }
}
