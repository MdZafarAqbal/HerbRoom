<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::orderBy('id','ASC')->paginate(10);
        //dd($state);
        return view('admin.category.index')->with('categories',$category);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'coupon_id'=>'nullable|numeric', 
            'status'=>'required|in:active,inactive',                      
        ]);
        $data=$request->all();
        $slug=Str::slug($request->name);
        $count=Category::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=Category::create($data);
        if($status){
            request()->session()->flash('success','Category successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding category');
        }
        return redirect()->route('categories.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::with('coupon')->find($id);
        //dd($category);
        if(!$category){
            request()->session()->flash('error','category not found');
        }
        return view('admin.category.edit')->with('category',$category);
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
        $category=Category::findOrFail($id);        
        $this->validate($request,[
            
        ]);
        $data=$request->all();
        //dd($data);
        $status=$category->fill($data)->save();
        if($status){
            request()->session()->flash('success','Category successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating category');
        }
        return redirect()->route('categories.index');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $status=$category->delete();
        if($status){
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting category');
        }
        return redirect()->route('categories.index');
    }
    public function getChildByParent(Request $request){
        //dd($request->all());
        $category=Category::findOrFail($request->id);
        $child_cat=SubCategory::where('parent_id',$request->id)->orderBy('id','ASC')->pluck('name', 'id');
        // return $child_cat;
        if(count($child_cat)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
        }
    }
   
}
