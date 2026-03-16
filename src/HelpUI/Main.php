<?php

declare(strict_types=1);

namespace HelpUI;

use pocketmine\plugin\PluginBase;
use pocketmine\command\SimpleCommandMap;

class Main extends PluginBase{

    public function onEnable(): void{

        $this->saveDefaultConfig();

        $commandMap = $this->getServer()->getCommandMap();

        $this->removeDefaultHelp($commandMap);

        $commandMap->register("helpui", new HelpCommand($this));
    }

    private function removeDefaultHelp(SimpleCommandMap $commandMap): void{

        $command = $commandMap->getCommand("help");

        if($command !== null){
            $commandMap->unregister($command);
        }

        $reflection = new \ReflectionClass($commandMap);

        if($reflection->hasProperty("knownCommands")){
            $property = $reflection->getProperty("knownCommands");
            $property->setAccessible(true);

            $commands = $property->getValue($commandMap);

            foreach($commands as $name => $cmd){
                if($name === "help"){
                    unset($commands[$name]);
                }
            }

            $property->setValue($commandMap, $commands);
        }
    }
}
