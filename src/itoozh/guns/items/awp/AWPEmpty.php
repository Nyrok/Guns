<?php

namespace itoozh\guns\items\awp;

use itoozh\guns\EmptyGun;

final class AWPEmpty extends EmptyGun
{
    public function useCooldown(): float
    {
        return 1;
    }

    public function soundReload(): string
    {
        return 'awp_boltbackr';
    }

    public function soundOutOfAmmo(): string
    {
        return 'awp_clipout';
    }

    public function gunName(): string
    {
        return 'awp';
    }

    public function gunType(): string
    {
        return 'sniper';
    }

    public function bullet(): string
    {
        return AWPMag::class;
    }
}