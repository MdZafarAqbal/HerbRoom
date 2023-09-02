<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country=Country::orderBy('id','ASC')->paginate('10');
        return view('admin.country.index')->with('countries',$country);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
          'name'=>'string|required',
          'capital'=>'string|nullable',
          'iso_code'=>'string|nullable',
          'lang'=>'string|nullable',
          'currency'=>'string|nullable',            
          'currency_name'=>'string|nullable',
          'currency_symbol'=>'string|nullable',
          'calling_code'=>'numeric|nullable',  
          'tld'=>'string|nullable',
          'flag_icon'=>'string|nullable',
          'region'=>'string|nullable',
          'time_zone'=>'string|nullable',
          'date_format'=>'string|nullable',
          'status'=>'required|in:active,inactive',
                                 
        ]);
        //dd($request->all());
        $data=$request->all();
        //dd($data);
        $status=Country::create($data);
        if($status){
            request()->session()->flash('success','Country successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding country');
        }
        return redirect()->route('countries.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country=Country::find($id);
        if(!$country){
            request()->session()->flash('error','country not found');
        }
        return view('admin.country.edit')->with('country',$country);
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
        $country=Country::findOrFail($id);
        
        $this->validate($request,[
            
        ]);
        $data=$request->all();
        //dd($country);
        $status=$country->fill($data)->save();
        if($status){
            request()->session()->flash('success','Country successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating country');
        }
        return redirect()->route('countries.index');
    }
    public function destroy($id)
    {
        $country=Country::find($id);
        if($country){
            $status=$country->delete();
            if($status){
                request()->session()->flash('success','country successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('countries.index');
        }
        else{
            request()->session()->flash('error','country not found');
            return redirect()->back();
        }
    }

}
