<?php

declare(strict_types=1);

namespace taylordevs\WorldDefend\event;

use pocketmine\event\block\BlockBreakEvent as PMBlockBreakEvent;
use pocketmine\event\Listener;
use taylordevs\WorldDefend\language\KnownTranslations;
use taylordevs\WorldDefend\language\LanguageManager;
use taylordevs\WorldDefend\language\TranslationKeys;
use taylordevs\WorldDefend\world\WorldManager;

class BlockBreakEvent implements Listener
{

    public function onBreakBlock(PMBlockBreakEvent $event): void
    {
        $world = $event->getBlock()->getPosition()->getWorld();
        $isLock = WorldManager::getProperty(
            world: $world,
            property: "lock"
        );
        $player = $event->getPlayer();
        if($isLock) {
            $player->sendMessage(
                message: LanguageManager::getTranslation(
                    key: KnownTranslations::WORLD_LOCKED,
                    replacements: [
                        TranslationKeys::WORLD => $world->getDisplayName()
                    ]
                )
            );
            $event->cancel();
        }
    }
}