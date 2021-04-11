<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertViewIs('product.index');
        $response->assertViewHas('products');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('product.create'));

        $response->assertOk();
        $response->assertViewIs('product.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ProductController::class,
            'store',
            \App\Http\Requests\Api\ProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $detail = $this->faker->text;
        $price = $this->faker->numberBetween(-10000, 10000);
        $discount = $this->faker->numberBetween(-10000, 10000);
        $stock = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('product.store'), [
            'title' => $title,
            'detail' => $detail,
            'price' => $price,
            'discount' => $discount,
            'stock' => $stock,
        ]);

        $products = Product::query()
            ->where('title', $title)
            ->where('detail', $detail)
            ->where('price', $price)
            ->where('discount', $discount)
            ->where('stock', $stock)
            ->get();
        $this->assertCount(1, $products);
        $product = $products->first();

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('product.id', $product->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', $product));

        $response->assertOk();
        $response->assertViewIs('product.show');
        $response->assertViewHas('product');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.edit', $product));

        $response->assertOk();
        $response->assertViewIs('product.edit');
        $response->assertViewHas('product');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\ProductController::class,
            'update',
            \App\Http\Requests\Api\ProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $product = Product::factory()->create();
        $title = $this->faker->sentence(4);
        $detail = $this->faker->text;
        $price = $this->faker->numberBetween(-10000, 10000);
        $discount = $this->faker->numberBetween(-10000, 10000);
        $stock = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('product.update', $product), [
            'title' => $title,
            'detail' => $detail,
            'price' => $price,
            'discount' => $discount,
            'stock' => $stock,
        ]);

        $product->refresh();

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('product.id', $product->id);

        $this->assertEquals($title, $product->title);
        $this->assertEquals($detail, $product->detail);
        $this->assertEquals($price, $product->price);
        $this->assertEquals($discount, $product->discount);
        $this->assertEquals($stock, $product->stock);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertRedirect(route('product.index'));

        $this->assertSoftDeleted($product);
    }
}
