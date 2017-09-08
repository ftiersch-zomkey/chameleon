<?php

namespace Ftiersch\Chameleon\Traits;

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