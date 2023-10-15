<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    use HasFactory;

    //relationship
    public function categoryName(){
        return $this->belongsTo(Category::class,'category_id', 'id');
    }
    protected $fillable =['name','contact_no','category_id','image']; 


    public function hobbies(){
        return $this->hasMany(UserHobby::class,'user_id','id');
    } 
}
