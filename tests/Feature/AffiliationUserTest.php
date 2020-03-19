<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AffiliationUserTest extends TestCase
{
   use DatabaseTransactions;

  /** @test */
  function it_requires_following_fields()
  {
    $this->json('post', '/api/affiliation_user', [], $this->headers)
       ->assertStatus(422)
       ->assertExactJson([
          "errors"            =>  [
            "affiliation_id" =>  ["The affiliation id field is required."],
            "user_id"        =>  ["The user id field is required."]
          ],
          "message" =>  "The given data was invalid."
      ]);
  }
  /** @test */
  function assign_Affiliation()
  {
    $userTwo = factory(\App\User::class)->create();
    $affiliation = factory(\App\Affiliation::class)->create();
    $userTwo->assignAffiliation($affiliation->id);
    $check = $userTwo->hasAffiliation($affiliation->id);
    $this->assertTrue($check);
  }

    /** @test */
  function assign_affiliation_to_user()
  {
    $this->disableEH();
    $userTwo = factory(\App\User::class)->create();
    $affiliation = factory(\App\Affiliation::class)->create();
    $this->payload      = [ 
      'user_id'    => $userTwo->id,
      'affiliation_id' => $affiliation->id
    ];
    $this->json('post', '/api/affiliation_user', $this->payload , $this->headers)
      ->assertStatus(201)
      ->assertJson([
            'data'  =>  [
              'name'                    =>  $userTwo->name,
              'phone'                   =>  $userTwo->phone,
              'email'                   =>  $userTwo->email,
              'affiliations'                   =>  [
                0 =>  [
                  'name'  =>  $affiliation->name
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
            'address',
            'organigation_name',
            'organigation_address',
            'gstn',
            'year_of_establishment',
            'no_of_partners',
            'total_no_of_people',
            'description',
            'transfer_policy',
            'training_policy' ,
            'leave_compensation', 
            'dob',
            'gender',
            'marital_status',
            '10_passing_marks',
            '10_total_marks',
            '12_passing_marks',
            '12_total_marks',
            'cpt_passing_year',
            'cpt_marks','cpt_attempts',
            'ipcc_group_1_passing_year',
            'ipcc_group_1_marks',
            'ipcc_group_1_attempts',
            'ipcc_group_2_passing_marks',
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
            'affiliations',
          ],
          'success'
        ]);
  }
  
}
