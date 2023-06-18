<?php

namespace itoozh\guns\items\akm;

use itoozh\guns\EmptyGun;

final class AKMEmpty extends EmptyGun
{
    public function useCooldown(): float
    {
        return 0.05;
    }

    public function soundReload(): string
    {
        return 'akm_boltpull';
    }

    public function soundOutOfAmmo(): string
    {
        return 'akm_magout';
    }

    public function gunName(): string
    {
        return 'akm';
    }

    public function gunType(): string
    {
        return 'ar';
    }

    public function bullet(): string
    {
        return AKMMag::class;
    }
}