@extends('admin.layouts.master')

@section('country','The Herb Room || Country Create')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Country</h5>
    <div class="card-body">
      <form method="post" action="{{route('countries.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputName" class="col-form-label">Country Name <span class="text-danger">*</span></label>
        <input id="inputName" type="text" name="name" placeholder="Enter Country name"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputCapital" class="col-form-label">Capital </label>
        <input id="inputCapital" type="text" name="capital" placeholder="Enter capital"  value="{{old('capital')}}" class="form-control">
        @error('capital')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputIso" class="col-form-label">Iso Code </label>
        <input id="inputIso" type="text" name="iso_code" placeholder="Enter iso code"  value="{{old('iso_code')}}" class="form-control">
        @error('iso_code')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputLang" class="col-form-label">Language </label>
        <input id="inputLang" type="text" name="lang" placeholder="Enter language"  value="{{old('lang')}}" class="form-control">
        @error('lang')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputCurrency" class="col-form-label">Currency </label>
        <input id="inputCurrency" type="text" name="currency" placeholder="Enter currency"  value="{{old('currency')}}" class="form-control">
        @error('currency')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputCurrency_Name" class="col-form-label">Currency Name </label>
        <input id="inputCurrency_Name" type="text" name="currency_name" placeholder="Enter Currency Name"  value="{{old('currency_name')}}" class="form-control">
        @error('currency_name')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputCurrency_Symbol" class="col-form-label">Currency Symbol </label>
        <input id="inputCurrency_Symbol" type="text" name="currency_symbol" placeholder="Enter Currency Symbol"  value="{{old('currency_symbol')}}" class="form-control">
        @error('currency_symbol')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputCalling_Code" class="col-form-label">Calling Code </label>
          <input id="inputCalling_Code" type="number" name="calling_code" placeholder="Enter Colling Code"  value="{{old('calling_code')}}" class="form-control">
          @error('calling_code')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputTld" class="col-form-label">Top Level Domain</label>
        <input id="inputTld" type="text" name="tld" placeholder="Enter tld"  value="{{old('tld')}}" class="form-control">
        @error('tld')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputFlag_icon" class="col-form-label">Flag Icon </label>
          <div class="input-group">
            <span class="input-group-btn">
              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
              </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="flag_icon" value="{{old('flag_icon')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('flag_icon')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputRegion" class="col-form-label">Region</label>
        <input id="inputRegion" type="text" name="region" placeholder="Enter tld"  value="{{old('region')}}" class="form-control">
        @error('region')
          <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputTime_Zone" class="col-form-label">Time Zone</label>
        <input id="inputTime_Zone" type="time" name="time_zone" placeholder="Enter Time Zone"  value="{{old('time_zone')}}" class="form-control">
        @error('time_zone')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputDate_Format" class="col-form-label">Date Format</label>
        <input id="inputDate_Format" type="date" name="date_format" placeholder="Enter Date Format"  value="{{old('date_format')}}" class="form-control">
        @error('date_format')
            <span class="text-danger">{{$message}}</span>
        @enderror
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
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush