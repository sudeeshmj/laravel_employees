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
   
<h4>Add New User</h4>
<form action="{{route('create.user')}}" method="post"  id="userForm" enctype="multipart/form-data">
    @csrf
    <table class="table table-bordered table-sm " >
        <tbody>
            <tr> <td style="width: 25%;">Name</td>
            <td style="width: 70%;"> <input type="text" class="form-control" name="name" placeholder="Enter name">
                @error('name')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Contact no</td>
            <td> <input type="text" class="form-control" name="contact" placeholder="Enter contact no">
                @error('contact')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Hobby</td>
            <td> 
                @if(count($hobbies) > 0)
                    @foreach ($hobbies as $hobby)
                    <input type="checkbox" name="hobbies[]" value="{{$hobby->name}}">&nbsp;{{$hobby->name}}
                    @endforeach
                @else
                    <input type="checkbox" name="hobbies[]" value="Programming">&nbsp;Programming
                @endif
                @error('hobbies')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Category</td>
            <td> <select class="form-select form-select" name="category">
                <option selected value="">Select</option>
                   @foreach ($categories as $category)
                   <option value="{{$category->id}}">{{$category->name}}</option>
                   @endforeach
                </select>
                @error('category')<span class="error-message">{{$message}}</span>@enderror
            </td></tr>

            <tr> <td>Profile Pic</td>
                <td>  <input type="file" accept="image/*" class="form-control form-control-sm" name="profile_pic">
                    @error('profile')<span class="error-message">{{$message}}</span>@enderror
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
                profile_pic: {
                    required: true,
                }
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
                profile_pic: {
                    required: "Please upload profile_pic."
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
