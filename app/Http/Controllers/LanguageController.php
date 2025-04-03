<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($language)
    {
        session(['locale' => $language]);
        return back();
    }
}
