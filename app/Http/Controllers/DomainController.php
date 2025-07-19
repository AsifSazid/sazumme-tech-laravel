<?php

namespace App\Http\Controllers;

use App\Models\Wing;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    protected string $mainDomain;

    public function __construct()
    {
        $this->mainDomain = config('domains.main');
    }
    
    public function isAdminDomain(): bool
    {
        $host = request()->getHost();
        return $host === $this->mainDomain || $host === 'www.' . $this->mainDomain;
    }

    public function getSubdomain(): ?string
    {
        $host = request()->getHost();

        if (str_ends_with($host, '.' . $this->mainDomain)) {
            $subdomain = str_replace('.' . $this->mainDomain, '', $host);
            return $subdomain !== 'www' ? $subdomain : null;
        }

        return null;
    }

    public function getWingInfos(){
        $subdomain = $this->getSubdomain();

        $wingInfo = Wing::where('subdomain', $subdomain)->first();

        return $wingInfo;
    }

    public function getNavigations(){
        $wing = $this->getWingInfos();

        $navigations = Wing::where('subdomain', $wing->uuid)->first();

        return $navigations;
    }
}
