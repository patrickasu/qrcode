<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version June 25, 2020, 4:42 am UTC
 *
 * @property string $name
 * @property integer $role_id
 * @property string $email
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'role_id',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'role_id' => 'integer',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'role_id' => 'required',
        'email' => 'required',
        'password' => 'required'
    ];

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function qrcodes(){
        return $this->hasMany('App\Models\Qrcode');
    }

    public function role(){
        return $this->belongsTo('App\Models\Role');
    }

    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }

    public function account_histories(){
        return $this->belongsTo('App\Models\AccountHistory');
    }
    
}
