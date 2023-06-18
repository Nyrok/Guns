<?php

namespace itoozh\guns\items\akm;

use itoozh\guns\Mag;

final class AKMMag extends Mag
{
    public function gunType(): string
    {
        return 'ar';
    }

    public function gunName(): string
    {
        return 'akm';
    }

    public function useCooldown(): float
    {
        return 0.05;
    }
}