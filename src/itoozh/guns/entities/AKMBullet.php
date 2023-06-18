<?php

namespace itoozh\guns\entities;

use itoozh\guns\Bullet;

final class AKMBullet extends Bullet
{
    public function getDamage(): float
    {
        return 1;
    }
}