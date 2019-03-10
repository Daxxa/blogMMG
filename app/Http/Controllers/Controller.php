<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $browsers = ['Firefox'=>0,'Opera'=>0,'Chrome'=>0,'Internet Explorer'=>0,'Safari'=>0,'Unknown'=>0];
        $db=DB::table('sessions')->select('ip_address','user_agent')->get()->toArray();
        foreach ($db as $one){
            $user_agent = $one->user_agent;
            if (strpos($user_agent, "Firefox") !== false) $browsers['Firefox']++;
            elseif (strpos($user_agent, "OPR") !== false) $browsers["Opera"]++;
            elseif (strpos($user_agent, "Chrome") !== false)$browsers["Chrome"]++;
            elseif (strpos($user_agent, "Trident") !== false || strpos($user_agent, "MSIE") !== false) $browsers["Internet Explorer"]++;
            elseif (strpos($user_agent, "Safari") !== false) $browsers["Safari"]++;
            else $browsers["Unknown"]++;
        }
        View::share('myvar', $browsers);
    }
}
