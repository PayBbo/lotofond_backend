<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MonitoringController
 */
class MonitoringControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $monitorings = Monitoring::factory()->count(3)->create();

        $response = $this->get(route('monitoring.index'));

        $response->assertOk();
        $response->assertViewIs('monitoring.index');
        $response->assertViewHas('monitorings');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('monitoring.create'));

        $response->assertOk();
        $response->assertViewIs('monitoring.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MonitoringController::class,
            'store',
            \App\Http\Requests\MonitoringStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $user_id = $this->faker->randomNumber();
        $title = $this->faker->sentence(4);
        $not_frequency = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('monitoring.store'), [
            'user_id' => $user_id,
            'title' => $title,
            'not_frequency' => $not_frequency,
        ]);

        $monitorings = Monitoring::query()
            ->where('user_id', $user_id)
            ->where('title', $title)
            ->where('not_frequency', $not_frequency)
            ->get();
        $this->assertCount(1, $monitorings);
        $monitoring = $monitorings->first();

        $response->assertRedirect(route('monitoring.index'));
        $response->assertSessionHas('monitoring.id', $monitoring->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $monitoring = Monitoring::factory()->create();

        $response = $this->get(route('monitoring.show', $monitoring));

        $response->assertOk();
        $response->assertViewIs('monitoring.show');
        $response->assertViewHas('monitoring');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $monitoring = Monitoring::factory()->create();

        $response = $this->get(route('monitoring.edit', $monitoring));

        $response->assertOk();
        $response->assertViewIs('monitoring.edit');
        $response->assertViewHas('monitoring');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MonitoringController::class,
            'update',
            \App\Http\Requests\MonitoringUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $monitoring = Monitoring::factory()->create();
        $user_id = $this->faker->randomNumber();
        $title = $this->faker->sentence(4);
        $not_frequency = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('monitoring.update', $monitoring), [
            'user_id' => $user_id,
            'title' => $title,
            'not_frequency' => $not_frequency,
        ]);

        $monitoring->refresh();

        $response->assertRedirect(route('monitoring.index'));
        $response->assertSessionHas('monitoring.id', $monitoring->id);

        $this->assertEquals($user_id, $monitoring->user_id);
        $this->assertEquals($title, $monitoring->title);
        $this->assertEquals($not_frequency, $monitoring->not_frequency);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $monitoring = Monitoring::factory()->create();

        $response = $this->delete(route('monitoring.destroy', $monitoring));

        $response->assertRedirect(route('monitoring.index'));

        $this->assertDeleted($monitoring);
    }
}
