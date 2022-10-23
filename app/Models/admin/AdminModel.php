<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class AdminModel extends Model implements  \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
    use HasFactory;
    protected  $table="admin";
    protected $fillable=['name','sex','emile','isremember','slove','try_question','team','school','last_login'];
}
