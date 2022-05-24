<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 */
class EventControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $events = Event::factory()->count(3)->create();

        $response = $this->get(route('event.index'));

        $response->assertOk();
        $response->assertViewIs('event.index');
        $response->assertViewHas('events');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('event.create'));

        $response->assertOk();
        $response->assertViewIs('event.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'store',
            \App\Http\Requests\EventStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $date = $this->faker->date();
        $time = $this->faker->time();
        $title = $this->faker->sentence(4);
        $event_type_id = $this->faker->randomNumber();
        $user_id = $this->faker->randomNumber();

        $response = $this->post(route('event.store'), [
            'date' => $date,
            'time' => $time,
            'title' => $title,
            'event_type_id' => $event_type_id,
            'user_id' => $user_id,
        ]);

        $events = Event::query()
            ->where('date', $date)
            ->where('time', $time)
            ->where('title', $title)
            ->where('event_type_id', $event_type_id)
            ->where('user_id', $user_id)
            ->get();
        $this->assertCount(1, $events);
        $event = $events->first();

        $response->assertRedirect(route('event.index'));
        $response->assertSessionHas('event.id', $event->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('event.show', $event));

        $response->assertOk();
        $response->assertViewIs('event.show');
        $response->assertViewHas('event');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('event.edit', $event));

        $response->assertOk();
        $response->assertViewIs('event.edit');
        $response->assertViewHas('event');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'update',
            \App\Http\Requests\EventUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $event = Event::factory()->create();
        $date = $this->faker->date();
        $time = $this->faker->time();
        $title = $this->faker->sentence(4);
        $event_type_id = $this->faker->randomNumber();
        $user_id = $this->faker->randomNumber();

        $response = $this->put(route('event.update', $event), [
            'date' => $date,
            'time' => $time,
            'title' => $title,
            'event_type_id' => $event_type_id,
            'user_id' => $user_id,
        ]);

        $event->refresh();

        $response->assertRedirect(route('event.index'));
        $response->assertSessionHas('event.id', $event->id);

        $this->assertEquals(Carbon::parse($date), $event->date);
        $this->assertEquals($time, $event->time);
        $this->assertEquals($title, $event->title);
        $this->assertEquals($event_type_id, $event->event_type_id);
        $this->assertEquals($user_id, $event->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $event = Event::factory()->create();

        $response = $this->delete(route('event.destroy', $event));

        $response->assertRedirect(route('event.index'));

        $this->assertDeleted($event);
    }
}
