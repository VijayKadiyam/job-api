<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordResetTest extends TestCase
{
  use DatabaseTransactions;

  /** @test */
  function password_resets_requires_email_token()
  {
    $this->json('post', '/api/reset_password', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"   =>  [
            "email"     =>  ["The email field is required."] ,
            "password"  =>  ["The password field is required."]
          ],
          "message"  =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function reset_password()
  {
    $this->disableEH();

    $payLoad  = [
      'email'                 => $this->user->email,
      'password'              => '1234567',
      'password_confirmation' => '1234567',
    ];
    
    $this->json('post', '/api/reset_password', $payLoad, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'    => [
            'email' => $this->user->email
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [
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
          ]
        ]);
  }
}
