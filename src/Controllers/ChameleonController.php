<?php
 
namespace Ftiersch\Chameleon\Controllers;
 
use App\Http\Controllers\Controller;
 
class ChameleonController extends Controller
{
    protected $userClass = null;
    
    public function __construct() 
    {
        // retrieve the user class used for authenticating from the configuration
        $this->userClass = config('auth.providers.users.model');
    }
 
    public function impersonate($user)
    {        
        // try to retrieve the given user - otherwise fail
        $user = $this->userClass::findOrFail($user);
        
        // start impersonating the fetched user
        auth()->user()->impersonate($user);
        
        // redirect back to home
        return redirect()->route('home');
    }
    
    public function stopImpersonating()
    {
        // stop impersonating the fetched user
        auth()->user()->stopImpersonating();
        
        // redirect back to home
        return redirect()->route('home');
    }
 
}