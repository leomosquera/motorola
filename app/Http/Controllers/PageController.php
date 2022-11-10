<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function error404()
    {
        $pageConfigs = [
            'self' => [
                'layout' => 'blank'
            ]
        ];
        return view('/pages/error/404', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function error419()
    {
        $pageConfigs = [
            'self' => [
                'layout' => 'blank'
            ]
        ];
        return view('/pages/error/419', [
            'pageConfigs' => $pageConfigs
        ]);
    }

}
