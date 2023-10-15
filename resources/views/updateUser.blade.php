@extends('layouts.home')
@section('content')
<style>
    label.error {
        color: red;
    }
    .error-message {
        color: red;
    }
</style>
   <div class="employee_container p-5 mx-auto " style="max-width: 650px;">
   
<h4>Edit User</h4>
<form action="{{route('update.user')}}" method="post"  id="userForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{encrypt($user->id)}}">
    <table class="table table-bordered table-sm " >
        <tbody>
            <tr> <td style="width: 25%;">Name</td>
            <td style="width: 70%;"> <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{$user->name}}">
                @error('name')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Contact no</td>
            <td> <input type="text" class="form-control" name="contact" placeholder="Enter contact no" value="{{$user->contact_no}}">
                @error('contact')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Hobby</td>
            <td> 
                @if(count($hobbies) > 0)    
             @foreach ($hobbies as $hobby)
             <input type="checkbox" name="hobbies[]" value="{{$hobby->name}}" @if(in_array($hobby->name, $user_hobbies)) checked @endif>&nbsp;{{$hobby->name}}
               
             @endforeach
                @else
                <input type="checkbox" name="hobbies[]" value="Programming" checked >&nbsp;Programming
        
                @endif
          
            </td></tr>

            <tr> <td>Category</td>
            <td> <select class="form-select form-select" name="category" >
                <option  value="">Select</option>
                   @foreach ($categories as $category)
                   <option value="{{$category->id}}" @if ($category->id == $user->category_id) selected @endif>{{$category->name}}</option>
                   @endforeach
                </select>
                @error('category')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Profile Pic</td>
                <td>  <input type="file" accept="image/*" class="form-control form-control-sm" name="profile_pic">
                    <input type="hidden" name="old_prof_pic"  id="old_prof_pic" value="{{$user->image}}">
                    @error('profile_pic')<span class="error-message">{{$message}}</span>@enderror
                 </td>
            </tr>
            <tr> 
                <td colspan="2" class="text-center">
                    <button type="submit" class="btn btn-success btn-md me-2">Save</button>
                    <a href="{{route('home')}}" class="btn btn-danger btn-md">Cancel</a>
                 </td>
            </tr>
        
        </tbody>
        </table>


      </form>

   </div>
   <script>
    $(document).ready(function () {
        $.validator.addMethod("customcontact", function(value, element) {
                return this.optional(element) || /^[0-9+ ]+$/.test(value);
            }, "Please enter a valid contact number.");

        $('#userForm').validate({ 
            rules: {
                name: {
                    required: true,
                    minlength: 4,
                    maxlength:20,
                },
                contact: {
                    required: true,
                    customcontact:true,
                    minlength: 8,
                    maxlength:20,
                },
                'hobbies[]': {
                    required: true,
                   
                },
                category: {
                    required: true,
                   
                },
               
            },
            messages: {
                name: {
                    required: "Please enter name."
                },
                contact: {
                    required: "Please enter contact no."
                },
                'hobbies[]': {
                    required: "Please select at least one hobby."
                },
                category: {
                    required: "Please select category."
                },
               
            },
            errorPlacement: function (error, element) {
                if (element.is(":checkbox")) {
                    error.appendTo(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
       
    });
    </script>
@endsection
