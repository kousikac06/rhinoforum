<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

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
    protected $table = 'rhinoforum.post';

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
        'user_id',
        'content',
        'category',
        'published_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
