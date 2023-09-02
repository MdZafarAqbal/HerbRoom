@extends('admin.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add State</h5>
    <div class="card-body">
        <form method="post" action="{{route('states.store')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputName" class="col-form-label">State Name <span class="text-danger">*</span></label>
                <input id="inputName" type="text" name="name" placeholder="Enter State name"  value="{{old('name')}}" class="form-control">
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
                    <option value="">--Select any category--</option>
                    @foreach($countries as $key=>$country)
                        <option value='{{$country->id}}'>{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
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

@push('styles')
<link rel="stylesheet" href="{{asset('admin_panel/summernote/summernote.min.css')}}">

</style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>

@endpush