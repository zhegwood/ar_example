<?php

namespace App\Http\Controllers;

use App\Models\BbAppearance;
use App\Models\BcsAppearance;

class UtilController extends Controller
{
    public function seasons()
    {
        $arr1 = BbAppearance::all()->pluck('season')->unique()->toArray();
        $arr2 = BcsAppearance::all()->pluck('season')->unique()->toArray();
        return response()->json(array_unique(array_merge($arr1, $arr2)));
    }
}
