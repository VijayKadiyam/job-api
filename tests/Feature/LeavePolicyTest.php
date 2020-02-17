<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\LeavePolicy;
use App\User;

class LeavePolicyTest extends TestCase
{
  use DatabaseTransactions;

  public function setUp() : void
  {
    parent::setUp();

    $this->user = factory(User::class)->create();

    $this->leave_policy = factory(LeavePolicy::class)->create([
     'user_id'  =>  $this->user->id
    ]);

    $this->payload = [
          'exam'                   =>  'exam1',
          'ipcc_group_1'           =>  'ipcc group11',
          'ipcc_group_2'           =>  'ipcc group12',
          'ca_final_group_1'       =>  'ca final group11',
          'ca_final_group_2'       =>  'ca final group12',
          'ipcc_both_groups'       =>  'ipcc both groups1',
          'ca_final_both_groups'   =>  'ca final both groups1',
      ];
  }

  /** @test */
  function add_requires_following_details()
  {

    $this->json('POST', '/api/users/' . $this->user->id . '/leave_policies', [],$this->headers)
      ->assertStatus(422)
      ->assertExactJson([
        "errors" => [
          "exam"    =>  ["The exam field is required."],       
       ],
       "message" =>"The given data was invalid."
      ]);
  }

  /** @test */
  function add_new_leave_policy()
  {
    $this->disableEH();

    $this->json('POST', '/api/users/' . $this->user->id . '/leave_policies' , $this->payload,$this->headers)
      ->assertStatus(201)
      ->assertJson([
          "data"  => [
              'exam'        =>  'exam1',
           ]
         ])
      ->assertJsonStructureExact([
          'data'  =>  [
          'exam',                  
          'ipcc_group_1',
          'ipcc_group_2',
          'ca_final_group_1',
          'ca_final_group_2',
          'ipcc_both_groups',    
          'ca_final_both_groups',
          'user_id',
          'updated_at',
          'created_at',
           'id',
          ]
      ]);
  }
    /** @test */
  function list_of_office_timings()
  {
    $this->json('GET' , '/api/users/' . $this->user->id . '/leave_policies' , $this->payload,$this->headers)
      ->assertStatus(200)
      ->assertJson([
          "data" => [
              0 => [
                'exam'                   =>  'exam',
                'ipcc_group_1'           =>  'ipcc group1',
                'ipcc_group_2'           =>  'ipcc group2',
                'ca_final_group_1'       =>  'ca final group1',
                'ca_final_group_2'       =>  'ca final group2',
                'ipcc_both_groups'       =>  'ipcc both groups',
                'ca_final_both_groups'   =>  'ca final both groups',
                  ]
                ] 
           ]);
    $this->assertCount(1,LeavePolicy::all());
  }

  /** @test */
  function show_single_leave_policies()
  {
    $this->json('get',  '/api/users/' . $this->user->id . '/leave_policies/' . $this->leave_policy->id,[],$this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data' => [
              'exam'                   =>  'exam',
              'ipcc_group_1'           =>  'ipcc group1',
              'ipcc_group_2'           =>  'ipcc group2',
              'ca_final_group_1'       =>  'ca final group1',
              'ca_final_group_2'       =>  'ca final group2',
              'ipcc_both_groups'       =>  'ipcc both groups',
              'ca_final_both_groups'   =>  'ca final both groups',             ]
    ]);
  }

   /** @test */
  function update_requires_folliowing_details()
  {
    $this->json('patch',  '/api/users/' . $this->user->id . '/leave_policies/' . $this->leave_policy->id, [],$this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
             "exam"    =>  ["The exam field is required."],       
           ],
        "message" => "The given data was invalid."
      ]);
  }          

 /** @test */
  function update_single_leave_policy()
  {
    $payload  = [
        'exam'                   =>  'exam',
        'ipcc_group_1'           =>  'ipcc group1',
        'ipcc_group_2'           =>  'ipcc group2',
        'ca_final_group_1'       =>  'ca final group1',
        'ca_final_group_2'       =>  'ca final group2',
        'ipcc_both_groups'       =>  'ipcc both groups',
        'ca_final_both_groups'   =>  'ca final both groups',     
     ];

     $this->json('patch', '/api/users/' . $this->user->id . '/leave_policies/' . $this->leave_policy->id, $payload,$this->headers)
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          'exam'                   =>  'exam',
          'ipcc_group_1'           =>  'ipcc group1',
          'ipcc_group_2'           =>  'ipcc group2',
          'ca_final_group_1'       =>  'ca final group1',
          'ca_final_group_2'       =>  'ca final group2',
          'ipcc_both_groups'       =>  'ipcc both groups',
          'ca_final_both_groups'   =>  'ca final both groups',    
        ]
    ])
    ->assertJsonStructureExact([
        'data'  =>  [
          'id',
          'user_id',
          'exam',                  
          'ipcc_group_1',
          'ipcc_group_2',
          'ca_final_group_1',
          'ca_final_group_2',
          'ipcc_both_groups',    
          'ca_final_both_groups',
          'created_at',
          'updated_at',
        ]
      ]);    
  }

  /** @test */
  function delete_single_leave_policy()
  {
    $this->json('delete',  '/api/users/' . $this->user->id . '/leave_policies/' . $this->leave_policy->id, [],$this->headers)
      ->assertStatus(200);

    $this->assertCount(0, LeavePolicy::all());
  }

}
