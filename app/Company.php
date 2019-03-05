<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $fillable = [
    'name', 'email', 'phone', 'address', 'logo_path', 'contact_person'
  ];

  /*
   * A company belongs to many users
   *
   *@
   */
  public function users()
  {
    return $this->belongsToMany(User::class)
      ->with('roles', 'companies', 'company_designation', 'company_state_branch', 'supervisors');
  }

  /*
   * A company has many states
   *
   *@
   */
  public function company_states()
  {
    return $this->hasMany(CompanyState::class)
      ->with('company_state_branches');
  }

  /*
   * A company has many company designations
   *
   *@
   */
  public function company_designations()
  {
    return $this->hasMany(CompanyDesignation::class);
  }

  /*
   * Save Default companydesignations
   *
   *@
   */
  public function saveDefaultDesignations()
  {
    $designations[] = new CompanyDesignation(['name' => 'Admin']);
    $this->company_designations()->saveMany($designations);
  }

  /*
   * A company belongs to leave pattern
   *
   *@
   */
  public function leave_patterns()
  {
    return $this->belongsToMany(LeavePattern::class);
  }

  /**
   * Assign leave patter to company
   *
   * @ 
   */
  public function assignLeavePattern($leave_pattern)
  {
    return $this->leave_patterns()->sync([$leave_pattern]);
  }

  /**
   * Check if the company has leave pattern
   *
   * @ 
   */
  public function hasLeavePattern($leave_pattern)
  {
    return $this->leave_patterns ? in_array($leave_pattern, $this->leave_patterns->pluck('id')->toArray()) : false;
  }

  /*
   * A company has many company leaves
   *
   *@
   */
  public function company_leaves()
  {
    return $this->hasMany(CompanyLeave::class);
  }

  /*
   * Save Default company leaves
   *
   *@
   */
  public function saveDefaultCompanyLeaves()
  {
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'January', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'February', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'March', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'April', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'May', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'June', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'July', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'August', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'September', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'October', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'November', 'leaves' =>  0]);
    $companyLeaves[] = new CompanyLeave(['leave_pattern_id' =>  2, 'name' => 'December', 'leaves' =>  0]);
    $this->company_leaves()->saveMany($companyLeaves);
  }

  /*
   * A company has many break types
   *
   *@
   */
  public function break_types()
  {
    return $this->hasMany(BreakType::class);
  }
}
