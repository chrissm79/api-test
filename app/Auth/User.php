<?php

namespace App\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable, SoftDeletes;

}
