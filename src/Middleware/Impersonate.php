<?php

namespace Ftiersch\Chameleon\Middleware;

use Closure;

class Impersonate
{
    /**
     * Start impersonating another user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // impersonating only works if 
        // - there is a user logged in
        // - an impersonation has been started
        if(auth()->check() && $request->session()->has('ftiersch-chameleon-impersonate'))
        {
            // retrieve the User class from configuration
            $userClass = config('auth.providers.users.model');
            
            // pull the impersonation information from the session and convert it to IDs
            $stored = explode(":", base64_decode($request->session()->get('ftiersch-chameleon-impersonate')));
            
            $impersonatingUser = $stored[0];
            $impersonatedUser = $userClass::findOrFail($stored[1]);
            
            // first security measure:
            // check if the currently logged in user has another id than 
            // the one that started the impersonation
            if (!auth()->user()->id == $impersonatingUser) {
                // TODO: Better Exception
                throw new \Exception("Fraud detected - someone else started the impersonation");
            }
            
            // second security measure:
            // check if the currently logged in user is actually allowed 
            // to impersonate the given user
            if (!auth()->user()->canImpersonate($impersonatedUser)) {
                // TODO: Better Exception
                throw new \Exception("You are not allowed to impersonate the given user");
            }
            
            // login as the impersonated user for this one request
            auth()->onceUsingId($impersonatedUser->id);
            
            // flash an info to the session for this request to see we are 
            // currently impersonating someone
            $request->session()->flash('ftiersch-chameleon-is-impersonating', true);
        }

        return $next($request);
    }

}