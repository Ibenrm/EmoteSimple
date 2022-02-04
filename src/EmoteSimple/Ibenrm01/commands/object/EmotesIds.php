<?php

namespace EmoteSimple\Ibenrm01\commands\object;

use pocketmine\event\Listener;

use EmoteSimple\Ibenrm01\EmoteSimple;

class EmotesIds implements Listener{

    /** @var array[] $emotes */
    public $emotes = [
        ["name"=>"Over_There", "uid"=>"ce5c0300-7f03-455d-aaf1-352e4927b54d"],
        ["name"=>"Wave", "uid"=>"4c8ae710-df2e-47cd-814d-cc7bf21a3d67"],
        ["name"=>"Abduction?", "uid"=>"18891e6c-bb3d-47f6-bc15-265605d86525"],
        ["name"=>"Acting_Like_Dragon", "uid"=>"c2a47805-c792-4882-a56d-17c80b6c57a8"],
        ["name"=>"Ahh_Choo!", "uid"=>"f9345ebb-4ba3-40e6-ad9b-6bfb10c92890"],
        ["name"=>"Ballerina_Twirl", "uid"=>"79452f7e-ffa0-470f-8283-f5063348471d"],
        ["name"=>"Big_Chuckles", "uid"=>"819f2f36-2a16-440c-8e46-94c6b003a2e0"],
        ["name"=>"Bored", "uid"=>"7a314ecf-f94c-42c0-945f-76903c923808"],
        ["name"=>"Bow", "uid"=>"ddfa6f0e-88ca-46de-b189-2bd5b18e96a0"],
        ["name"=>"Breakdance", "uid"=>"1dbaa006-0ec6-42c3-9440-a3bfa0c6fdbe"],
        ["name"=>"Calling_a_Dragon", "uid"=>"9f5d4732-0513-4a0a-8ea2-b6b8d7587e74"],
        ["name"=>"Cartwheel", "uid"=>"5cf9d5a3-6fa0-424e-8ae4-d1f877b836da"],
        ["name"=>"Chatting", "uid"=>"59d9e78c-f0bb-4f14-9e9b-7ab4f58ffbf5"],
        ["name"=>"Clicking_Heels", "uid"=>"495d686a-4cb3-4f0b-beb5-bebdcb95eed9"],
        ["name"=>"Cowpoke_Dancin", "uid"=>"f99ccd35-ebda-4122-b458-ff8c9f9a432f"],
        ["name"=>"DJing", "uid"=>"beb74219-e90c-46aa-8a4b-a1c175f6cab5"],
        ["name"=>"Dancing_Like_Toothless", "uid"=>"a12252fa-4ec8-42e0-a7d0-d44fbc90d753"],
        ["name"=>"Diamonds_To_You!", "uid"=>"86b34976-8f41-475b-a386-385080dc6e83"],
        ["name"=>"Disappointed", "uid"=>"a98ea25e-4e6a-477f-8fc2-9e8a18ab7004"],
        ["name"=>"Doing_the_Conga", "uid"=>"5e1ef7ed-efdf-44a9-8ace-6cca6275d80d"],
        ["name"=>"Exhausted", "uid"=>"2391b018-3b8a-4bb0-9596-8edfc502d302"],
        ["name"=>"Facepalm", "uid"=>"402efb2d-6607-47f2-b8e5-bc422bcd8304"],
        ["name"=>"Faceplant", "uid"=>"6d9f24c0-6246-4c92-8169-4648d1981cbb"],
        ["name"=>"Fake_Death", "uid"=>"efc2f0f5-af00-4d9e-a4b1-78f18d63be79"],
        ["name"=>"Feeling_Sick", "uid"=>"bb6f1764-2b0b-4a3a-adfd-3334627cdee4"],
        ["name"=>"Foot_Stomp!", "uid"=>"13334afa-bd66-4285-b3d9-d974046db479"],
        ["name"=>"Ghast_Dance", "uid"=>"5a5b2c0c-a924-4e13-a99b-4c12e3f02e1e"],
        ["name"=>"Giddy", "uid"=>"738497ce-539f-4e06-9a03-dc528506a468"],
        ["name"=>"Going_Hero", "uid"=>"f14d652f-18ed-42dc-831f-7f6a2eab1246"],
        ["name"=>"Hand_Stand", "uid"=>"5dd129f9-cfc3-4fc1-b464-c66a03061545"],
        ["name"=>"Kneeling", "uid"=>"24444aea-cb6e-451f-90fc-b74e57cc7c5d"]
    ];

    /**
     * EmotesIds constructor.
     * @param EmoteSimple $plugin
     */
    public function __construct(private EmoteSimple $plugin){
    }
}