<?php

namespace itoozh\guns;

interface Weapon
{
    public function gunType(): string;

    public function gunName(): string;

    public function bullet(): string;

    public function useCooldown(): float;
}