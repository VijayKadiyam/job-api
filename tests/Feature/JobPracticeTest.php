<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Practice;
use App\Job;

class JobPracticeTest extends TestCase
{
    use DatabaseTransactions;

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/job_practice', [])
      ->assertStatus(422)
      ->assertExactJson([
          "errors"     =>  [
            "job_id"         =>  ["The job id field is required."],
            "practice_ids"   =>  ["The practice ids field is required."]
          ],
          "message"      =>  "The given data was invalid."
        ]);
  }

   /** @test */
  function assign_job()  { 

    $jobTwo  = factory(\App\Job::class)->create();
    $practice  = factory(\App\Practice::class)->create();
    $jobTwo->assignPractice([1]);
    $check    = $jobTwo->hasPractice(1);
    $this->assertTrue($check);
  }

  /** @test */
function assign_practice_to_job()
{
$this->disableEH();
    $jobTwo       = factory(\App\Job::class)->create();
    $practice  = factory(\App\Practice::class)->create();
    $this->payload = [ 
      'job_id'    => $jobTwo->id,
      'practice_ids'         => [
        1
      ]
    ];

    $this->json('post', '/api/job_practice', $this->payload)
      ->assertStatus(201)
      ->assertJson([
          'data'  =>  [
            'title'                    =>  $jobTwo->title,
            'practices'                 =>  [
              0 =>  [
                'name'  => 'Vijay'
              ]
            ]
          ]
        ])
      ->assertJsonStructureExact([
        'data'  =>  [
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
}
