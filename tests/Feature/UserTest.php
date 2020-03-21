<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
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

    $this->payload = [ 
      'name'                       =>'sangeetha',
      'phone'                      => 9844778380,
      'email'                      =>'sangeetha@gmail.com',
      'address'                    =>  'address1',
      'organigation_name'          =>  'organigation_name1',
      'organigation_address'       =>  'organigation_address1',
      'gstn'                       =>  'gstn1',
      'year_of_establishment'      =>  'year_of_establishment1',
      'no_of_partners'             =>  'no_of_partners1',
      'total_no_of_people'         =>  'address1',
      'description'                =>  'description1',
      'transfer_policy'            =>  'transfer_policy1',
      'training_policy'            =>  'training_policy1',
      'leave_compensation'         =>  'leave_compensation1',
      'dob'                        =>  'dob1',
      'gender'                     =>  'gender1',
      'marital_status'             =>  'marital_status1',
      'passing_marks_10'           =>  'passing_marks1_10',
      'total_marks_10'             =>  'total_marks1_10',
      'passing_marks_12'           =>  'passing_marks1_12',
      'total_marks_12'             =>  'total_marks1_12',
      'cpt_passing_year'           =>  'cpt_passing_year1',
      'cpt_marks'                  =>  'cpt_marks1',
      'cpt_attempts'               =>  'cpt_attempts1',
      'ipcc_group_1_passing_year'  =>  'ipcc_group_1_passing_year1',
      'ipcc_group_1_marks'         =>  'ipcc_group_1_marks1',
      'ipcc_group_1_attempts'      =>  'ipcc_group_1_attempts1',
      'ipcc_group_2_passing_marks' =>  'ipcc_group_2_passing_marks1',
      'ipcc_group_2_marks'         =>  'ipcc_group_2_marks1',
      'ipcc_group_2_attempts'      =>  'ipcc_group_2_attempts1',
      'entry_scheme'               =>  'entry_scheme1',
      'icitss_passed'              =>  'icitss_passed1',
      'icitss_passing_marks'       =>  'icitss_passing_marks1',
      'icitss_total_marks'         =>  'icitss_total_marks1',
      'other_training_details'     =>  'other_training_details1',
      'outstation_travel'          =>  'outstation_travel1',
    ];
  }

  /** @test */
  function user_must_be_logged_in()
  {
    $this->json('post', '/api/users')
         ->assertStatus(401);
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/users', [], $this->headers)
         ->assertStatus(422)
         ->assertExactJson([
            "errors"  =>  [
              "name"   =>  ["The name field is required."],
              "email"  =>  ["The email field is required."],
              "phone"  =>  ["The phone field is required."],
            ],
            "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function add_new_user()
  {
    $this->disableEH();
    $this->json('post', '/api/users', $this->payload, $this->headers)
     ->assertStatus(201)
     ->assertJson([
        'data'  =>  [
          'name'                 =>'sangeetha',
          'phone'                => 9844778380,
          'email'                =>'sangeetha@gmail.com'
        ]
      ])
      ->assertJsonStructure([
          'data'  =>  [
            'name',
            'phone',
            'email',
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
            'passing_marks_10',
            'total_marks_10',
            'passing_marks_12',
            'total_marks_12',
            'cpt_passing_year',
            'cpt_marks','cpt_attempts',
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
            'outstation_travel'             
          ]
        ])
      ->assertJsonStructureExact([
          'data'  =>  [
            'name',
            'phone',
            'email',
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
            'passing_marks_10',
            'total_marks_10',
            'passing_marks_12',
            'total_marks_12',
            'cpt_passing_year',
            'cpt_marks','cpt_attempts',
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
            'updated_at',
            'created_at',
            'id',
          ],
          'success'
        ]);
  }

  /** @test */
  public function list_of_users()
  {
    $this->disableEH();
    $user = factory(\App\User::class)->create();
    $user->assignRole(3);
    $user->assignCompany($this->company->id);

    $this->json('get', '/api/users?role_id=3', [], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => []
        ]);
    $this->assertCount(1, User::whereHas('roles',  function($q) {
                                $q->where('name', '!=', 'Admin');
                                $q->where('name', '!=', 'Super Admin');
                              })->get());
  }

  /** @test */
  function show_single_user_details()
  {
    $this->disableEH();
    $this->json('get', "/api/users/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data'  =>  [
            'name',
            'phone',
            'email' ,
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
            'passing_marks_10',
            'total_marks_10',
            'passing_marks_12',
            'total_marks_12',
            'cpt_passing_year',
            'cpt_marks','cpt_attempts',
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
            'outstation_travel'           
          ],
          'success'
        ]);
  }

  /** @test */
  function update_single_user_details()
  {
    $this->disableEH();
    $payload  = [ 
      'name'                       =>  'sangeetha',
      'phone'                      =>  9088597123,
      'email'                      =>  'preethi@gmail.com',
      'address'                    =>  'address',
      'organigation_name'          =>  'organigation_name',
      'organigation_address'       =>  'organigation_address',
      'gstn'                       =>  'gstn',
      'year_of_establishment'      =>  'year_of_establishment',
      'no_of_partners'             =>  'no_of_partners',
      'total_no_of_people'         =>  'address',
      'description'                =>  'description',
      'transfer_policy'            =>  'transfer_policy',
      'training_policy'            =>  'training_policy',
      'leave_compensation'         =>  'leave_compensation',
      'dob'                        =>  'dob',
      'gender'                     =>  'gender',
      'marital_status'             =>  'marital_status',
      'passing_marks_10'           =>  'passing_marks_10',
      'total_marks_10'             =>  'total_marks_10',
      'passing_marks_12'           =>  'passing_marks_12',
      'total_marks_12'             =>  'total_marks_12',
      'cpt_passing_year'           =>  'cpt_passing_year',
      'cpt_marks'                  =>  'cpt_marks',
      'cpt_attempts'               =>  'cpt_attempts',
      'ipcc_group_1_passing_year'  =>  'ipcc_group_1_passing_year',
      'ipcc_group_1_marks'         =>  'ipcc_group_1_marks',
      'ipcc_group_1_attempts'      =>  'ipcc_group_1_attempts',
      'ipcc_group_2_passing_marks' =>  'ipcc_group_2_passing_marks',
      'ipcc_group_2_attempts'      =>  'ipcc_group_2_attempts',
      'entry_scheme'               =>  'entry_scheme',
      'icitss_passed'              =>  'icitss_passed',
      'icitss_passing_marks'       =>  'icitss_passing_marks',
      'icitss_total_marks'         =>  'icitss_total_marks',
      'other_training_details'     =>  'other_training_details',
      'outstation_travel'          =>  'outstation_travel',


    ];
    $this->json('patch', '/api/users/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    =>  [
            'phone' =>  9088597123,
            'email' =>  'preethi@gmail.com'
          ]
        ])
      ->assertJsonStructureExact([
          'data'  => [
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
            'leave_compensation' ,
            'dob',
            'gender',
            'marital_status',
            'passing_marks_10',
            'total_marks_10',
            'passing_marks_12',
            'total_marks_12',
            'cpt_passing_year',
            'cpt_marks','cpt_attempts',
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
            'outstation_travel' ,
            'api_token',
            'created_at',
            'updated_at',
            'roles',
            'companies',         
          ],
          'success'
        ]);
  }

 
}
