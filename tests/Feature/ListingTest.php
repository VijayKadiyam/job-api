<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Listing;

class ListingTest extends TestCase
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
      'product_id'  =>  $this->product->id,
      'email_html'  =>  '<b>Hi</b>'
    ]);

    factory(\App\SubProduct::class)->create([
      'product_id'  =>  $this->product->id 
    ]);

    

    $this->payload = [ 
      'name'     =>  'Sify'
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/listings')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/listings', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
            "name"    =>  ["The name field is required."]
          ],
          "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function add_new_listing()
  {
    $this->disableEH();
    $this->json('post', '/api/listings', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'   =>[
            'name' => 'Sify'
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [
            'name',
            'company_id',
            'updated_at',
            'created_at',
            'id'
          ],
          'success'
        ]);
  }

  /** @test */
  function list_of_listings()
  {
    $this->disableEH();
    $this->json('GET', '/api/listings',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0=>[
              'name'
            ] 
          ]
        ]);
      $this->assertCount(1, Listing::all());
  }

  /** @test */
  function show_single_listing()
  {
    $this->disableEH();
    $this->json('get', "/api/listings/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
            'name'=> 'Capricorn',
          ]
        ]);
  }

  /** @test */
  function update_single_listing()
  {
    $this->disableEH();
    $payload = [ 
      'name'  =>  'Sify'
    ];

    $this->json('patch', '/api/listings/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    => [
            'name'  =>  'Sify',
          ]
       ])
      ->assertJsonStructureExact([
          'data'  => [
            'id',
            'company_id',
            'name',
            'created_at',
            'updated_at'
          ]
      ]);
  }
}
