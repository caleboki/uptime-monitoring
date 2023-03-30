<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteStoreRequest;
use Illuminate\Http\Request;

class SiteStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(SiteStoreRequest $request)
    {
        $site = $request->user()->sites()->create($request->only(['domain']));
        return redirect()->route('dashboard', $site);
    }
}
