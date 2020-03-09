<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'hash' => 'required|unique:news',
        'content' => 'required',
        'publish_at' => 'required|date',
        'image' => 'nullable|url'
    ];

    /**
     * @var array
     */
    protected $fillable = ['hash', 'title', 'content', 'image', 'publish_at'];
}
