<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\SubProduct;

class SubProductTest extends TestCase
{
  use DatabaseTransactions;
  
  public function setUp()
  {
    parent::setUp();

    $this->company = factory(\App\Company::class)->create([
      'name' => 'test'
    ]);
    $this->user->assignCompany($this->company->id);
    $this->headers['company-id'] = $this->company->id;

    $this->listing = factory(\App\Listing::class)->create([
      'company_id'  =>  $this->company->id 
    ]);

    $this->product = factory(\App\Product::class)->create([
      'listing_id'  =>  $this->listing->id 
    ]);

    factory(\App\SubProduct::class)->create([
      'product_id'  =>  $this->product->id 
    ]);

    $this->payload = [ 
      'name'     =>  'Sub Product 2',
      'position'  =>  1
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/products/' . $this->product->id . '/sub_products')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/products/' . $this->product->id . '/sub_products', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
            "name"    =>  ["The name field is required."],
            "position"    =>  ["The position field is required."],
          ],
          "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function add_new_sub_product()
  {
    $this->disableEH();
    $this->json('post', '/api/products/' . $this->product->id . '/sub_products', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'   =>[
            'name' => 'Sub Product 2',
            'position'  =>  1
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [
            'name',
            'position',
            'product_id',
            'updated_at',
            'created_at',
            'id'
          ]
        ]);
  }

  /** @test */
  function list_of_sub_products()
  {
    $this->json('GET', '/api/products/' . $this->product->id . '/sub_products', [], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0=>[
              'name'
            ] 
          ]
        ]);
      $this->assertCount(1, SubProduct::all());
  }

  /** @test */
  function show_single_sub_product()
  {
    $this->disableEH();
    $this->json('get', '/api/products/' . $this->product->id . '/sub_products/1', [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
            'name'=> 'Sub Product 1',
          ]
        ]);
  }

  /** @test */
  function update_single_sun_product()
  {
    $this->disableEH();
    $payload = [ 
      'name'  =>  'Sub Product 1 Updated'
    ];

    $this->json('patch', '/api/products/' . $this->product->id . '/sub_products/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    => [
            'name'  =>  'Sub Product 1 Updated',
          ]
       ])
      ->assertJsonStructureExact([
          'data'  => [
            'id',
            'product_id',
            'name',
            'position',
            'email_html',
            'image1_path',
            'image2_path',
            'image3_path',
            'image4_path',
            'created_at',
            'updated_at',
            'email_subject',
            'description',
            'image1_description',
            'image2_description',
            'image3_description',
            'image4_description',
          ]
      ]);
  }
}
