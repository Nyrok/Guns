<?php

namespace itoozh\guns\items\awp;

use itoozh\guns\entities\AWPBullet;
use itoozh\guns\Gun;

final class AWP extends Gun
{
    public function gunType(): string
    {
        return 'sniper';
    }

    public function gunName(): string
    {
        return 'awp';
    }

    public function useCooldown(): float
    {
        return 1;
    }

    public function useDuration(): int
    {
        return 40;
    }

    public function ammo(): int
    {
        return 1;
    }

    public function soundFire(): string
    {
        return 'awp_fire';
    }

    public function fireForce(): float
    {
        return 1000;
    }

    public function bullet(): string
    {
        return AWPBullet::class;
    }
}