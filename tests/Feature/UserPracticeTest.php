<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Practice;
use App\User;

class UserPracticeTest extends TestCase
{
  use DatabaseTransactions;

  /** @test */
  function user_requires_business_and_user()
  {
    $this->json('post', '/api/user_practice', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"     =>  [
            "user_id"           =>  ["The user id field is required."],
            "practice_ids"      =>  ["The practice ids field is required."]
          ],
          "message"        =>  "The given data was invalid."
        ]);
  }

   /** @test */
  function assign_user()
  { 
    $userTwo  = factory(\App\User::class)->create();
    $practice  = factory(\App\Practice::class)->create();
    $userTwo->assignPractice([1]);
    $check    = $userTwo->hasPractice(1);
    $this->assertTrue($check);
  }

     /** @test */
  function assign_practice_to_user()
  {
    $this->disableEH();
    $userTwo = factory(\App\User::class)->create();
    $practice  = factory(\App\Practice::class)->create();
    $this->payload      = [ 
      'user_id'       => $userTwo->id,
      'practice_ids'  => [
        1
      ]
    ];
    $this->json('post', '/api/user_practice', $this->payload , $this->headers)
      ->assertStatus(201)
      ->assertJson([
            'data'  =>  [
              'name'                    =>  $userTwo->name,
              'practices'                   =>  [
                0 =>  [
                  'name'  => 'Vijay'
                ]
              ]
            ]
          ])
        ->assertJsonStructureExact([
          'data'  =>  [
            'id',
            'name',
            'email',
            'email_verified_at',
            'active',
            'phone',
            'qualification_id',
            'address',
            'organigation_name',
            'organigation_address',
            'gstn',
            'year_of_establishment',
            'no_of_partners',
            'total_no_of_people',
            'description',
            'transfer_policy',
            'training_policy',
            'leave_compensation',
            'dob',
            'gender',
            'marital_status',
            'passing_marks_10',
            'total_marks_10',
            'passing_marks_12',
            'total_marks_12',
            'cpt_passing_year',
            'cpt_marks',
            'cpt_attempts',
            'ipcc_group_1_passing_year',
            'ipcc_group_1_marks',
            'ipcc_group_1_attempts',
            'ipcc_group_2_passing_marks',
            'ipcc_group_2_marks',
            'ipcc_group_2_attempts',
            'entry_scheme',
            'icitss_passed',
            'icitss_passing_marks',
            'icitss_total_marks',
            'other_training_details',
            'outstation_travel',
            'api_token',
            'created_at',
            'updated_at',
            'practices',
          ],
          'success'
        ]);
  }
}
