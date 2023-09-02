<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductForm;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\ProductBrand;
use App\Models\Coupon;
use App\Models\Form;
use App\Models\ProductImage;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $products = Product::paginate(10);
    return view('admin.product.index')->with('products',$products);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      $brand=Brand::get();
      $form=Form::get();
      $coupon=Coupon::get();
      $category=Category::with('subcats')->get();
      $subcategory=SubCategory::get();

      // return $category;
      return view('admin.product.create')->with('categories',$category)->with('brands',$brand)->with('subcategories',$subcategory)
      ->with('coupons',$coupon)->with('forms',$form);
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
        'plu'=>'required|numeric',
        'name'=>'string|required',
        'sci_name'=>'string|nullable',
        'other_name'=>'string|nullable',
        'benefits'=>'string|nullable',
        'description'=>'string|nullable',
        'packaging_detaiils'=>'string|nullable',
        'precautions'=>'string|nullable',                 
        'photo'=>'required',
        'promotion'=>'required|in:default,new,trending',
        'minprice'=>'numeric|nullable',
        'coupon_id'=>'nullable|exists:coupons,id',            
        'status'=>'required|in:active,inactive'
          
    ]);
    
    $data=$request->all(); 
    
    $slug=Str::slug($request->name);
    $count=Product::where('slug',$slug)->count();        
    $data['slug']=$slug;

    $status=Product::create($data);
    $brands = [];
    $brands[] =$request->brand_id;
    for($i=2; $i<=$request->brands_count; $i++){
        $brand= 'brand_id'.$i;
        $brands[] = $request->$brand;
    }
    foreach ($brands as $product_brand) {
        $brand = new ProductBrand;
        $brand['product_id']=$status->id;           
        $brand['brand_id']=$product_brand;
        $brand->save();
    }   
    $categories = [];
    $categories[] = $request->cat_id;
    $subcategories = [];
    $subcategories[] = $request->subcat_id;
    for($i=2; $i<=$request->cat_count; $i++){
        $cat= 'cat_id'.$i;
        $categories[] = $request->$cat; 
       
    }
    
    for($i=2; $i<=$request->subcat_count; $i++){ 
        $subcat= 'subcat_id'.$i;
        $subcategories[]= $request->$subcat;   
    }

    
    if($categories[0]!==""){
        foreach ($categories as $product_cat) {
          dd($status);
            $category = new ProductCategory;
            $category['product_id']=$status->id;           
            $category['cat_id']=$product_cat;
            $category->save();
        }
        
    }

    if($subcategories[0]!==""){
        foreach ($subcategories as $product_subcat) {
            $subcategory = new ProductCategory;
            $subcategory['product_id']=$status->id;  
            //$category['cat_id']=$product_cat;         
            $subcategory['subcat_id']=$product_subcat;            
            $subcategory->save();
        }
    }
      
          
    if($request->hasFile("images")){
        $files=$request->file("images");
        foreach($files as $file){
            $imageName='/'.$file->getClientOriginalName();
            $request['product_id']=$status->id;
            $request['name']=$imageName;
            $file->move(base_path("public_html/images/products"),$imageName);   
            ProductImage::create($request->all());
        }
    }  
    if($request->form_id[0]){
        foreach ($request->form_id as $product_form) {
            $form = new ProductForm;
            $form['product_id']=$id;           
            $form['form_id']=$product_form;
            $form->save();
        }   
    }  
    for($i=0; $i<count($request->form_id); $i++){
        $attribute = new ProductAttribute;
        $attribute['product_id']=$status->id;           
        $attribute['flu']=$request->flu[$i];
        $attribute['sku']= $request->sku[$i];
        $attribute['form_id']=$request->form_id[$i];
        $attribute['size']=$request->size[$i];
        $attribute['price']=$request->price[$i];
        $attribute['discount']=$request->discount[$i];
        $attribute['stock']=$request->stock[$i];
        $attribute->save();                             
    }
    if($status){
        request()->session()->flash('success','Product Successfully added');
    }
    else{
        request()->session()->flash('error','Please try again!!');
    }
    return redirect()->route('products.index');


    }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      return view('products.import');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {   
    $product=Product::with('coupon', 'cats', 'subcats', 'brands')->findOrFail($id);
    $category=Category::with('subcats')->get();
    $brand=Brand::get();
    $coupon=Coupon::get();
    $form=Form::get();

    return view('admin.product.edit')->with('product',$product)
    ->with('categories',$category)
    ->with('forms',$form)
    ->with('coupons',$coupon)
    ->with('brands',$brand);
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
 
      $product=Product::findOrFail($id);
    
      $data=$request->all();
     
      $size=$request->input('size');
     
      $status=$product->fill($data)->save();
      
    $brands = [];
    $brands[] =$request->brand_id;
    for($i=2; $i<=$request->brands_count; $i++){
        $brand= 'brand_id'.$i;
        $brands[] = $request->$brand;
    }
    if($brands[0]){
        foreach ($brands as $product_brand) {
            $brand = new ProductBrand;
            $brand['product_id']=$id;           
            $brand['brand_id']=$product_brand;
            $brand->save();
        } 
    } 
    
    $categories = [];
    $categories[] = $request->cat_id;
    $subcategories = [];
    $subcategories[] = $request->subcat_id;
    for($i=2; $i<=$request->cat_count; $i++){
      $cat= 'cat_id'.$i;
      $categories[] = $request->$cat;    
    }
    
    for($i=2; $i<=$request->subcat_count; $i++){ 
        $subcat= 'subcat_id'.$i;
        $subcategories[]= $request->$subcat;   
    }
    
    if($categories[0] !== ""){
      foreach ($categories as $product_cat) {
        $procat = ProductCategory::where(['product_id' => $id, 'cat_id' => $product_cat])->first();
        if(!$procat) {
          $category = new ProductCategory;
          $category['product_id'] = $id;           
          $category['cat_id'] = $product_cat;
          $category->save();
        }
      }
    }
   
   
    if($subcategories[0]!==""){
      foreach ($subcategories as $product_subcat) {
        $prosubcat = ProductCategory::where(['product_id' => $id, 'subcat_id' => $product_subcat])->first();
        if(!$prosubcat) {
          $subcategory = new ProductCategory;
          $subcategory['product_id'] = $id;  
          $subcategory['subcat_id'] = $product_subcat;            
          $subcategory->save();
        }
      }
    }
  
    
    if($request->hasFile("images")){
        $files=$request->file("images");
        foreach($files as $file){
            $imageName='/'.$file->getClientOriginalName();
            $request['product_id']=$id;
            $request['name']=$imageName;
           $file->move(base_path("public_html/images/products"),$imageName);   
            ProductImage::create($request->all());
        }
    }  
  
    if($request->form_id[0]){
        foreach ($request->form_id as $product_form) {
            $form = new ProductForm;
            $form['product_id']=$id;           
            $form['form_id']=$product_form;
            $form->save();
        }   
    }

    if($request->sku[0]){         
        for($i=0; $i<count($request->form_id); $i++){
            $attribute = new ProductAttribute;
            $attribute['product_id']=$id;                      
            $attribute['sku']= $request->sku[$i];
            $attribute['flu']=$request->flu[$i];
            $attribute['form_id']=$request->form_id[$i];
            $attribute['size']=$request->size[$i];
            $attribute['price']=$request->price[$i];
            $attribute['discount']=$request->discount[$i];
            $attribute['stock']=$request->stock[$i];
   
            $attribute->save();                             
        } 
    }
          
      if($status){
          
          request()->session()->flash('success','Product Successfully updated');
      }
      else{
          request()->session()->flash('error','Please try again!!');
      }
      return redirect()->route('products.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $product=Product::findOrFail($id);
    $status=$product->delete();
    
    if($status){
        request()->session()->flash('success','Product successfully deleted');
    }
    else{
        request()->session()->flash('error','Error while deleting product');
    }
    return redirect()->route('products.index');
  }
 

  //delete Category
  public function deleteCategory($id, Request $request){
      $productCategory=ProductCategory::where('cat_id',  $id)->where('product_id', $request->productId);
      $status=$productCategory->delete(); 
      if($status){
          request()->session()->flash('success','Product successfully deleted');
      }
      else{
          request()->session()->flash('error','Error while deleting product');
      }
  
      //return redirect()->back();
  }

  public function deleteBrand($id, Request $request){
    $productBrand=ProductBrand::where('brand_id',  $id)->where('product_id', $request->productId);
    $status=$productBrand->delete(); 
    if($status){
        request()->session()->flash('success','Product successfully deleted');
    }
    else{
        request()->session()->flash('error','Error while deleting product');
    }

    //return redirect()->back();
}
      public function deleteImage($id){
          $product=ProductImage::findOrFail($id);
          $status=$product->delete();

          
          if($status){
              request()->session()->flash('success','Product successfully deleted');
          }
          else{
              request()->session()->flash('error','Error while deleting product');
          }
          return redirect()->back();
      }

      public function deleteAttribute($id){

          $attribute=ProductAttribute::findOrFail($id);
          $status=$attribute->delete();

          
          if($status){
              request()->session()->flash('success','Product successfully deleted');
          }
          else{
              request()->session()->flash('error','Error while deleting product');
          }
      
          return redirect()->back();
      }
  
      public function editAttribute(Request $request){
   
        $data = $request->all();
        
        ProductAttribute::where(['id'=>$data['idAttr']])->update(['price'=>$data['price'],
        'discount'=>$data['discount'],'stock'=>$data['stock']]);
        
        return redirect()->back()->with('flash_message_success','Products Attributes has been update successfully');
         
      }

    public function exportProducts(Request $request){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

}
