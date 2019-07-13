<?php

namespace App\Entites\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class UserModel
 * @package App\Entites\Users
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends Authenticatable
{
    protected $table = 'users';

    use Notifiable;

    public $timestamps = false;

    protected $guarded = [];

    public static function create($name, $email)
    {
        $user = new static();
        $user->name = $name;
        $user->email = $email;
        return $user;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function getById(int $id)
    {
        return $this->findOrFail($id);
    }

    protected function getAll()
    {
        return $this->all();
    }
}
