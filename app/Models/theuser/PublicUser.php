<?php

namespace App\Models\theuser;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PublicUser extends Model implements  \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
    use HasFactory;
    protected $table='users';
    protected $fillable=['name','sex','emile','isremember','slove','try_question','team','school','last_login'];
}
