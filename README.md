# EmoteSimple
**EmoteSimple is a Feature or API for
PocketMine-MP 4.0+**

## Support
**You can use minecraft bedrock profile built-in emote.**

**You can custom permission.**

## Warning!!!
**NOTE:** you can't see your own emote,
The emotes available in this plugin are limited, not all,
The EmoteSimple not supported multi permissions.

## Commands & API
- Created Emotes

  For commands you can use:
  `/emotes create`
  For api you can use:
```php
$player->sendMessage(EmoteSimple::getInstance()->getEmotes()->createEmotes(strtolower($emoteName), EmoteSimple::getInstance()->getDataIds()->emotes[0]['uid']), strtolower($permission));
```

- Remove Emotes
   
  For commands you can use:
  `/emotes remove <string: emoteName>`

  For api you can use:
```php
$player->sendMessage(EmoteSimple::getInstance()->getEmotes()->removeEmotes($emoteName));
```

- Play Emotes

  For commands you can use:
  `!emotes <string: emoteName>`

  For api you can use:
```php
if(EmoteSimple::getInstance()->getEmotes()->searchEmote($emoteName)){
    $emoteId = EmoteSimple::getInstance()->getEmotes()->getIds(EmoteSimple::getInstance()->getEmotes()->getIndex($emoteName));
    $permission = EmoteSimple::getInstance()->getEmotes()->getPermission(EmoteSimple::getInstance()->getEmotes()->getIndex($emoteName));
    if(!PermissionManager::getInstance()->getPermission($permission)){
        if(!$this->getServer()->isOp($player->getName())){
            // Code not have permissions
        }
    }
    if(EmoteSimple::getInstance()->getEmotes()->setEmotes($player, $emoteId)){
        //Code success
    } else {
        //Code failed
    }
}
```
