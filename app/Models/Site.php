<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'default',
        'domain',
        'scheme'
    ];

    public static function booted() {
        static::updating(function (Site $site) {
            
            // is the site being updated to set default = true?
            // grab all sites where id !== site we are updating
            // set default = false

            if (in_array('default', array_keys($site->getDirty()))) {
                $site->user->sites()->whereNot('id', $site->id)->update(['default' => false]);
            }



        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
