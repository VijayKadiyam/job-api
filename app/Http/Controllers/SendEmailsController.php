<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubProduct;
use Illuminate\Support\Facades\Storage;
use Mail;

class SendEmailsController extends Controller
{
  /*
   * To send a new email
   *
   *@
   */
  public function send(Request $request)
  {
    $request->validate([
      'from_name'         =>  'required',
      'reply_to_email'    => 'required',
      'send_to_email'     =>  'required',
      'sub_product_id'    =>  'required'
    ]);

    $fromName = $request->from_name;
    $replyToEmail = $request->reply_to_email;
    $sendToEmail = $request->send_to_email;
    $subProduct = SubProduct::where('id', '=', $request->sub_product_id)->first();

    $aws_path = 'https://aaibuzz.s3.ap-south-1.amazonaws.com/digiloop/';

    Mail::send([], [], function ($message) use($fromName, $replyToEmail, $sendToEmail, $subProduct, $aws_path) {
      $message
        ->from('kvjkumr@gmail.com', $fromName)
        ->replyTo($replyToEmail)
        ->to($sendToEmail)
        ->subject('Details of ' . $subProduct->name)
        ->setBody($subProduct->email_html);
      if($subProduct->image1_path)
        $message->attach($aws_path . $subProduct->image1_path);
      if($subProduct->image2_path)
        $message->attach($aws_path . $subProduct->image2_path);
      if($subProduct->image3_path)
        $message->attach($aws_path . $subProduct->image3_path);
      if($subProduct->image4_path)
        $message->attach($aws_path . $subProduct->image4_path);
    });

    return response()->json([
      'message' =>  'Email sent successfully',
      'success' =>  true
    ]);
  }
}
