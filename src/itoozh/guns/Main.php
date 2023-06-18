<?php

namespace itoozh\guns;

use customiesdevs\customies\item\CustomiesItemFactory;
use itoozh\guns\entities\AKMBullet;
use itoozh\guns\entities\AWPBullet;
use itoozh\guns\items\akm\AKM;
use itoozh\guns\items\akm\AKMEmpty;
use itoozh\guns\items\akm\AKMMag;
use itoozh\guns\items\awp\AWP;
use itoozh\guns\items\awp\AWPEmpty;
use itoozh\guns\items\awp\AWPMag;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\Listener;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\world\Position;
use pocketmine\world\World;
use ReflectionException;
use ReflectionProperty;

class Main extends PluginBase implements Listener
{
    public static function playSound(string $soundName, Position $position, int $volume = 500, float $pitch = 1): void
    {
        $pk = new PlaySoundPacket;
        $pk->soundName = $soundName;
        $pk->x = $position->x;
        $pk->y = $position->y;
        $pk->z = $position->z;
        $pk->volume = $volume;
        $pk->pitch = $pitch;
        $position->world->broadcastPacketToViewers($position, $pk);
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        EntityFactory::getInstance()->register(AKMBullet::class, function (World $world, CompoundTag $nbt): AKMBullet {
            return new AKMBullet(EntityDataHelper::parseLocation($nbt, $world), null, $nbt);
        }, ['AKMBullet']);
        EntityFactory::getInstance()->register(AWPBullet::class, function (World $world, CompoundTag $nbt): AWPBullet {
            return new AWPBullet(EntityDataHelper::parseLocation($nbt, $world), null, $nbt);
        }, ['AWPBullet']);
    }

    public function onHitByProjectile(ProjectileHitEntityEvent $event): void
    {
        $hit = $event->getEntityHit();
        if (!$hit instanceof Player) return;
        $entity = $event->getEntity();
        $player = $entity->getOwningEntity();
        if (!$player instanceof Player) return;
        if (!$entity instanceof Bullet) return;
        $hit->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_PROJECTILE, $entity->getDamage()));
    }

    /**
     * @throws ReflectionException
     */
    protected function onLoad(): void
    {
        $this->saveResource("Guns.mcpack");
        $packManager = $this->getServer()->getResourcePackManager();
        $packManager->setResourceStack(array_merge($packManager->getResourceStack(), [new ZippedResourcePack($this->getDataFolder() . "Guns.mcpack")]));
        ($serverForceResources = new ReflectionProperty($packManager, "serverForceResources"))->setAccessible(true);
        $serverForceResources->setValue($packManager, true);

        CustomiesItemFactory::getInstance()->registerItem(AKM::class, "ar:akm", "AKM");
        CustomiesItemFactory::getInstance()->registerItem(AKMMag::class, "ar:akm_mag", "AKM Mag");
        CustomiesItemFactory::getInstance()->registerItem(AKMEmpty::class, "ar:akm_empty", "AKM Empty");
        CustomiesItemFactory::getInstance()->registerItem(AWP::class, "sniper:awp", "AWP");
        CustomiesItemFactory::getInstance()->registerItem(AWPEmpty::class, "sniper:awp_empty", "AWP Empty");
        CustomiesItemFactory::getInstance()->registerItem(AWPMag::class, "sniper:awp_mag", "AWP Mag");
    }
}