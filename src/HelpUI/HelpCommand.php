<?php

declare(strict_types=1);

namespace HelpUI;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use jojoe77777\FormAPI\SimpleForm;

class HelpCommand extends Command{

    private Main $plugin;

    public function __construct(Main $plugin){
        parent::__construct("help", "View server help");

        $this->setPermission("helpui.use");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool{

        if(!$sender instanceof Player){
            $sender->sendMessage("Run this command in-game.");
            return true;
        }

        $config = $this->plugin->getConfig();

        $sender->sendMessage($this->color($config->getNested("messages.open")));

        $form = new SimpleForm(function(Player $player, $data) use ($config){

            if($data === null){
                return;
            }

            $player->sendMessage($this->color($config->getNested("messages.close")));
        });

        $form->setTitle($this->color($config->getNested("form.title")));
        $form->setContent($this->color($config->getNested("form.content")));
        $form->addButton($this->color($config->getNested("form.close-button")));

        $sender->sendForm($form);

        return true;
    }

    private function color(string $text): string{
        return str_replace("&", "§", $text);
    }
}
