<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'image'];

    public function getImagePathAttribute()
    {
        $path = null;
        if ($this->image != '' && Storage::exists($this->image))
        {
            $path = Storage::url($this->image);
        }else{
            $path = 'https://thumbs.dreamstime.com/b/demo-demo-icon-139882881.jpg';
        }
        return $path;
    }
}
