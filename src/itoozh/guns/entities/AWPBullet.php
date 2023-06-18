<?php

namespace itoozh\guns\entities;

use itoozh\guns\Bullet;

final class AWPBullet extends Bullet
{
    public function getDamage(): float
    {
        return 7.5;
    }
}