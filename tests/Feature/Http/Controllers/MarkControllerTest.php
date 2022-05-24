<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Mark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MarkController
 */
class MarkControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $marks = Mark::factory()->count(3)->create();

        $response = $this->get(route('mark.index'));

        $response->assertOk();
        $response->assertViewIs('mark.index');
        $response->assertViewHas('marks');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('mark.create'));

        $response->assertOk();
        $response->assertViewIs('mark.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MarkController::class,
            'store',
            \App\Http\Requests\MarkStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $user_id = $this->faker->randomNumber();

        $response = $this->post(route('mark.store'), [
            'title' => $title,
            'user_id' => $user_id,
        ]);

        $marks = Mark::query()
            ->where('title', $title)
            ->where('user_id', $user_id)
            ->get();
        $this->assertCount(1, $marks);
        $mark = $marks->first();

        $response->assertRedirect(route('mark.index'));
        $response->assertSessionHas('mark.id', $mark->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $mark = Mark::factory()->create();

        $response = $this->get(route('mark.show', $mark));

        $response->assertOk();
        $response->assertViewIs('mark.show');
        $response->assertViewHas('mark');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $mark = Mark::factory()->create();

        $response = $this->get(route('mark.edit', $mark));

        $response->assertOk();
        $response->assertViewIs('mark.edit');
        $response->assertViewHas('mark');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MarkController::class,
            'update',
            \App\Http\Requests\MarkUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $mark = Mark::factory()->create();
        $title = $this->faker->sentence(4);
        $user_id = $this->faker->randomNumber();

        $response = $this->put(route('mark.update', $mark), [
            'title' => $title,
            'user_id' => $user_id,
        ]);

        $mark->refresh();

        $response->assertRedirect(route('mark.index'));
        $response->assertSessionHas('mark.id', $mark->id);

        $this->assertEquals($title, $mark->title);
        $this->assertEquals($user_id, $mark->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $mark = Mark::factory()->create();

        $response = $this->delete(route('mark.destroy', $mark));

        $response->assertRedirect(route('mark.index'));

        $this->assertDeleted($mark);
    }
}
