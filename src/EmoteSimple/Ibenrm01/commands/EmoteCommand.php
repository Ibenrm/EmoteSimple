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
        parent::__construct("emotes", "Emotes Commands", "/emotes [help]", ['emotesimple']);
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
                if(!$player instanceof Player){
                    $player->sendMessage("§cUse this command in-game.");
                    return false;
                }
                if(!$this->plugin->getServer()->isOp($player->getName())){
                    $player->sendMessage("§cYou don't have permission!");
                    return false;
                }
                $this->createEmotes($player);
                break;
            case "remove":
                if(!isset($args[1])){
                    $player->sendMessage("§cUsage: /emotes remove <string: emoteName>");
                    return false;
                }
                if(!$player instanceof Player){
                    $player->sendMessage("§cUse this command in-game.");
                    return false;
                }
                if(!$this->plugin->getServer()->isOp($player->getName())){
                    $player->sendMessage("§cYou don't have permission!");
                    return false;
                }
                if($this->plugin->getEmotes()->searchEmote($args[1])){
                    $this->removeEmotes($player, $args[1]);
                    return true;
                }
                $player->sendMessage("§cEmotes §d{$args[1]} §cnot found!");
                break;
            case "help":
                $player->sendMessage("§a> EmoteSimple Command (1/1)\n".
                "§7/emotes create : §badd emotes use UI\n".
                "§7/emotes remove <string: emoteName> : §bremove emotes by name\n".
                "§7/emotes help : §blist a command\n".
                "§7/emotes version : §bdescription a plugin");
                break;
            case "version":
            case "ver":
                $player->sendMessage("§a> EmoteSimple Version:\n".
                "§7Name: §b{$this->plugin->getDescription()->getName()}\n".
                "§7Author: §b[{$this->getAuthor()}]\n".
                "§7Api: §b[{$this->getApi()}]\n".
                "§7Version: §b{$this->plugin->getDescription()->getVersion()}");
            break;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getAuthor(): string {
        return implode(", ", $this->plugin->getDescription()->getAuthors());
    }

    /**
     * @return string
     */
    public function getApi(): string {
        return implode(", ", $this->plugin->getDescription()->getCompatibleApis());
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
            if($data[3] == null){
                $player->sendMessage("§cSyntax error, input a permissions!");
                return;
            }
            $emote_name = str_replace(" ", "_", $data[2]);
            if (!preg_match("/[^*`#%,.'~$@?]/",$emote_name)) {
                $player->sendMessage("§cSyntax error, dont use ( /^*`#%,.'~$@?/ )");
                return;
            }
            $permission = str_replace(" ", ".", $data[3]);
            if (!preg_match("/[^*`#%,-_'~$@?]/",$permission)) {
                $player->sendMessage("§cSyntax error, dont use ( /^*`#%,-_'~$@?/ )");
                return;
            }
            $player->sendMessage($this->plugin->getEmotes()->createEmotes(strtolower($emote_name), $this->plugin->getDataIds()->emotes[$data[1]]['uid'], strtolower($permission)));
            return;
            
        });
        $form->setTitle($this->plugin->getConfig()->getAll()['forms.create']['title']);
        $form->addLabel($this->plugin->getConfig()->getAll()['forms.create']['content']);
        $form->addDropdown("§bList a Emotes:", $this->youre[$player->getName()]);
        $form->addInput("§aName a Emotes:", "input a name");
        $form->addInput("§aSets permissions:", "input a permission");
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