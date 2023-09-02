<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Coupon;
use DB;

class CityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $city=City::orderBy('id','ASC')->paginate(10);
      return view('admin.city.index')->with('citys',$city);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('admin.city.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $this->validate($request,[
          'name'=>'string|required',
          'state_id'=>'nullable|numeric', 
          'country_id'=>'nullable|numeric',                       
          'shipping'=>'nullable|numeric'
      ]);
      $data=$request->all();
      //dd($data);
      $status=City::create($data);
      if($status){
          request()->session()->flash('success','city successfully created');
      }
      else{
          request()->session()->flash('error','Error, Please try again');
      }
      return redirect()->route('cities.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $city=city::find($id);
      if(!$city){
          request()->session()->flash('error','city not found');
      }
      return view('admin.city.edit')->with('city',$city);
  }

  public function priceUpdate()
  {
      return view('admin.city.create');
      if(!$city){
          request()->session()->flash('error','city not found');
      }
      return view('admin.city.edit')->with('city',$city);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      $city=city::find($id);
      $this->validate($request,[
          
      ]);
      $data=$request->all();
      // return $data;
      $status=$city->fill($data)->save();
      if($status){
          request()->session()->flash('success','city successfully updated');
      }
      else{
          request()->session()->flash('error','Error, Please try again');
      }
      return redirect()->route('cities.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $city=City::find($id);
      if($city){
          $status=$city->delete();
          if($status){
              request()->session()->flash('success','city successfully deleted');
          }
          else{
              request()->session()->flash('error','Error, Please try again');
          }
          return redirect()->route('cities.index');
      }
      else{
          request()->session()->flash('error','city not found');
          return redirect()->back();
      }
  }

  public function getCities(Request $request) {
    $cities = DB::table('cities')->where(['country_id' => $request->country_id, 'state_id' => $request->id])->get();
    return $cities;
  }
}
