<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ReviewController
 */
class ReviewControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $reviews = Review::factory()->count(3)->create();

        $response = $this->get(route('review.index'));

        $response->assertOk();
        $response->assertViewIs('review.index');
        $response->assertViewHas('reviews');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('review.create'));

        $response->assertOk();
        $response->assertViewIs('review.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ReviewController::class,
            'store',
            \App\Http\Requests\Api\ReviewStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $review = $this->faker->text;

        $response = $this->post(route('review.store'), [
            'review' => $review,
        ]);

        $reviews = Review::query()
            ->where('review', $review)
            ->get();
        $this->assertCount(1, $reviews);
        $review = $reviews->first();

        $response->assertRedirect(route('review.index'));
        $response->assertSessionHas('review.id', $review->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $review = Review::factory()->create();

        $response = $this->get(route('review.show', $review));

        $response->assertOk();
        $response->assertViewIs('review.show');
        $response->assertViewHas('review');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $review = Review::factory()->create();

        $response = $this->get(route('review.edit', $review));

        $response->assertOk();
        $response->assertViewIs('review.edit');
        $response->assertViewHas('review');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ReviewController::class,
            'update',
            \App\Http\Requests\Api\ReviewUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $review = Review::factory()->create();
        $review = $this->faker->text;

        $response = $this->put(route('review.update', $review), [
            'review' => $review,
        ]);

        $review->refresh();

        $response->assertRedirect(route('review.index'));
        $response->assertSessionHas('review.id', $review->id);

        $this->assertEquals($review, $review->review);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $review = Review::factory()->create();

        $response = $this->delete(route('review.destroy', $review));

        $response->assertRedirect(route('review.index'));

        $this->assertDeleted($review);
    }
}
