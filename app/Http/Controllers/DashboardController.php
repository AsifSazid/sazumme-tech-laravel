<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard(){
        return view('admin.dashboard');
    }

    public function userDashboard(){
        $domainController = new DomainController;
        
        $sub = $domainController->getSubdomain();
        $wing = $domainController->getWingInfos();


        // dd($sub, $wing);


        return view('dashboard'); // User dashboard view
    }
}
