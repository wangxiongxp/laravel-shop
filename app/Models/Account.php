<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Account extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'account';

    protected $primaryKey = 'account_id';
    protected $keyType = 'int';

    protected $fillable = [
        "account_id",
        "password",
        "account_name",
        "account_nick_name",
        "account_real_name",
        "account_email",
        "account_tel",
        "account_sex",
        "account_status",
        "account_type",
        "account_last_login",
        "account_last_ip",
        "account_image",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username)
    {
        return Account::where('account_name', $username)
            ->first();
    }
}
