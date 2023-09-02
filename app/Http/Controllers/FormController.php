<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Form;

class FormController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form=Form::orderBy('id','DESC')->paginate(10);
        return view('admin.form.index')->with('forms',$form);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.form.create');
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
            'name'=>'string|required|max:50'
                                 
        ]);
        $data=$request->all();
        $slug=Str::slug($request->name);
        $count=Form::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=Form::create($data);
        if($status){
            request()->session()->flash('success','Form successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding form');
        }
        return redirect()->route('forms.index');
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
        $form=Form::findOrFail($id);
        return view('admin.form.edit')->with('forms',$form);
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
        $form=Form::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required|max:50',
        ]);
        $data=$request->all();
        $status=$form->fill($data)->save();
        if($status){
            request()->session()->flash('success','Form successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating form');
        }
        return redirect()->route('forms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form=Form::findOrFail($id);
        $status=$form->delete();
        if($status){
            request()->session()->flash('success','Form successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting form');
        }
        return redirect()->route('forms.index');
    }
}
