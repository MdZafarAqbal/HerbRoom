<?php

namespace App\Http\Controllers;

use App\Models\FixedBanner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FixedBannerController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $banner_fixed=FixedBanner::orderBy('id','ASC')->paginate(10);
        return view('admin.fixed.index')->with('banner_fixeds',$banner_fixed);
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.fixed.create');
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'photo_desktop'=>'string|required',
            'photo_tablet'=>'string|required',
            'photo_mobile'=>'string|required',
        ]);
        $data=$request->all();
        //dd($data);
        $status=FixedBanner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('fixed-banners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner_fixed=FixedBanner::findOrFail($id);
        return view('admin.fixed.edit')->with('banner_fixed',$banner_fixed);
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
        $banner_fixed=FixedBanner::findOrFail($id);
        $this->validate($request,[
            'photo_desktop'=>'string|required',
            'photo_tablet'=>'string|required',
            'photo_mobile'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$banner_fixed->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('fixed-banners.index');
    }

}
