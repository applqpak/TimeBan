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
          if(isset($this->plugin->getConfig()->getAll()[$player->getClientId()]))
          {
              if(($this->plugin->getConfig()->getAll()[$player->getClientId()]['time'] - time()) <= 0)
              {
                  unset($this->plugin->getConfig()->getAll()[$player->getClientId()]);
                  $this->plugin->getConfig()->save();
              }
          }
          else
          {
              $player->close('', 'You are banned.');
              $event->setCancelled();
          }
      }
  }
