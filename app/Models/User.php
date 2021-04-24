<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

     /**
     * 此模型的連接名稱
     *
     * @var string
     */
    protected $connection = 'rhinoforum';

    /**
     * 與模型關聯的資料表
     *
     * @var string
     */
    protected $table = 'rhinoforum.user';

     /**
     * 模型的主鍵
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 指示ID是否自動遞增
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * 指定是否模型應該被戳記時間
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
