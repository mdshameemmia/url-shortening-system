<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortLink extends Model
{
    use HasFactory;

    protected $table ='short_links';
    protected $guarded = [];


    public static function createShortLink($original_url, $short_url)
    {
        self::create([
            'original_url' => $original_url,
            'short_url' => $short_url,
            'user_id'=>auth()->user()->id
        ]);

        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
