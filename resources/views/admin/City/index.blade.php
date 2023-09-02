@extends('admin.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="row">
      <div class="col-md-12">
        @include('admin.layouts.notification')
      </div>
    </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">city List</h6>
      <a href="{{route('cities.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add city</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($citys)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
            <th>S.N.</th>
              <th>City Name</th>
              <th>State Name</th>
              <th>Country Name</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>City Name</th>
              <th>State Name</th>
              <th>Country Name</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($citys as $city) 
             
              <tr>
                <td>{{$city->id}}</td>
                <td>{{$city->name}}</td>
                <td>{{$city->state->name}}</td>
                <td>{{$city->country->name}}</td>
                <td>AED {{$city->shipping}}</td>
                
                <td>
                  <a href="{{route('cities.edit',$city->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                  <form method="POST" action="{{route('cities.destroy',[$city->id])}}">
                    @csrf 
                    @method('delete')
                    <button class="btn btn-danger btn-sm dltBtn" data-id="{{$city->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                  </form>
                </td>
              </tr>               
            @endforeach
          </tbody>
        </table>
        {!! $citys->withQueryString()->links('pagination::bootstrap-5') !!}
      
        @else
          <h6 class="text-center">No citys found!!! Please create city</h6>
        @endif
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <link href="{{asset('admin_panel/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(3.2);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('admin_panel/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('admin_panel/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('admin_panel/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush