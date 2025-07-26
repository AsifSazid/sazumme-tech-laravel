<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        dd(Auth::guard('admin')->check());
        return view('admin.dashboard');
    }

    public function userDashboard()
    {
        $domainController = new DomainController;

        $sub = $domainController->getSubdomain();
        $wing = $domainController->getWingInfos();


        // dd($sub, $wing);


        return view('dashboard'); // User dashboard view
    }

}
