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

    $this->company = factory(\App\Company::class)->create([
      'name' => 'test'
    ]);
    $this->user->assignCompany($this->company->id);
    $this->headers['company-id'] = $this->company->id;

    $this->allowanceType = factory(\App\AllowanceType::class)->create([
      'company_id'  =>  $this->company->id 
    ]);

    $this->payload = [ 
      'allowance_type_id' =>  $this->allowanceType->id,
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
            "allowance_type_id"  =>  ["The allowance type id field is required."],
            "date"               =>  ["The date field is required."],
            "plan"               =>  ["The plan field is required."]
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
            'allowance_type_id',
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
  function list_of_plan_of_request_user()
  {
    $this->json('GET', '/api/plans?user_id=' . $this->user->id,[], $this->headers)
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
            'allowance_type_id',
          ],
          'success'
      ]);
  }
}
