<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Userservice;

class User extends Model implements AuthenticatableContract,
  AuthorizableContract,
  CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public $dates = ['login_at','logout_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public static function createOrGetClefuser($info)
    {
        if(is_null($info)){
            throw new \Exception("No Clef userinfo parsed, so it can't be stored in the Database");
        }
        $user = self::where('email', $info['email'])->first();

        if (!$user) {
            $user = new User;
            $user->email = $info['email'];
            $user->name = $info['first_name'].' '.$info['last_name'];
            $user->save();

            // Add clef key to user
            $service = new Userservice([
              'clef'=> $info['id']
            ]);
            $user->service()->save($service);

        }

        // Add login time
        $user->login_at = date('Y-m-d G:i:s');
        $user->save();

        return $user;

    }

    public function service(){
        return $this->hasOne('App\Userservice');
    }

    public function payments(){
        return $this->hasMany('App\Payment');
    }

    public function unpaidPayment(){
        return $this->hasMany('App\Payment')
                ->where('active',1)
                ->where('paid',0);
    }
}
