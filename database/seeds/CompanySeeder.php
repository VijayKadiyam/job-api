<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Company::create([
      'name'    => 'HyperxServe Solutions', 
      'email'   =>  'email@hyperxsolutions.com', 
      'address' =>  'Thane',
      'phone'   =>  '9820704909'
    ]);
  }
}
