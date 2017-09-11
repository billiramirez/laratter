<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Message extends Model
{

    use Searchable;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute($image)
        /**
         *  This method intercept the request of the property and make it a method in order to obtain directly the
         * attribute, in this case it is required cause we've got images from lorempixel service and uploaded
         * from the users as well
         **/
    {
        if (!$image || starts_with($image,'http'))
        {
            return $image;
        }

        return \Storage::disk('public')->url($image);
    }

            public function toSearchableArray()
            {
                $this->load('user');
                return $this->toArray();

            }

            public function responses() 
            {
                return $this->hasMany(Response::class)->latest();
            }
}
