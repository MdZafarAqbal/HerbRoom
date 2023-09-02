@extends('admin.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputFname" class="col-form-label">First Name</label>
        <input id="inputFname" type="text" name="fname" placeholder="Enter first name"  value="{{$user->fname}}" class="form-control">
        @error('fname')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputLname" class="col-form-label">Last Name</label>
        <input id="inputLname" type="text" name="lname" placeholder="Enter last name"  value="{{$user->lname}}" class="form-control">
        @error('lname')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputCompany" class="col-form-label">Company Name</label>
          <input id="inputCompany" type="text" name="cname" placeholder="Enter company name"  value="{{$user->cname}}" class="form-control">
          @error('cname')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputTrn" class="col-form-label">TRN Number</label>
          <input id="inputTrn" type="number" name="trn_no" placeholder="Enter trn number"  value="{{$user->trn_no}}" class="form-control">
          @error('trn_no')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{$user->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{$user->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

        @php 
          $roles=DB::table('users')->select('type')->where('id',$user->id)->get();
        // dd($roles);
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control">
                <option name="role" value="">-----Select Role-----</option>
                @foreach($roles as $role)
                  <option  value="user" {{(($role->type=='user') ? 'selected' : '')}}>User</option>
                  <option  value="admin" {{(($role->type=='admin') ? 'selected' : '')}}>Admin</option>
                  <option  value="manager" {{(($role->type=='manager') ? 'selected' : '')}}>Manager</option>
                @endforeach
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
                  @if($user->coupon)
                    <option value="">{{$user->coupon->code }}</option>
                  @endif
                  <option value="">--Select Coupon --</option>
                  @foreach($coupons as $key=>$coupon)
                    <option value='{{$coupon->id}}'>{{$coupon->code}}</option>
                  @endforeach
              </select>
            </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
              <option value="active" {{(($user->status=='active') ? 'selected' : '')}}>Active</option>
              <option value="inactive" {{(($user->status=='inactive') ? 'selected' : '')}}>Inactive</option>
            </select>
          @error('status')
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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush