<?php

  namespace applqpak\TimeBan;

  use pocketmine\plugin\PluginBase;
  use pocketmine\utils\Config;
  use pocketmine\utils\TextFormat;
  
  use applqpak\TimeBan\command\TimeBanCommand;
  use applqpak\TimeBan\event\EventListener;
  
  class Main extends PluginBase
  {
      public $usage = 'Usage: /timeban <ban | pardon | list> [username | time(in minutes) | reason] [username]';
      public function onLoad()
      {
          @mkdir($this->getDataFolder();
          $this->saveDefaultConfig();
      }
      
      public function getCfg()
      {
          return $this->getConfig()->getAll();
      }
      
      public function saveConfig()
      {
          $this->getConfig()->save();
      }
      
      public function onEnable()
      {
          $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
          $this->getServer()->getCommandMap()->register('timeban', new TimeBanCommand($this));
          $this->getLogger()->info(TextFormat::GREEN . 'Enabled.');
      }
      
      public function onDisable()
      {
          $this->getLogger()->info(TextFormat::RED . 'Disabled.');
      }
  }
