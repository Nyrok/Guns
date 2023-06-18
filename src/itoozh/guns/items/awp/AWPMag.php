<?php

namespace itoozh\guns\items\awp;

use itoozh\guns\Mag;

final class AWPMag extends Mag
{
    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function gunName(): string
    {
        return 'awp';
    }

    public function gunType(): string
    {
        return 'sniper';
    }

    public function useCooldown(): float
    {
        return 1;
    }
}