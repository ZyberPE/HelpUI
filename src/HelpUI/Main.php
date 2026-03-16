<?php

declare(strict_types=1);

namespace HelpUI;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandMap;

class Main extends PluginBase{

    public function onEnable(): void{

        $this->saveDefaultConfig();

        $commandMap = $this->getServer()->getCommandMap();

        $this->unregisterHelp($commandMap);

        $commandMap->register("helpui", new HelpCommand($this));
    }

    private function unregisterHelp(CommandMap $commandMap): void{

        $command = $commandMap->getCommand("help");

        if($command !== null){
            $commandMap->unregister($command);
        }

        $knownCommands = $commandMap->getKnownCommands();

        foreach($knownCommands as $name => $cmd){
            if($name === "help"){
                unset($knownCommands[$name]);
            }
        }

        $reflection = new \ReflectionClass($commandMap);
        $property = $reflection->getProperty("knownCommands");
        $property->setAccessible(true);
        $property->setValue($commandMap, $knownCommands);
    }
}
