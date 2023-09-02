@extends('admin.layouts.master')
@section('main-content')
  <div class="card">
    <h5 class="card-header">Edit Coupon</h5>
    <div class="card-body">
      <form method="post" action="{{route('coupons.update',$coupon->id)}}">
        @csrf 
        @method('PATCH')
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Coupon Code <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="code" placeholder="Enter Coupon Code"  value="{{$coupon->code}}" class="form-control">
            @error('code')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
           
          <div class="form-group">
            <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
            <select name="type" class="form-control">
              <option value="fixed" {{(($coupon->type=='fixed') ? 'selected' : '')}}>Fixed</option>
              <option value="percent" {{(($coupon->type=='percent') ? 'selected' : '')}}>Percent</option>
            </select>
            @error('type')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
  
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Value <span class="text-danger">*</span></label>
            <input id="inputTitle" type="number" name="value" placeholder="Enter Coupon value"  value="{{$coupon->value}}" class="form-control">
            @error('value')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="effect" class="col-form-label">Effect <span class="text-danger">*</span></label>
            <select name="effect" class="form-control">
              <option value="product" {{(($coupon->effect=='product') ? 'selected' : '')}}>Product</option>
              <option value="category" {{(($coupon->effect=='category') ? 'selected' : '')}}>Category</option>
              <option value="subcategory" {{(($coupon->effect=='subcategory') ? 'selected' : '')}}>Subcategory</option>
              <option value="user" {{(($coupon->effect=='user') ? 'selected' : '')}}>User</option>
              <option value="order" {{(($coupon->effect=='all') ? 'selected' : '')}}>All</option>
            </select>
            @error('type')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          <div class="form-group mb-3">
            <button class="btn btn-success" type="submit">Update</button>
          </div>
        </form>
      </div>
    </div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('admin_panel/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>

@endpush