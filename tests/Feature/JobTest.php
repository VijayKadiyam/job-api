<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Company;
use App\Job;
use App\Qualification;
use App\User;

class JobTest extends TestCase
{
 use DatabaseTransactions;

  public function setUp() : void
  {
    parent::setUp();

    $this->company = factory(\App\Company::class)->create([
           'name' => 'test'
    ]);

    $this->user->assignCompany($this->company->id);

    $this->headers['company-id'] = $this->company->id;

    $this->user            =  factory(User::class)->create();
    $this->qualification   =  factory(Qualification::class)->create();


     $this->job            = factory(\App\Job::class)->create([
      'company_id'        =>  $this->company->id,
      'user_id'           =>  $this->user->id,
      'qualification_id'  =>  $this->qualification->id,
    ]);

    $this->payload = [ 
        'title'                    =>  'title1',
        'highlight'                =>  'highlight1',
        'no_of_openings'           =>  'no of openings1',
        'experience'               =>  'experience1',
        'address'                  =>  'address1',
        'stipend_start'            =>  'stipend start1',
        'stipend_end'              =>  'stipend end1',
        'department'               =>  'department1',
        'max_attempts_in_ca_exam'  =>  'max attempts in ca exam1',
        'status'                   =>  'status1',
        'user_id'                  =>  $this->user->id,
        'qualification_id'         =>  $this->qualification->id,
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/jobs')
        ->assertStatus(401); 
  }

   /** @test */
  function it_requires_following_details()
  { 
    $this->json('post', '/api/jobs', [], $this->headers)
        ->assertStatus(422)
        ->assertExactJson([
       "errors"       =>  [  
          "title"        =>  ["The title field is required."],      
        ],
        "message"     =>  "The given data was invalid."
      ]);
  }

  /** @test */
  function add_new_jobs()
  {  
    $this->json('post', '/api/jobs', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'   =>[
            'title'  =>  'title1',
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [              
              'title',
              'highlight',
              'no_of_openings',
              'experience',
              'address',
              'stipend_start',
              'stipend_end',
              'department',
              'max_attempts_in_ca_exam',
              'status',
              'user_id',
              'qualification_id',
              'company_id',
              'updated_at',
              'created_at',
              'id'
          ],
          'success'
        ]); 
  }

   /** @test */
  function list_of_jobs()
  {     
    $this->json('GET', '/api/jobs',[], $this->headers)
       ->assertStatus(200)
       ->assertJsonStructure([
        'data' => [
          0 => [              
              'title',
              'highlight',
              'no_of_openings',
              'experience',
              'address',
              'stipend_start',
              'stipend_end',
              'department',
              'max_attempts_in_ca_exam',
              'status',
              'user_id',
              'qualification_id',
              'company_id',      
          ] 
        ]
  ]);

    $this->assertCount(1, Job::all());
  }

  /** @test */
  function show_single_job()
  {
    $this->json('get', "/api/jobs/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
      'data'  => [
          'title'                    =>  'title',
          'highlight'                =>  'highlight',
          'no_of_openings'           =>  'no of openings',
          'experience'               =>  'experience',
          'address'                  =>  'address',
          'stipend_start'            =>  'stipend start',
          'stipend_end'              =>  'stipend end',
          'department'               =>  'department',
          'max_attempts_in_ca_exam'  =>  'max attempts in ca exam',
          'status'                   =>  'status',    
      ]
    ])
     ->assertJsonStructureExact([
          'data'   => [  
              'id',
              'company_id',
              'user_id',
              'qualification_id',
              'title',
              'highlight',
              'no_of_openings',
              'experience',
              'address',
              'stipend_start',
              'stipend_end',
              'department',
              'max_attempts_in_ca_exam',
              'status',            
              'created_at',
              'updated_at',
              'practices',
          ],
          'success'
        ]); 
  }



  /** @test */
  function update_single_job()
  {
    $this->disableEH();
    $payload  = [
      'title'                    =>  'title2',
      'highlight'                =>  'highlight2',
      'no_of_openings'           =>  'no of openings2',
      'experience'               =>  'experience2',
      'address'                  =>  'address2',
      'stipend_start'            =>  'stipend start2',
      'stipend_end'              =>  'stipend end2',
      'department'               =>  'department2',
      'max_attempts_in_ca_exam'  =>  'max attempts in ca exam2',
      'status'                   =>  'status2',    
    ];

    $this->json('patch', '/api/jobs/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    => [
             'title'  =>  'title2',
          ]
       ])
      ->assertJsonStructureExact([
          'data'  => [
            'id',
            'company_id', 
            'user_id',
            'qualification_id',
            'title',
            'highlight',
            'no_of_openings',
            'experience',
            'address',
            'stipend_start',
            'stipend_end',
            'department',
            'max_attempts_in_ca_exam',
            'status',    
            'created_at',
            'updated_at',       
          ],
          'success'
      ]);
  }


  /** @test */
  function delete_single_job()
  {
    $this->json('delete', '/api/jobs/1', [], $this->headers)
    ->assertStatus(200);

     $this->assertCount(0, Job::all());        
  }
}
