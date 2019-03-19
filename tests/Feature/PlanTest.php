<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Plan;

class PlanTest extends TestCase
{
  use DatabaseTransactions;
  
  public function setUp()
  {
    parent::setUp();

    factory(Plan::class)->create([
      'user_id'  =>  $this->user->id 
    ]);

    $this->payload = [ 
      'date'  =>  '2019-03-02',
      'plan'  =>  'Mumbai'
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/plans')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/plans', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
            "date"  =>  ["The date field is required."],
            "plan"  =>  ["The plan field is required."]
          ],
          "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function add_new_plan()
  {
    $this->disableEH();
    $this->json('post', '/api/plans', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'   =>[
            'date'  =>  '2019-03-02',
            'plan'  =>  'Mumbai'
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [
            'date',
            'plan',
            'user_id',
            'updated_at',
            'created_at',
            'id'
          ],
          'success'
        ]);
  }

  /** @test */
  function list_of_plans()
  {
    $this->json('GET', '/api/plans',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0=>[
              'date'
            ] 
          ]
        ]);
      $this->assertCount(1, Plan::all());
  }

  /** @test */
  function show_single_plan()
  {
    $this->disableEH();
    $this->json('get', "/api/plans/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
            'date' => '2019-03-02',
          ]
        ]);
  }

  /** @test */
  function update_single_plan()
  {
    $this->disableEH();
    $payload = [ 
      'date' => '2019-03-02',
      'plan'  =>  'Mumbai Updated'
    ];

    $this->json('patch', '/api/plans/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    => [
            'plan'  =>  'Mumbai Updated'
          ]
       ])
      ->assertJsonStructureExact([
          'data'  => [
            'id',
            'user_id',
            'date',
            'plan',
            'created_at',
            'updated_at',
          ],
          'success'
      ]);
  }
}
