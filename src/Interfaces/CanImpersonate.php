<?php

namespace Ftiersch\Chameleon\Interfaces;

/**
 * Interface CanImpersonate
 *
 * This interface gets implemented by the User class to make sure the user
 * implements all methods needed to impersonate another user. For simplicity
 * there is also a trait that implements basic versions of the methods.
 */
interface CanImpersonate {
    public function canImpersonate($user);
    public function impersonate($user);
    public function stopImpersonating();
}
