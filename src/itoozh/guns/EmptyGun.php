<?php

namespace itoozh\guns;

use customiesdevs\customies\item\CustomiesItemFactory;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use itoozh\guns\Main;
use itoozh\guns\Weapon;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

abstract class EmptyGun extends Item implements ItemComponents, Weapon
{
    use ItemComponentsTrait;

    public function __construct(ItemIdentifier $identifier, string $name = "Unknown")
    {
        parent::__construct($identifier, $name);
        $this->initComponent("{$this->gunType()}:{$this->gunName()}.texture");
        $this->setUseCooldown($this->useCooldown(), "chorusfruit");
    }

    public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems = []): ItemUseResult
    {
        foreach ($player->getInventory()->getContents() as $slot => $item) {
            if ($item::class !== $this->bullet()) continue;
            $item->pop();
            $player->getInventory()->setItem($slot, $item);
            $player->getInventory()->setItemInHand(CustomiesItemFactory::getInstance()->get("{$this->gunType()}:{$this->gunName()}")->updateAmmo($player, -1));
            Main::playSound("pixelpoly.{$this->soundReload()}", $player->getPosition(), 5, 0.5);
            return ItemUseResult::SUCCESS();
        }
        Main::playSound("pixelpoly.{$this->soundOutOfAmmo()}", $player->getPosition(), 5, 0.5);
        return ItemUseResult::FAIL();
    }

    abstract public function soundReload(): string;

    abstract public function soundOutOfAmmo(): string;

    public function getMaxStackSize(): int
    {
        return 1;
    }
}