<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Bookmark extends Model
{
    use Searchable;

    protected $fillable = ['title', 'favicon', 'url_origin', 'meta_description', 'meta_keywords', 'token'];

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

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'bookmarks_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        // Customize array...
        return $array;
    }
}
