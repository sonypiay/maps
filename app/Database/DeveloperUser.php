<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class DeveloperUser extends Model
{
  public $timestamps = true;
  protected $table = 'developer_user';
  protected $primaryKey = 'dev_user_id';
  protected $guarded = ['created_at', 'updated_at'];

  public function getinfo()
  {
    $developeruser = $this->select(
      'developer_user.dev_user_id',
      'developer_user.dev_logo',
      'developer_user.dev_ownername',
      'developer_user.dev_name',
      'developer_user.dev_email',
      'developer_user.dev_username',
      'developer_user.dev_address',
      'developer_user.dev_city',
      'developer_user.dev_slug',
      'developer_user.dev_biography',
      'developer_user.dev_phone_office',
      'developer_user.dev_mobile_phone',
      'developer_user.dev_ownership',
      'developer_user.created_at',
      'developer_user.updated_at',
      'city.city_name',
      'city.city_slug',
      'province.province_id',
      'province.province_name',
      'province.province_slug'
    )
    ->where('developer_user.dev_user_id', session()->get('dev_user_id'))
    ->leftJoin('city', 'developer_user.dev_city', '=', 'city.city_id')
    ->leftJoin('province', 'city.province_id', '=', 'province.province_id')
    ->first();
    return $developeruser;
  }
}
