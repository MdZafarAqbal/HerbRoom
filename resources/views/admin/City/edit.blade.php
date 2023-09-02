@extends('admin.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit City</h5>
    <div class="card-body">
      <form method="post" action="{{route('cities.update',$city->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">City Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter type"  value="{{$city->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        @php
          $countries = DB::table('countries')->where('status', 'active')->get();
        @endphp
          <div class="form-group" id='country_id'>
            <label for="country">Country</label>
            <select name="country" class="form-control">
            <option value="{{$city->country->name}}">{{$city->country->name}}</option>
              @foreach($countries as $key=>$country)
                <option value='{{$country->id}}'>{{$country->name}}</option>
              @endforeach
            </select>
          </div>
          @php
            $states = DB::table('states')->where('status', 'active')->get();
          @endphp
          <div class="form-group" id='state_id'>
              <label for="state">State Name</label>
              <select name="state" class="form-control">
              <option value="{{$city->state->name}}">{{$city->state->name}}</option>
                  @foreach($states as $key=>$state)
                      <option value='{{$state->id}}'>{{$state->name}}</option>
                  @endforeach
              </select>
          </div>    
        <div class="form-group">
          <label for="shipping" class="col-form-label">Price <span class="text-danger">*</span></label>
        <input id="shipping" type="number" name="shipping" placeholder="Enter price"  value="{{$city->shipping}}" class="form-control">
        @error('shipping')
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
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>
<script>
  

</script>
@endpush