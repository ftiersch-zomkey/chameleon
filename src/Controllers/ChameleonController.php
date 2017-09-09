<?php
 
namespace Ftiersch\Chameleon\Controllers;
 
use App\Http\Controllers\Controller;

/**
 * Class ChameleonController
 *
 * The ChameleonController adds two route endpoints that are responsible for
 * starting an impersonation and ending it.
 *
 */
class ChameleonController extends Controller
{
    protected $userClass = null;
    
    public function __construct() 
    {
        // retrieve the user class used for authenticating from the configuration
        $this->userClass = config('auth.providers.users.model');
    }

    /**
     * The impersonate method starts the impersonation of the given user. After setting everything
     * needed the application will be redirected so the changes can take effect on the next request.
     *
     * @param User $user The user that should be impersonated
     */
    public function impersonate($user)
    {
        // TODO: make this php5 available
        // try to retrieve the given user - otherwise fail
        $user = $this->userClass::findOrFail($user);
        
        // start impersonating the fetched user
        auth()->user()->impersonate($user);

        // TODO: make "home" configurable
        // redirect back to home
        return redirect()->route('home');
    }

    /**
     * The stopImpersonating method ends a currently active impersonation. Afterwards the application
     * will be redirected so the changes take effect and the user sees his own account again.
     */
    public function stopImpersonating()
    {
        // stop impersonating the fetched user
        auth()->user()->stopImpersonating();

        // TODO: make "home" configurable
        // redirect back to home
        return redirect()->route('home');
    }
 
}