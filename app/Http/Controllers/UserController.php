<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hobby;
use App\Models\User;
use App\Models\UserHobby;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function home(){
        $users = User::orderBy('id', 'desc')->get();
        return view('userlist',compact('users'));
    }
    public function addUser(){
        $categories = Category::all();
         $hobbies = Hobby::all();
         
        return view('adduser',compact('categories','hobbies'));
    }

    public function createUser(Request $request){
    try{   
            $validated = $request->validate([
                'name' => 'required|min:4|max:20',
                'contact' => 'required|regex:/^[0-9+ ]+$/|min:8|max:20',
                'profile_pic' => 'required|image|max:2048',
                'hobbies'=>'required'
            ]);
            $input = [
                'name'=>request('name'),
                'contact_no'=>request('contact'),
                'category_id'=>request('category'),
                
            ];

            if($request->hasFile('profile_pic')){
                $file = $request->file('profile_pic');
                $extension = $file->extension();
                $fileName = 'user_pic'.time().'.'. $extension;
                $file->move('uploads/users/', $fileName );
                $input['image']= $fileName ;
            }
            $user = User::create($input);
            //insert hobby
            $user_id = $user->id;

            $hobbies = request('hobbies');
            foreach ($hobbies as $hobby) {
                UserHobby::create([
                    'user_id' => $user_id,
                    'hobby' => $hobby,
                ]);
            }


            return redirect()->route('home')->with('message','Employee Details added Successfully');
        }
        catch (QueryException $e) {
            return redirect()->route('home')->with('error', 'Failed to add new employee');
        }
    }

    public function editUser($userId){
        $user= User::find(decrypt($userId));

        $selectedhobbies = UserHobby::where('user_id',decrypt($userId))->get();
        $user_hobbies = $selectedhobbies->pluck('hobby')->toArray();
      
        $categories = Category::all();
        $hobbies = Hobby::all();
        return view('updateUser',compact('categories','hobbies','user','user_hobbies'));
    }

    public function updateUser(Request $request){

        $validated = $request->validate([
            'name' => 'required|min:4|max:20',
            'contact' => 'required|regex:/^[0-9+ ]+$/|min:8|max:20',
            'profile_pic' => 'sometimes|image|max:2048',
            'hobbies'=>'required'
        ]);
        $input = [
            'name'=>request('name'),
            'contact_no'=>request('contact'),
            'category_id'=>request('category'),
            
        ];

        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $extension = $file->extension();
            $fileName = 'user_pic'.time().'.'. $extension;
            $file->move('uploads/users/', $fileName );
            $input['image']= $fileName ;
        }
        $user_id = decrypt(request('user_id'));
        $user = User::find($user_id);
        $user ->update($input);
      
      //delete old hobbies
        $user_hobbies = UserHobby::where('user_id',$user_id)->get();
        foreach( $user_hobbies as $userhobby){
            $userhobby->delete();
        }
        //insert new hobby 
        $hobbies = request('hobbies');
        foreach ($hobbies as $hobby) {
            UserHobby::create([
                'user_id' => $user_id,
                'hobby' => $hobby,
            ]);
        }

        return redirect()->route('home')->with('message','Employee Details updated Successfully');
     
    }

    public function delete($userId){
        
          $user = User::find($userId);
       // return response()->json(['success' => $userId]);
        //delete user hobbies
        $user_hobbies = UserHobby::where('user_id',$userId)->get();
        foreach( $user_hobbies as $userhobby){
            $userhobby->delete();
        }
        //delete file from folder
         $imagePath = public_path('uploads/users/' . $user->image);
         if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        //delete user from table
        $user->delete();
        return response()->json(['success' => 'Employee details deleted successfully.']);
    }
    
}
