<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class MarketingUser extends Model
{
  public $timestamps = true;
  protected $table = 'marketing_user';
  protected $primaryKey = 'mkt_user_id';
  protected $guarded = ['created_at', 'updated_at'];

  public function getinfo()
  {
    $marketinguser = $this::where('marketing_user.mkt_user_id', session()->get('mkt_user_id'))
    ->select(
      'marketing_user.mkt_user_id',
      'marketing_user.mkt_fullname',
      'marketing_user.mkt_username',
      'marketing_user.mkt_email',
      'marketing_user.mkt_phone_number',
      'marketing_user.mkt_mobile_phone',
      'marketing_user.mkt_city',
      'marketing_user.mkt_address',
      'marketing_user.mkt_biography',
      'marketing_user.mkt_profile_photo',
      'marketing_user.dev_user_id',
      'marketing_user.created_at',
      'marketing_user.updated_at',
      'city.city_name',
      'city.city_slug',
      'province.province_id',
      'province.province_name',
      'province.province_slug'
    )
    ->leftJoin('city', 'marketing_user.mkt_city', '=', 'city.city_id')
    ->leftJoin('province', 'city.province_id', '=', 'province.province_id')
    ->first();

    return $marketinguser;
  }
}
