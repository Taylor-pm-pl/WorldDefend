<?php

declare(strict_types=1);

namespace taylordevs\WorldDefend\event;

use pocketmine\event\player\PlayerItemUseEvent as PMPlayerItemUseEvent;
use taylordevs\WorldDefend\language\KnownTranslations;
use taylordevs\WorldDefend\language\LanguageManager;
use taylordevs\WorldDefend\language\TranslationKeys;
use taylordevs\WorldDefend\world\WorldManager;
use taylordevs\WorldDefend\world\WorldProperty;

class PlayerItemUseEvent
{

    public function onItemUse(PMPlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $world = $player->getWorld();
        $itemTypeId = $event->getItem()->getTypeId();
        $worldItemBanned = WorldManager::getProperty(
            world: $world,
            property: WorldProperty::BAN_ITEM
        );
        if (is_array($worldItemBanned)) {
            if (in_array($itemTypeId, $worldItemBanned)) {
                $player->sendMessage(
                    message: LanguageManager::getTranslation(
                        key: KnownTranslations::WORLD_BAN_ITEM,
                        replacements: [
                            TranslationKeys::WORLD => $world->getDisplayName(),
                            TranslationKeys::ITEM => $event->getItem()->getName()
                        ]
                    )
                );
                $event->cancel();
            }
        }
    }
}