<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NoteController
 */
class NoteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $notes = Note::factory()->count(3)->create();

        $response = $this->get(route('note.index'));

        $response->assertOk();
        $response->assertViewIs('note.index');
        $response->assertViewHas('notes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('note.create'));

        $response->assertOk();
        $response->assertViewIs('note.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NoteController::class,
            'store',
            \App\Http\Requests\NoteStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $item_id = $this->faker->randomNumber();
        $item_type = $this->faker->randomElement(/** enum_attributes **/);
        $user_id = $this->faker->randomNumber();

        $response = $this->post(route('note.store'), [
            'title' => $title,
            'item_id' => $item_id,
            'item_type' => $item_type,
            'user_id' => $user_id,
        ]);

        $notes = Note::query()
            ->where('title', $title)
            ->where('item_id', $item_id)
            ->where('item_type', $item_type)
            ->where('user_id', $user_id)
            ->get();
        $this->assertCount(1, $notes);
        $note = $notes->first();

        $response->assertRedirect(route('note.index'));
        $response->assertSessionHas('note.id', $note->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $note = Note::factory()->create();

        $response = $this->get(route('note.show', $note));

        $response->assertOk();
        $response->assertViewIs('note.show');
        $response->assertViewHas('note');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $note = Note::factory()->create();

        $response = $this->get(route('note.edit', $note));

        $response->assertOk();
        $response->assertViewIs('note.edit');
        $response->assertViewHas('note');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NoteController::class,
            'update',
            \App\Http\Requests\NoteUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $note = Note::factory()->create();
        $title = $this->faker->sentence(4);
        $item_id = $this->faker->randomNumber();
        $item_type = $this->faker->randomElement(/** enum_attributes **/);
        $user_id = $this->faker->randomNumber();

        $response = $this->put(route('note.update', $note), [
            'title' => $title,
            'item_id' => $item_id,
            'item_type' => $item_type,
            'user_id' => $user_id,
        ]);

        $note->refresh();

        $response->assertRedirect(route('note.index'));
        $response->assertSessionHas('note.id', $note->id);

        $this->assertEquals($title, $note->title);
        $this->assertEquals($item_id, $note->item_id);
        $this->assertEquals($item_type, $note->item_type);
        $this->assertEquals($user_id, $note->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $note = Note::factory()->create();

        $response = $this->delete(route('note.destroy', $note));

        $response->assertRedirect(route('note.index'));

        $this->assertDeleted($note);
    }
}
