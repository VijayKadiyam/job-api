<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubProduct extends Model
{
  protected $fillable = [
    'name', 'position', 'email_subject', 'email_html', 'image1_path', 'image2_path', 'image3_path', 'image4_path', 'description', 'image1_description', 'image2_description', 'image3_description', 'image4_description'
  ];

  /*
   * A sub product belongs to product
   *
   *@
   */
  public function product()
  {
    return $this->belongsTo(Product::class)
      ->with('listing');
  }
}
