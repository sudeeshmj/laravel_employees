@extends('layouts.home')
@section('content')
   <div class="employee_list_container p-5">

    @if (session()->has('message'))
    <p class="text-center alert alert-success" id="success-msg">{{session()->get('message')}}</p>    
    @endif
    @if (session()->has('error'))
    <p class="text-center alert alert-danger "   id="error-msg">{{session()->get('error')}}</p>    
    @endif
    <p class="text-center alert alert-success d-none " id="msg"></p>
   <div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Employee List</h4>
    <a class="btn btn-success  btn-sm" href="{{route('add.user')}}">Add new</a>
   </div>

    <table class="table table-sm table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <td scope="col">Name</td>
            <td scope="col">Contact no</td>
            <td scope="col">Hobby</td>
            <td scope="col">Category</td>
            <td scope="col">Profile pic</td>
            <td scope="col">Edit</td>
          </tr>
        </thead>
        <tbody>  
          @if($users->isEmpty())
          <tr><td colspan="6" class="text-center">No Records found</td></tr>
          @else
         
          @foreach ($users as $user)
              
         
          <tr id="user{{$user->id}}">
            <td class="align-middle">{{$user->name}}</td>
            <td class="align-middle">{{$user->contact_no}}</td>
            <td class="align-middle">
            {{-- @foreach ($user->hobbies as $hobby )
             {{$hobby->hobby}}
            @endforeach --}}
            {{ $user->hobbies->pluck('hobby')->implode(', ') }}
          </td> 
            <td class="align-middle">{{$user->categoryName->name }}</td>
            <td class="text-center">
              <img src="{{asset('uploads/users/'.$user->image)}}" alt="prof_img" style="width: 50px; height: 50px;">
            </td>
            <td class="text-center align-middle">
              <a href="{{route('edit.user',encrypt($user->id))}}" class="btn btn-sm btn-warning">Edit</a>
                <a    class="btn btn-sm btn-danger"
                  data-bs-toggle="modal" data-bs-target="#exampleModal{{$user->id}}">Delete</a></td>

                 <!-- Modal -->
        <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Do you really want to delete this record?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteUser({{$user->id}})">Delete</button>
              </div>
            </div>
          </div>
        </div>
          </tr>
   @endforeach
        
   @endif   
</tbody>
      </table>



   </div>

<script>
  function deleteUser(id){
    
      $.ajax({
        url:'/delete_user/'+id,
        type:'DELETE',
        data: {
                  _token: '{{ csrf_token() }}',
                  
              },
          success: function(response) {
           
                $('#user' + id).remove();
                $('#msg').text(response.success).removeClass('d-none');
                $('#success-msg').addClass('d-none');
                $('#error-msg').addClass('d-none');
                $('#exampleModal'+id).modal('hide'); 
            },
            error: function(error) {
              $('#msg').text(error).removeClass('d-none');
              $('#exampleModal'+id).modal('hide'); 
              $('#success-msg').addClass('d-none');
                $('#error-msg').addClass('d-none');
            }
      })
    
  }
  </script>

@endsection
