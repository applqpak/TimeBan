<?php

  namespace applqpak\TimeBan\event;
  
  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerPreLoginEvent;
  use pocketmine\Player;
  
  use applqpak\TimeBan\Main;
  
  class EventListener implements Listener
  {
      private $plugin;
      public function __construct(Main $plugin)
      {
          $this->plugin = $plugin;
      }
      
      public function onPreLogin(PlayerPreLoginEvent $event)
      {
          $player = $event->getPlayer();
          if($this->plugin->cfg->get($player->getClientId()) !== null)
          {
              if(($this->plugin->cfg->getNested($player->getClientId() . '.time') - time()) <= 0)
              {
                  $players = $this->cfg->getAll();
                  unset($players[$player->getClientId()]);
                  $this->plugin->cfg->save();
              }
          }
          else
          {
              $player->close('', 'You are banned.');
              $event->setCancelled();
          }
      }
  }
