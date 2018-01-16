<?php

namespace QuiverlyRivalry;

use pocketmine\command\{Command, CommandSender};
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class QuiverlyRivalry extends PluginBase
{
    private $economyapi;
    private $formapi;

    public $weapons = [];
    public $tools = [];
    public $armor = [];
    public $blocks = [];
    public $specials = [];
    public $masks = [];

    public $category;

    public function onEnable()
    {
        foreach (['FormAPI', 'EconomyAPI'] as $depend) {
            $plugin = $this->getServer()->getPluginManager()->getPlugin($depend);
            $name = strtolower($depend);
            if (is_null($plugin)) {
                $this->getLogger()->error($depend . " is required to use this plugin.");
                $this->setEnabled(false);
                return false;
            }
            $this->$name = $plugin;
        }
        $this->saveDefaultConfig();
        foreach (["weapons", "tools", "armor", "blocks", "specials", "masks"] as $category) {
            $this->$category = $this->getConfig()->getNested("items." . $category);
        }
        $this->getLogger()->info("ShopUI by Quiverly and a pig! Remember I am a developer for hire!");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
    {
        switch ($cmd->getName()) {
            case "shopui":
                if ($sender instanceof Player) {
                    $this->mainForm($sender);
                    return true;
                }
                $sender->sendMessage(TextFormat::RED . "Please use this in-game.");
                break;
        }
        return true;
    }

    public function mainForm(Player $player)
    {
        $form = $this->formapi->createSimpleForm(function (Player $player, array $data) {
            if (isset($data[0])) {
                $result = $data[0];
                $categories = [0 => "weapons", 1 => "tools", 2 => "armor", 3 => "blocks", 4 => "specials", 5 => "masks"];
                switch ($result) {
                    case 6:
                        return;
                    default:
                        $this->categoryForm($player, $categories[$result]);
                        $this->category[$player->getLowerCaseName()] = $categories[$result];
                        return;
                }
            }
        });

        $form->setTitle(TextFormat::WHITE . "--= " . TextFormat::BOLD . TextFormat::GREEN . $this->getConfig()->getNested("name") . TextFormat::RESET . TextFormat::WHITE . " =--");
        $money = $this->economyapi->myMoney($player->getName());
        $form->setContent("Your Money: $" . $money);
        $form->addButton(TextFormat::WHITE . "Weapons");
        $form->addButton(TextFormat::WHITE . "Tools");
        $form->addButton(TextFormat::WHITE . "Armour");
        $form->addButton(TextFormat::WHITE . "Blocks");
        $form->addButton(TextFormat::WHITE . "Special Items");
        $form->addButton(TextFormat::WHITE . "Masks");
        $form->addButton(TextFormat::GREEN . "Exit");
        $form->sendToPlayer($player);
    }

    public function categoryForm(Player $player, $category)
    {
        $form = $this->formapi->createSimpleForm(function (Player $player, array $data) {
            if (isset($data[0])) {
                $category = $this->category[$player->getLowerCaseName()];
                if ($data[0] < count($this->$category)) {
                    $item = $this->$category[$data[0]];
                    $values = explode(":", $item);
                    $money = $this->economyapi->myMoney($player->getName());
                    if ($money >= $values[4]) {
                        $player->getInventory()->addItem(Item::get($values[0], $values[1], $values[2])->setCustomName($values[3]));
                        $this->economyapi->reduceMoney($player, $values[4]);
                        $message = $this->getConfig()->getNested("messages.bought");
                        $tags = [
                            "{amount}" => $values[2],
                            "{item}" => $values[3],
                            "{cost}" => $values[4]
                        ];
                        foreach ($tags as $tag => $replacement){
                            $message = str_replace($tag, $replacement, $message);
                        }
                        $player->sendMessage($message);
                    } else {
                        $message = $this->getConfig()->getNested("messages.not-enough-money");
                        $tags = [
                            "{amount}" => $values[2],
                            "{item}" => $values[3],
                            "{missing}" => $values[4] - $money
                        ];
                        foreach ($tags as $tag => $replacement){
                            $message = str_replace($tag, $replacement, $message);
                        }
                        $player->sendMessage($message);                    }
                } else {
                    $this->mainForm($player);
                }
            }
        });
        $form->setTitle(ucfirst($category));
        $money = $this->economyapi->myMoney($player->getName());
        $form->setContent("Your Money: " . $money);
        foreach ($this->$category as $item) {
            $values = explode(":", $item);
            $form->addButton($values[3] . " : " . $values[4], isset($values[5]) ? $values[5] : -1, isset($values[6]) ? str_replace("https//", "https://", $values[6]) : "");
        }
        $form->addButton("Back, to main menu!");
        $form->sendToPlayer($player);
    }

}
