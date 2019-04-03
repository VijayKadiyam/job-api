<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UploadController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function uploadProfileImage(Request $request)
  {
    $request->validate([
      'user_id'        => 'required',
      'profile_image'  =>  'required'
    ]);

    $image_path = optional($request->file('profile_image'))
      ->store('profileImages', 'public');

    $user = User::where('id', '=', $request->user_id)->first();
    $user->image_path = $image_path;
    $user->update();

    return response()->json([
      'data'  => [
        'image_path'  =>  $image_path
      ],
      'success' =>  true
    ]);
  }
}
