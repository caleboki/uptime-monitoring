<?php

namespace App\Observers;
use Illuminate\Support\Arr;
use App\Models\Site;

class SiteObserver
{
    public function creating(Site $site)
    {
        $parsed = parse_url($site->domain);

        $site->scheme = Arr::get($parsed, 'scheme');
        $site->domain = Arr::get($parsed, 'host');
    }

    public function updating(Site $site)
    {
        if (in_array('default', array_keys($site->getDirty()))) {
            $site->user->sites()->whereNot('id', $site->id)->update(['default' => false]);
        }
    }
}
