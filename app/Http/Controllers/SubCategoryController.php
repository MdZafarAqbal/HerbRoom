<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategory=SubCategory::orderBy('id','ASC')->paginate(10);
        //dd($state);
        return view('admin.subcategory.index')->with('subcategories',$subcategory);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subcategory.create');
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
            'parent_id'=>'nullable|numeric',
            'coupon_id'=>'nullable|numeric', 
            'status'=>'required|in:active,inactive',                      
        ]);
        $data=$request->all();
        $slug=Str::slug($request->name);
        $count=SubCategory::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=SubCategory::create($data);
        if($status){
            request()->session()->flash('success','Subcategory successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding subcategory');
        }
        return redirect()->route('subcategories.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory=SubCategory::with('coupon')->find($id);
        //dd($category);
        if(!$subcategory){
            request()->session()->flash('error','category not found');
        }
        return view('admin.subcategory.edit')->with('subcategory',$subcategory);
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
        $subcategory=SubCategory::findOrFail($id);        
        $this->validate($request,[
            
        ]);
        $data=$request->all();
        //dd($data);
        $status=$subcategory->fill($data)->save();
        if($status){
            request()->session()->flash('success','SubCategory successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating subcategory');
        }
        return redirect()->route('subcategories.index');
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory=SubCategory::findOrFail($id);
        $status=$subcategory->delete();
        if($status){
            request()->session()->flash('success','SubCategory successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting subcategory');
        }
        return redirect()->route('subcategories.index');
    }
      
}
