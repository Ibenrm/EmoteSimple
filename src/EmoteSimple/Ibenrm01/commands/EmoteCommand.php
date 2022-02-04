<?php

namespace EmoteSimple\Ibenrm01\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\player\Player;

use EmoteSimple\Ibenrm01\EmoteSimple;
use EmoteSimple\Ibenrm01\library\jojoe77777\FormAPI\{
    SimpleForm, CustomForm, ModalForm
};

class EmoteCommand extends Command {

    public $youre = [];

    /**
     * EmoteCommand constructor.
     * @param EmoteSimple $plugin
     */
    public function __construct(protected EmoteSimple $plugin){
        parent::__construct("emotes", "Emotes Commands", "/emotes [help]");
    }

    /**
     * @param CommandSender $player
     * @param string $label
     * @param array $args
     * 
     * @return bool
     */
    public function execute(CommandSender $player, string $label, array $args) : bool {
        if(!isset($args[0])){
            $player->sendMessage("§cUsage: /emotes help");
            return false;
        }
        switch($args[0]){
            case "create":
                $this->createEmotes($player);
                return true;
                break;
            case "remove":
                if(!isset($args[1])){
                    $player->sendMessage("§cUsage: /emotes remove <string: emoteName>");
                    return false;
                }
                if($this->plugin->getEmotes()->searchEmote($args[1])){
                    $this->removeEmotes($player, $args[1]);
                    return true;
                }
                $player->sendMessage("§cEmotes §d{$args[1]} §cnot found!");
                return false;
                break;
            case "help":
                $player->sendMessage("§a> EmoteSimple Command (1/1)\n".
                "§7/emotes create : §badd emotes use UI\n".
                "§7/emotes remove <string: emoteName> : §bremove emotes by name\n".
                "§7/emotes help : §blist a command\n".
                "§7/emotes version : §bdescription a plugin");
                return true;
                break;
            case "version":
            case "ver":
                $player->sendMessage("§a> EmoteSimple Description\n".
                "§fAuthor: §aIbenrm01\n".
                "§fVersion: §a1.2\n".
                "§fApi: §a[4.0.0]");
                return true;
            break;
        }
        return false;
    }

    /**
     * @param Player $player
     */
    public function createEmotes(Player $player){
        $list = [];
        foreach($this->plugin->getDataIds()->emotes as $index => $emotes){
            $list[] = $emotes["name"];
        }
        $this->youre[$player->getName()] = $list;
        $form = new CustomForm(function(Player $player, array $data = null){
            if($data === null){
                $player->sendMessage($this->plugin->getConfig()->get("exit.menu"));
                return;
            }
            if($data[2] == null){
                $player->sendMessage("§cSyntax error, input a name emotes!");
                return;
            }
            $emote_name = str_replace(" ", "_", $data[2]);
            if (!preg_match("/[^*`#%,.'~$@?]/",$emote_name)) {
                $player->sendMessage("§cSyntax error, dont use ( /^*`#%,.'~$@?/ )");
                return;
            }
            $player->sendMessage($this->plugin->getEmotes()->createEmotes(strtolower($emote_name), $this->plugin->getDataIds()->emotes[$data[1]]['uid']));
            return;
            
        });
        $form->setTitle($this->plugin->getConfig()->getAll()['forms.create']['title']);
        $form->addLabel($this->plugin->getConfig()->getAll()['forms.create']['content']);
        $form->addDropdown("§bList a Emotes:", $this->youre[$player->getName()]);
        $form->addInput("§aName a Emotes:", "input a name");
        $form->sendToPlayer($player);
    }

    /**
     * @param Player $player
     * @param string $emoteName
     */
    public function removeEmotes(Player $player, string $emoteName){
        $player->sendMessage($this->plugin->getEmotes()->removeEmotes($emoteName));
    }
}