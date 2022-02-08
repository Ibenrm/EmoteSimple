<?php

namespace EmoteSimple\Ibenrm01;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\event\Listener;
use pocketmine\utils\Config;

use pocketmine\event\player\PlayerEmoteEvent;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\{
    EmotePakcet, ProtocolInfo
};

use EmoteSimple\Ibenrm01\EmoteSimple;

class EmotesAPI implements Listener{

    /**
     * EmotesAPI contructor.
     * @param EmoteSimple $plugin
     */
    public function __construct(private EmoteSimple $plugin) {
    }

    /**
     * @param DataPacketReceiveEvent $event
     * 
     * @return void
     */
    public function onDataPacketReceived(DataPacketReceiveEvent $event) : void{
		$packet = $event->getPacket();
        $player = $event->getOrigin();
        if($packet instanceof EmotePacket){
            $emoteId = $packet->getEmoteId();
            foreach($player->getViewers() as $players){
                $players->getNetworkSession()->onEmote($player, $emoteId);
            }
        }
	}

    /**
     * @param string $emoteName
     * 
     * @return bool
     */
    public function searchEmote(string $emoteName): bool{
        $index = false;
        foreach ($this->plugin->emoteAPI as $key => $val) {
            if ($val["name"] == $emoteName) {
                $index = true;
                break;
            }
        }
        if($index !== false){
            return true;
        }
        return false;
    }

    /**
     * @param bool|string $emoteName
     */
    public function getIndex($emoteName = false){
        $index = false;
        if($emoteName == false){
            return false;
        }
        foreach($this->plugin->emoteAPI as $key => $emote){
            if($emote["name"] == $emoteName){
                $index = $key;
                break;
            }
        }
        if($index !== false){
            return $index;
        }
        return false;
    }

    /**
     * @param string $emoteName
     * @param string $uid
     * @param string $permission
     * 
     * @return string
     */
    public function createEmotes(string $emoteName, string $uid, string $permission): string{
        if(!$this->searchEmote($emoteName)){
            $this->plugin->emoteAPI[] = ["name" => $emoteName, "uid" => $uid, "permission" => $permission];
            return $this->plugin->replace($this->plugin->getConfig()->get("create.emote-success"), [
                "emote_name"=>$emoteName,
                "uid"=>$uid,
                "permission"=>$permission
            ]);
        }
        return $this->plugin->replace($this->plugin->getConfig()->get("create.emote-already"), [
            "emote_name"=>$emoteName,
            "uid"=>$uid,
            "permission"=>$permission
        ]);
    }

    /**
     * @param string $emoteName
     * 
     * @return string
     */
    public function removeEmotes(string $emoteName): string{
        if($this->searchEmote($emoteName)){
            array_splice($this->plugin->emoteAPI, $this->getIndex($emoteName), 1);
            return $this->plugin->replace($this->plugin->getConfig()->get("remove.emote-success"), [
                "emote_name"=>$emoteName
            ]);
        }
        return $this->plugin->replace($this->plugin->getConfig()->get("remove.emote-already"), [
            "emote_name"=>$emoteName
        ]);
    }

    /**
     * @param int $index
     * 
     * @return string
     */
    public function getIds(int $index): string{
        return $this->plugin->emoteAPI[$index]['uid'];
    }

    /**
     * @param int $index
     * 
     * @return string
     */
    public function getPermission(int $index): string{
        return $this->plugin->emoteAPI[$index]['permission'];
    }

    /**
     * @param Player $player
     * @param string $emoteId
     * 
     * @return bool
     */
    public function setEmotes(Player $player, string $emoteId): bool{
        foreach($player->getViewers() as $players){
            $players->getNetworkSession()->onEmote($player, $emoteId);
        }
        return true;
    }
}