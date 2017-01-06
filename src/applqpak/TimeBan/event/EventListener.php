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
          if(isset($this->plugin->cfg->get($player->getClientId())))
          {
              if(($this->plugin->cfg->getNested($player->getClientId() . '.time') - time()) <= 0)
              {
                  unset($this->plugin->cfg->get($player->getClientId()));
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
