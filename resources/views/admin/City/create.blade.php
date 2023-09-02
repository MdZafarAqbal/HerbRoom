@extends('admin.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add City</h5>
    <div class="card-body">
        <form method="post" action="{{route('cities.store')}}">
          {{csrf_field()}}
          <div class="form-group">
            <label for="inputName" class="col-form-label">City Name <span class="text-danger">*</span></label>
            <input id="inputName" type="text" name="name" placeholder="Enter City name"  value="{{old('name')}}" class="form-control">
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
          @php
            $states = DB::table('states')->where('status', 'active')->get();
          @endphp
          <div class="form-group" id='state_id'>
              <label for="state_id">State Name</label>
              <select name="state_id" class="form-control">
                  <option value="">--Select any category--</option>
                  @foreach($states as $key=>$state)
                      <option value='{{$state->id}}'>{{$state->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
            <input id="price" type="number" name="shipping" placeholder="Enter price"  value="{{old('shipping')}}" class="form-control">
            @error('price')
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

</style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>

@endpush
@push('scripts')
<script src="{{asset('admin_panel/summernote/summernote.min.js')}}"></script>
<script>  
  $(function() {
    let cnty = $('#country');
    cnty.val('United Arab Emirates');

    $('#country').on('change', function() {
      let dl= $("#countries")[0];
      $('#state').val('');
      $('#city').val('');
      $('#states').empty();
      $('#cities').empty();
      if(this.value.trim() != ''){
        let opSelected = dl.querySelector(`[value="${this.value}"]`);
        let id = opSelected.getAttribute('id');

        /* AJAX request for adding shopping list items to cart */
        $.ajax({
          type: 'get',
          url: '/states',
          data: {
            id: id,
          },
          success: function (resp) {
            if(resp == '') {
              $('#state-div').hide();
              $('#city-div').hide();
            }
            else {
              $('#state-div').show();
              $('#city-div').show();
              let stDl = $('#states')[0];
              resp.forEach((element) => {
                let option = document.createElement("option");
                option.value = element['name'];
                option.text = element['name'];
                option.setAttribute('id', element['id']);
                option.setAttribute('data-country', id);
                stDl.appendChild(option);
              });
            }
          },
          error: function () {
            alert("An error occured while accessing states")
          }
        });
      }
    });


    $('#state').on('change', function() {
      let dl= $("#states")[0];
      $('#city').val('');
      $('#cities').empty();
      if(this.value.trim() != ''){
        let opSelected = dl.querySelector(`[value="${this.value}"]`);
        let id = opSelected.getAttribute('data-country');
        let st_id = opSelected.getAttribute('id');

        /* AJAX request for adding shopping list items to cart */
        $.ajax({
          type: 'get',
          url: '/cities',
          data: {
            id: id,
            st_id: st_id
          },
          success: function (resp) {
            if(resp == '') {
              $('#city-div').hide();
            }
            else {
              $('#city-div').show();
              let stDl = $('#cities')[0];
              resp.forEach((element) => {
                let option = document.createElement('option');
                option.value = element['name'];
                option.text = element['name'];
                stDl.appendChild(option);
              });
            }
          },
          error: function () {
            alert("An error occured while accessing states")
          }
        });
      }
    });
    cnty.trigger('change');
  });
</script>
@endpush