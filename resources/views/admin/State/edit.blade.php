@extends('admin.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit State</h5>
    <div class="card-body">
      <form method="post" action="{{route('states.update',$state->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">State Name <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter Country Name"  value="{{$state->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div> 
        @php
            $countries = DB::table('countries')->where('status', 'active')->get();
        @endphp
        <div class="form-group" id='country_id'>
            <label for="country_id">Country</label>
            <select name="country_id" class="form-control">
                <option value="">{{$state->country->name}}</option>
                @foreach($countries as $key=>$country)
                    <option value='{{$country->id}}'>{{$country->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
          <option value="active" {{(($state->status=='active')? 'selected' : '')}}>Active</option>
              <option value="inactive" {{(($state->status=='inactive')? 'selected' : '')}}>Inactive</option>
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

@push('styles')
<link rel="stylesheet" href="{{asset('admin_panel/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush