@extends('admin.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">First Name</label>
          <input id="inputTitle" type="text" name="fname" placeholder="Enter first name"  value="{{old('fname')}}" class="form-control">
        @error('fname')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Last Name</label>
          <input id="inputTitle" type="text" name="lname" placeholder="Enter last name"  value="{{old('lname')}}" class="form-control">
        @error('lname')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Company Name</label>
          <input id="inputTitle" type="text" name="company" placeholder="Enter company name"  value="{{old('cname')}}" class="form-control">
        @error('cname')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">TRN Number</label>
          <input id="inputTitle" type="number" name="trn" placeholder="Enter trn number"  value="{{old('trn_no')}}" class="form-control">
        @error('trn_no')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>       
        
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control" value="{{old('role')}}">
                <option value="user">User</option>
                <option value="admin">Admin</option> 
                <option value="manager">Manager</option>       
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          @php
            $coupons = DB::table('coupons')->where('effect','user')->orderBy('id','DESC')->get();
          @endphp
            <div class="form-group" id='coupon_id'>
              <label for="coupon_id">Coupon</label>
              <select name="coupon_id" class="form-control">
                  <option value="">--Select any Coupon--</option>
                  @foreach($coupons as $key=>$coupon)
                    <option value='{{$coupon->id}}'>{{$coupon->code}}</option>
                  @endforeach
              </select>
            </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
          @error('status')
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

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush