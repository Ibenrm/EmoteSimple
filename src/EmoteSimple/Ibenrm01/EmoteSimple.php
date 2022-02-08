<?php

namespace EmoteSimple\Ibenrm01;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\permission\PermissionManager;

use EmoteSimple\Ibenrm01\EmotesAPI;
use EmoteSimple\Ibenrm01\commands\EmoteCommand;
use EmoteSimple\Ibenrm01\commands\object\EmotesIds;

class EmoteSimple extends PluginBase implements Listener {

    /** @var array[] $emoteAPI */
    public $emoteAPI = [];

    /** @var EmoteSimple $instance */
    private static $instance;

    /**
     * @return void
     */
    public function onEnable(): void{
        $this->getServer()->getCommandMap()->register("emotes", new EmoteCommand($this));
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->loadConfig();
        $this->loadEmote();
        self::$instance = $this;
    }

    public function onDisable(): void {
        file_put_contents($this->getDataFolder()."/database/emotes.yml", yaml_emit($this->emoteAPI));
    }

    /**
     * @return void
     */
    public function loadConfig(): void {
        if(!is_dir($this->getDataFolder())){
            @mkdir($this->getDataFolder());
        }
        if(!is_dir($this->getDataFolder() . "database")){
            @mkdir($this->getDataFolder() . "database");
        }
        $this->saveResource("config.yml");
        $this->saveResource("/database/emotes.yml");
    }

    /**
     * @return void
     */
    public function loadEmote(): void {
        if(!file_exists($this->getDataFolder()."/database/emotes.yml")){
            new Config($this->getDataFolder()."/database/emotes.yml", Config::YAML);
            $this->emoteAPI = yaml_parse(file_get_contents($this->getDataFolder()."/database/emotes.yml"));
        } else {
            $this->emoteAPI = yaml_parse(file_get_contents($this->getDataFolder()."/database/emotes.yml"));
        }
    }

    /**
     * @return EmoteSimple
     */
    public static function getInstance(): EmoteSimple{
        return self::$instance;
    }


    /**
     * @return EmotesAPI
     */
    public function getEmotes(): EmotesAPI{
        return new EmotesAPI($this);
    }
    
    public function getDataIds(): EmotesIds {
    	return new EmotesIds();
    }

    /**
     * @param string $message
     * @param array $keys
     * 
     * @return string
     */
    public function replace(string $message, array $keys): string{
        foreach($keys as $word => $value){
            $message = str_replace("{".strtolower($word)."}", $value, $message);
        }
        return $message;
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $params = explode(" ", $event->getMessage());
        switch($params[0]){
            case "!emotes":
                $event->cancel();
                if(!isset($params[1])){
                    $player->sendMessage("§a> Emotes Commands (1/1)\n".
                    "§7list : §bList a available emotes\n".
                    "§7emote_name : §bActivated emotes");
                    break;
                }
                if($params[1] == "list"){
                    $player->sendMessage("§7===== §l§eLIST EMOTES §r§7=====\n");
                    foreach($this->emoteAPI as $index => $list) :
                        $player->sendMessage("§7- §b{$list['name']}\n");
                    endforeach;
                    $player->sendMessage("§7===============================");
                    break;
                }
                if($this->getEmotes()->searchEmote($params[1])){
                    $emoteId = $this->getEmotes()->getIds($this->getEmotes()->getIndex($params[1]));
                    $permission = $this->getEmotes()->getPermission($this->getEmotes()->getIndex($params[1]));
                    if(!PermissionManager::getInstance()->getPermission($permission)){
                        if(!$this->getServer()->isOp($player->getName())){
                            $player->sendMessage("§cYou don't have permission to use this emote.");
                            break;
                        }
                    }
                    if($this->getEmotes()->setEmotes($player, $emoteId)){
                        $player->sendMessage($this->replace($this->getConfig()->get("use.emotes"), [
                            "emote_name"=>$params[1]
                        ]));
                    } else {
                        $player->sendMessage("§cEmotes §d{$params[1]} §cnot found.");
                    }
                }
                break;
        }
    }
}