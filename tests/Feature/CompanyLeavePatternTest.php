<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyLeavePatternTest extends TestCase
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
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/company_leave_pattern')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_fields()
  {
    $this->json('post', '/api/company_leave_pattern', [], $this->headers)
         ->assertStatus(422)
         ->assertExactJson([
            "errors"            =>  [
              "company_id" =>  ["The company id field is required."],
              "leave_pattern_id"    =>  ["The leave pattern id field is required."]
            ],
            "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function assign_leave_pattern()
  {
    $company = factory(\App\Company::class)->create();
    $company->assignLeavePattern(1);
    $check = $company->hasLeavePattern(1);
    $this->assertTrue($check);
  }

  /** @test */
  function assign_leave_pattern_to_company()
  {
    $this->disableEH();
    $company = factory(\App\Company::class)->create();
    $this->payload      = [ 
      'leave_pattern_id'    => 1,
      'company_id' => $company->id
    ];
    $this->json('post', '/api/company_leave_pattern', $this->payload , $this->headers)
      ->assertStatus(201)
      ->assertJson([
            'data'  =>  [
              'name'  =>  $company->name
            ]
          ])
        ->assertJsonStructureExact([
          'data'  =>  [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'logo_path',
            'contact_person',
            'created_at',
            'updated_at',
            'leave_patterns'
          ]
        ]);;;
  }
}
