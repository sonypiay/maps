<?php

namespace App\Http\Controllers\Frontend\Marketing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use App\Database\MarketingUser;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
  public function do_login( Request $request, MarketingUser $marketinguser )
  {
    $username = $request->username;
    $password = $request->password;
    $check_username = $marketinguser->where('mkt_username', $username);
    $check_email = $marketinguser->where('mkt_email', $username);
    $valid = false;
    if( $check_username->count() === 1 )
    {
      $result = $check_username->first();
      $valid = true;
    }
    else if( $check_email->count() === 1 )
    {
      $result = $check_email->first();
      $valid = true;
    }
    else { $valid = false; }

    if( $valid )
    {
      if( $result->mkt_password === md5( $password ) )
      {
        $res = [
          'status' => 200,
          'statusText' => 'login success'
        ];
      }
      else
      {
        $res = [
          'status' => 401,
          'statusText' => 'Password tidak sesuai.'
        ];
      }
    }
    else
    {
      $res = [
        'status' => 401,
        'statusText' => 'Username atau Email tidak terdaftar.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function do_register( Request $request, MarketingUser $marketinguser )
  {
    $fullname = $request->fullname;
    $email = $request->email;
    $username = $request->username;
    $password = $request->password;
    $hash_password = md5( $password );
    $check_username = $marketinguser->where('mkt_username', $username);
    $check_email = $marketinguser->where('mkt_email', $email);

    if( $check_username->count() > 0 )
    {
      $res = [
        'status' => 409,
        'statusText' => $username . ' sudah terdaftar'
      ];
    }
    else if( $check_email->count() > 0 )
    {
      $res = [
        'status' => 409,
        'statusText' => $email . ' sudah terdaftar'
      ];
    }
    else
    {
      $insert = new $marketinguser;
      $insert->mkt_fullname = $fullname;
      $insert->mkt_email = $email;
      $insert->mkt_username = $username;
      $insert->mkt_password = $hash_password;
      $insert->save();

      $getuser = $marketinguser->where([
        ['mkt_username', $username],
        ['mkt_password', $hash_password]
      ])->first();

      session()->put('isMarketing', true);
      session()->put('mkt_user_id', $getuser->mkt_user_id);
      session()->put('mkt_email', $getuser->mkt_email);
      session()->put('mkt_login_date', date('Y-m-d H:i:s'));
      
      $res = ['status' => 200, 'statusText' => 'success'];
    }

    return response()->json( $res, $res['status'] );
  }
}
