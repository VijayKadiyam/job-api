<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Retailer;

class RetailerTest extends TestCase
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

    factory(Retailer::class)->create([
      'company_id'  =>  $this->company->id 
    ]);

    $this->payload = [ 
      'name'     =>  'Retailer 2',
      'address'   =>  'address 2'
    ];
  }

    /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/retailers')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/retailers', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
            "name"    =>  ["The name field is required."],
            "address"    =>  ["The address field is required."]
          ],
          "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function add_new_retailer()
  {
    $this->disableEH();
    $this->json('post', '/api/retailers', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'   =>[
            'name' => 'Retailer 2'
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [
            'name',
            'address',
            'company_id',
            'updated_at',
            'created_at',
            'id'
          ]
        ]);
  }

  /** @test */
  function list_of_retailers()
  {
    $this->json('GET', '/api/retailers',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0=>[
              'name'
            ] 
          ]
        ]);
      $this->assertCount(1, Retailer::all());
  }

  /** @test */
  function show_single_retailer()
  {
    $this->json('get', "/api/retailers/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
            'name'=> 'Retailer 1',
          ]
        ]);
  }

  /** @test */
  function update_single_retailer()
  {
    $payload = [ 
      'name'  =>  'Retailer 1 updated'
    ];

    $this->json('patch', '/api/retailers/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    => [
            'name'  =>  'Retailer 1 updated',
          ]
       ])
      ->assertJsonStructureExact([
          'data'  => [
            'id',
            'company_id',
            'name',
            'address',
            'created_at',
            'updated_at'
          ]
      ]);
  }
}
