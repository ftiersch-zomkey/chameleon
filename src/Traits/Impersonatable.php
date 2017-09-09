<?php

namespace Ftiersch\Chameleon\Traits;

/**
 * Trait Impersonatable
 *
 * This trait implements basic versions of all methods needed to impersonate another user.
 * If used by the User class everything should be in place.
 * For better security the canImpersonate($user) method can be overridden to implement own
 * security checks.
 */
trait Impersonatable {
    public function impersonate($user) {
        if ($user->id == $this->id) {
            throw new \Exception("You can't impersonate yourself");
        }
        session([
            'ftiersch-chameleon-impersonate' => base64_encode($this->id . ":" . $user->id)
        ]);
    }
    
    public function stopImpersonating() {
        session()->forget('ftiersch-chameleon-impersonate');
        session()->forget('ftiersch-chameleon-is-impersonating');
    }
    
    public function canImpersonate($user) {
        return $user->id != $this->id;
    }
}