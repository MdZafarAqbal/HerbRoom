@extends('admin.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Add Coupon</h5>
  <div class="card-body">
    <form method="post" action="{{route('coupons.store')}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Coupon Code <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="code" placeholder="Enter Coupon Code"  value="{{old('code')}}" class="form-control">
        @error('code')
          <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
        <select name="type" class="form-control">
          <option value="fixed">Fixed</option>
          <option value="percent">Percent</option>
        </select>
        @error('type')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Value <span class="text-danger">*</span></label>
        <input id="inputTitle" type="float" name="value" placeholder="Enter Coupon value"  value="{{old('value')}}" class="form-control">
        @error('value')
          <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="effect" class="col-form-label">Effect </label>
        <select name="effect" class="form-control">
          <option value="product">Product</option>
          <option value="category">Category</option>
          <option value="subcategory">Subcategory</option>
          <option value="user">User</option>
          <option value="all">All</option>
        </select>
        @error('type')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      
      <div class="form-group mb-3">
        <button type="reset" class="btn btn-warning">Reset</button>
        <button class="btn btn-success" type="submit">Submit</button>
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