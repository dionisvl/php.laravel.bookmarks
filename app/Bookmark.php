<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bookmark extends Model
{
    protected $fillable = ['title', 'favicon', 'url_origin', 'meta_description', 'meta_keywords'];

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->slug = static::getSlug($fields['title']);
        $post->save();

        return $post;
    }

    private static function getSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }
        return $slug;
    }

    public function remove()
    {
//        $this->removeImage('favicon');
        $this->delete();
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->slug = static::getSlug($fields['title']);
        $this->save();
    }

}
