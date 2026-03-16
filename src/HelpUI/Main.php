<?php

declare(strict_types=1);

namespace HelpUI;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    public function onEnable(): void{

        $this->saveDefaultConfig();

        $commandMap = $this->getServer()->getCommandMap();

        $existing = $commandMap->getCommand("help");

        if($existing !== null){
            $commandMap->unregister($existing);
        }

        $commandMap->register("helpui", new HelpCommand($this));
    }
}
