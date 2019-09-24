<?php

namespace App\Http\Controllers\Frontend\Developer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Database\DeveloperUser;
use App\Database\ProjectList;
use App\Database\ProjectUnitType;
use App\Database\ProjectUnitInstallment;
use App\Database\UnitFacility;

use App\Http\Controllers\Controller;

class ProjectUnitController extends Controller
{
  public function get_unit( Request $request, ProjectUnitType $unit_type, $project_id )
  {
    $keywords = $request->keywords;
    $unit = new $unit_type;
    if( empty( $keywords ) )
    {
      $query = $unit->where('project_unique_id', $project_id);
    }
    else
    {
      $query = $unit->where([
        ['project_unique_id', $project_id],
        ['unit_name', 'like', '%' . $keywords . '%']
      ]);
    }

    $result = $query->orderBy('created_at', 'desc')
    ->paginate( 6 );

    return response()->json( $result, 200 );
  }

  public function add_unit_page( Request $request, DeveloperUser $developeruser, UnitFacility $unitfacility, ProjectList $project_list, $project_id )
  {
    if( session()->has('isDeveloper') )
    {
      $getproject = $project_list->select(
        'project_unique_id',
        'project_id',
        'project_name'
      )
      ->where('project_unique_id', $project_id)->first();

      if( ! $getproject ) abort(404);

      $getfacility = $unitfacility->orderBy('facility_name', 'asc')->get();

      $data = [
        'request' => $request,
        'session_user' => $developeruser->getinfo(),
        'project_id' => $project_id,
        'getfacility' => $getfacility,
        'getproject' => $getproject
      ];

      return response()->view('frontend.pages.developer.add_unit', $data);
    }
    else
    {
      return redirect()->route('homepage');
    }
  }

  public function add_unit( Request $request, ProjectUnitType $unit_type, $project_id )
  {
    $unit_name = $request->unit_name;
    $unit_slug = str_slug( $unit_name );
    $unit_description = $request->unit_description;
    $unit_floor = $request->unit_floor;
    $unit_lb = $request->unit_lb;
    $unit_lt = $request->unit_lt;
    $unit_km = $request->unit_km;
    $unit_kt = $request->unit_kt;
    $unit_price = $request->unit_price;
    $unit_status = $request->unit_status;
    $unit_watt = $request->unit_watt;
    $unit_facility = implode( ',', $request->unit_facility );

    $insert = new $unit_type;
    $insert->unit_name = $unit_name;
    $insert->unit_slug = $unit_slug;
    $insert->unit_description = $unit_description;
    $insert->unit_floor = $unit_floor;
    $insert->unit_lb = $unit_lb;
    $insert->unit_lt = $unit_lt;
    $insert->unit_km = $unit_km;
    $insert->unit_kt = $unit_kt;
    $insert->unit_price = $unit_price;
    $insert->unit_status = $unit_status;
    $insert->unit_watt = $unit_watt;
    $insert->unit_facility = $unit_facility;
    $insert->project_unique_id = $project_id;
    $insert->save();

    $res = ['status' => 200, 'statusText' => 'success' ];
    return response()->json( $res, $res['status'] );
  }

  public function edit_unit_page( Request $request, DeveloperUser $developeruser, ProjectUnitType $unit_type, UnitFacility $unitfacility, ProjectList $project_list, $unit_id )
  {
    if( session()->has('isDeveloper') )
    {
      $getunit = $unit_type->where('unit_type_id', $unit_id)
      ->first();
      if( ! $getunit ) abort( 404 );

      $getproject = $project_list->select(
        'project_unique_id',
        'project_id',
        'project_name'
      )
      ->where('project_unique_id', $getunit->project_unique_id)->first();

      if( ! $getproject ) abort(404);

      $getfacility = $unitfacility->orderBy('facility_name', 'asc')->get();

      $data = [
        'request' => $request,
        'session_user' => $developeruser->getinfo(),
        'getunit' => $getunit,
        'getfacility' => $getfacility,
        'getproject' => $getproject
      ];

      return response()->view('frontend.pages.developer.edit_unit', $data);
    }
    else
    {
      return redirect()->route('homepage');
    }
  }

  public function save_unit( Request $request, ProjectUnitType $unit_type, $unit_id )
  {
    $unit_name = $request->unit_name;
    $unit_slug = str_slug( $unit_name );
    $unit_description = $request->unit_description;
    $unit_floor = $request->unit_floor;
    $unit_lb = $request->unit_lb;
    $unit_lt = $request->unit_lt;
    $unit_km = $request->unit_km;
    $unit_kt = $request->unit_kt;
    $unit_price = $request->unit_price;
    $unit_status = $request->unit_status;
    $unit_watt = $request->unit_watt;
    $unit_facility = implode( ',', $request->unit_facility );

    $update = $unit_type->where('unit_type_id', $unit_id)->first();
    $update->unit_name = $unit_name;
    $update->unit_slug = $unit_slug;
    $update->unit_description = $unit_description;
    $update->unit_floor = $unit_floor;
    $update->unit_lb = $unit_lb;
    $update->unit_lt = $unit_lt;
    $update->unit_km = $unit_km;
    $update->unit_kt = $unit_kt;
    $update->unit_price = $unit_price;
    $update->unit_status = $unit_status;
    $update->unit_watt = $unit_watt;
    $update->unit_facility = $unit_facility;
    $update->save();

    $res = ['status' => 200, 'statusText' => 'success' ];
    return response()->json( $res, $res['status'] );
  }

  public function project_delete_unit_tipe( ProjectUnitType $unit_tipe, $id )
  {
    $unit = $unit_tipe->where('project_unit_type_id', $id);
    if( $unit->count() !== 0 )
    {
      $unit->delete();
    }
    $res = ['status' => 200, 'statusText' => 'success'];
    return response()->json( $res, $res['status'] );
  }
}
