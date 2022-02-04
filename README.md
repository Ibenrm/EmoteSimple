# EmoteSimple
**EmoteSimple is a Feature or API for
PocketMine-MP 4.0+**

## Permission
**This feature next update..**

## Support
**You can use minecraft bedrock profile built-in emote.**

## Warning!!!
**NOTE:** you can't see your own emote,
The emotes available in this plugin are limited, not all.

## Commands & API
- Created Emotes

  For commands you can use:
  `/emotes create`
  For api you can use:
```php
$player->sendMessage(EmoteSimple::getInstance()->getEmotes()->createEmotes(strtolower($emoteName), EmoteSimple::getInstance()->getDataIds()->emotes[0]['uid']));
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
    if(EmoteSimple::getInstance()->getEmotes()->setEmotes($player, $emoteId)){
        //Code success
    }
}
```
