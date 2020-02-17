<?php

use Faker\Generator as Faker;
use App\Job;

$factory->define(Job::class, function (Faker $faker) {
    return [
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
    ];
});
