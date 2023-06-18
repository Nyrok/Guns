<?php

namespace itoozh\guns;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;

abstract class Mag extends Item implements ItemComponents, Weapon
{
    use ItemComponentsTrait;

    public function __construct(ItemIdentifier $identifier, string $name = "Unknown")
    {
        parent::__construct($identifier, $name);
        $this->initComponent("{$this->gunType()}:{$this->gunName()}_mag.texture", new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, "itemGroup.name.diamond"));
        $this->setUseCooldown($this->useCooldown(), "chorusfruit");
    }

    public function bullet(): string
    {
        return $this::class;
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }
}