<?php

namespace Ftiersch\Chameleon\Interfaces;

interface Impersonator {
    public function canImpersonate($user);
    public function impersonate($user);
    public function stopImpersonating();
}
