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
            "practice_id"    =>  ["The practice id field is required."]
          ],
          "message"      =>  "The given data was invalid."
        ]);
  }

   /** @test */
  function assign_job()
  { 

    $practiceTwo  = factory(\App\Practice::class)->create();
    $job  = factory(\App\Job::class)->create();
    $practiceTwo->assignJob(1);
    $check    = $practiceTwo->hasJob(1);
    $this->assertTrue($check);
  }

  /** @test */
function assign_job_to_practice()
{
$this->disableEH();
    $practiceTwo       = factory(\App\Practice::class)->create();
    $job  = factory(\App\Job::class)->create();
    $this->payload = [ 
      'practice_id'    => $practiceTwo->id,
      'job_id'         => 1
    ];

    $this->json('post', '/api/job_practice', $this->payload)
      ->assertStatus(201)
      ->assertJson([
          'data'  =>  [
            'name'                    =>  $practiceTwo->name,
            'jobs'                 =>  [
              0 =>  [
                'title'  => 'title'
              ]
            ]
          ]
        ])
      ->assertJsonStructureExact([
        'data'  =>  [
          'id',
          'company_id',
          'name',
          'created_at',
          'updated_at',
          'jobs',
        ],
        'success'
      ]);
  }
}
