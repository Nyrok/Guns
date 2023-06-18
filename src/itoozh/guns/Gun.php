<?php

namespace itoozh\guns;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\CustomiesItemFactory;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\item\Food;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

abstract class Gun extends Food implements ItemComponents, Weapon
{
    use ItemComponentsTrait;

    public function __construct(ItemIdentifier $identifier, string $name = "Unknown")
    {
        parent::__construct($identifier, $name);
        $this->initComponent("{$this->gunType()}.{$this->gunName()}.texture", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, "itemGroup.name.diamond"));
        $this->setUseCooldown($this->useCooldown(), "chorusfruit");
        $this->setUseDuration($this->useDuration());
        $namedTag = $this->getNamedTag();
        $namedTag->setInt('mags', $this->ammo());
        $this->setNamedTag($namedTag);
    }


    abstract public function useDuration(): int;

    abstract public function ammo(): int;

    public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems = []): ItemUseResult
    {
        $this->fire($player);
        return ItemUseResult::SUCCESS();
    }

    protected function fire(Player $player): void
    {
        $namedTag = $this->getNamedTag();
        $namedTag->setInt('mags', $namedTag->getInt('mags') - 1);
        $this->setNamedTag($namedTag);
        Main::playSound("pixelpoly.{$this->soundFire()}", $player->getPosition(), 5, 0.5);
        $ball = new ($this->bullet())(Location::fromObject($player->getEyePos(), $player->getWorld(), $player->getLocation()->getYaw(), $player->getLocation()->getPitch()), $player);
        $ball->setMotion($ball->getDirectionVector()->multiply($this->fireForce()));
        $ball->setScale(0.001);
        $ball->spawnToAll();
        $this->updateAmmo($player, $namedTag->getInt('mags'));
        if ($namedTag->getInt('mags', 0) === 0) {
            $player->getInventory()->setItemInHand(CustomiesItemFactory::getInstance()->get("{$this->gunType()}:{$this->gunName()}_empty"));
        } else {
            $player->getInventory()->setItemInHand($this);
        }
    }

    public function updateAmmo(Player $player, int $ammo): self {
        if($ammo === -1) $ammo = $this->ammo();
        $this->setLore(["§6Munitions:", "§e{$ammo}§7/{$this->ammo()}"]);
        $player->sendPopup("§e{$ammo}§7/{$this->ammo()}");
        return $this;
    }

    abstract public function soundFire(): string;

    abstract public function fireForce(): float;

    public function getResidue(): Item
    {
        return $this;
    }

    public function canStartUsingItem(Player $player): bool
    {
        return true;
    }

    public function requiresHunger(): bool
    {
        return false;
    }

    public function onConsume(Living $consumer): void
    {
        if (!$consumer instanceof Player) return;
        $this->fire($consumer);
    }

    public function getFoodRestore(): int
    {
        return 0;
    }

    public function getSaturationRestore(): float
    {
        return 0.0;
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }
}