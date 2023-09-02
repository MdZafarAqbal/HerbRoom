@extends('admin.layouts.master')
@section('title','The Herb Room || Banner Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Banner</h5>
    <div class="card-body">
      <form method="post" action="{{route('banners.update',$banner->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputName" class="col-form-label">Name <span class="text-danger">*</span></label>
        <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{$banner->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo Desktop <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder_desktop" class="btn btn-primary lfm">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
          <input id="thumbnail" class="form-control" type="text" name="photo_desktop" value="{{$banner->photo_desktop}}">
        </div>
        <div id="holder_desktop" style="margin-top:15px;max-height:100px;"></div>
          @error('photo_desktop')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo Tablet <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail1" data-preview="holder_tablet" class="btn btn-primary lfm">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
          <input id="thumbnail1" class="form-control" type="text" name="photo_tablet" value="{{$banner->photo_tablet}}">
        </div>
        <div id="holder_tablet" style="margin-top:15px;max-height:100px;"></div>
          @error('photo_tablet')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo Mobile <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail2" data-preview="holder_mobile" class="btn btn-primary lfm">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
          <input id="thumbnail2" class="form-control" type="text" name="photo_mobile" value="{{$banner->photo_mobile}}">
        </div>
        <div id="holder_mobile" style="margin-top:15px;max-height:100px;"></div>
          @error('photo_mobile')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($banner->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($banner->status=='inactive') ? 'selected' : '')}}>Inactive</option>
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
    $('.lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush