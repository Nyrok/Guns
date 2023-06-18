<?php

namespace itoozh\guns\items\akm;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\CustomiesItemFactory;
use customiesdevs\customies\item\ItemComponentsTrait;
use customiesdevs\customies\util\Cache;
use itoozh\guns\entities\AKMBullet;
use itoozh\guns\entities\AWPBullet;
use itoozh\guns\Gun;
use itoozh\guns\Main;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\entity\projectile\Snowball;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

final class AKM extends Gun
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
        return 0.05;
    }

    public function useDuration(): int
    {
        return 2;
    }

    public function ammo(): int
    {
        return 1;
    }

    public function soundFire(): string
    {
        return 'akm_fire';
    }

    public function fireForce(): float
    {
        return 500;
    }

    public function bullet(): string
    {
        return AKMBullet::class;
    }
}