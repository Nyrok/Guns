<?php

namespace itoozh\guns;

use pocketmine\entity\projectile\Snowball;

abstract class Bullet extends Snowball
{
    abstract public function getDamage(): float;
}