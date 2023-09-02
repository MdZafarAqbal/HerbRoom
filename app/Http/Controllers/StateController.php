<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use DB;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $state=State::with('country')->orderBy('id','ASC')->paginate(10);
        //dd($state);
        return view('admin.state.index')->with('states',$state);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.state.create');
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
            'country_id'=>'nullable|numeric', 
            'status'=>'required|in:active,inactive',                      
        ]);
        $data=$request->all();
        // return $data;
        $status=State::create($data);
        if($status){
            request()->session()->flash('success','state successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('states.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state=State::find($id);
        if(!$state){
            request()->session()->flash('error','state not found');
        }
        return view('admin.state.edit')->with('state',$state);
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
        $state=State::findOrFail($id);        
        $this->validate($request,[
            
        ]);
        $data=$request->all();
        
        $status=$state->fill($data)->save();
        if($status){
            request()->session()->flash('success','State successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating state');
        }
        return redirect()->route('states.index');
    }
    public function destroy($id)
    {
        $state=State::find($id);
        if($state){
            $status=$state->delete();
            if($status){
                request()->session()->flash('success','state successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('states.index');
        }
        else{
            request()->session()->flash('error','state not found');
            return redirect()->back();
        }
    }

    public function getStates(Request $request) {
      $states = DB::table('states')->where('country_id', $request->id)->get();
      return $states;
    }
}
