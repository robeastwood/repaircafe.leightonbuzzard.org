<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class PolicyController extends Controller
{
    public function showPolicy(Request $request)
    {
        $policyFile = Jetstream::localizedMarkdownPath(
            $request->path() . ".md"
        );

        return view("policy", [
            "policy" => Str::markdown(file_get_contents($policyFile)),
        ]);
    }
}
