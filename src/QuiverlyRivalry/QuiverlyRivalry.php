<?php
namespace QuiverlyRivalry;

# Main uses:
use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
#Utils uses:
use pocketmine\utils\{TextFormat};
#Item uses:
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
#Event uses:
use pocketmine\event\Listener;
#Command uses:
use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};
#Entity
use pocketmine\entity\{Entity, Effect};
#Player uses:
use pocketmine\event\player\{PlayerMoveEvent, PlayerJoinEvent, PlayerQuitEvent, PlayerExhaustEvent, PlayerInteractEvent, PlayerDropItemEvent};
# Inventory uses:
use pocketmine\inventory\Inventory;
#API uses:
use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;

class QuiverlyRivalry extends PluginBase implements Listener{

    public $nomoney = TextFormat::RED . "you do not have enough money!";

    public function onEnable(){
        $this->getLogger()->info("ShopUI by Quiverly! Remember I am a developer for hire!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        foreach(['FormAPI', 'EconomyAPI'] as $plugin){
            if($this->getServer()->getPluginManager()->getPlugin($plugin) == null){
                $this->setEnabled(false);
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        $player = $sender->getPlayer();
        switch ($cmd->getName()){
            case "shopui":
                $this->mainForm($player);
                break;
        }
        return true;
    }

    public function mainForm($player){
        $plugin = $this->getServer()->getPluginManager();
        $formapi = $plugin->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $event, array $args){
            $result = $args[0];
            $player = $event->getPlayer();
            if($result === null){
            }
            switch($result){
                case 0:
                    return;
                case 1:
                    $this->weaponsForm($player);
                    return;
                case 2:
                    $this->toolsForm($player);
                    return;
                case 3:
                    $this->armorsForm($player);
                    return;
                case 4:
                    $this->blocksForm($player);
                    return;
                case 5:
                    $this->specialitemsForm($player);
                    return;
                case 6:
                    $this->maskForm($player);
                    return;
            }
        });

        $form->setTitle(TextFormat::WHITE . "--= " . TextFormat::BOLD . TextFormat::GREEN . "CastleRaid" . TextFormat::RESET . TextFormat::WHITE . " =--");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton(TextFormat::GREEN."Exit");
        $form->addButton(TextFormat::WHITE."Weapons");
        $form->addButton(TextFormat::WHITE."Tools");
        $form->addButton(TextFormat::WHITE."Armour");
        $form->addButton(TextFormat::WHITE."Blocks");
        $form->addButton(TextFormat::WHITE."Special Items");
        $form->addButton(TextFormat::WHITE."Masks");
        $form->sendToPlayer($player);
    }

    public function weaponsForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $event, array $data){
            $result = $data[0];
            $player = $event->getPlayer();
            if($result === null){
            }
            switch($result){
                case 0:
                    $this->mainForm($player);
                    break;
                case 1:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 2500) {
                        $this->itemId = 268;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 2500);
                        $player->sendMessage("You bought a Wood Sword");
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 2:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 5000) {
                        $this->itemId = 272;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 5000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 3:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 267;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 4:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 283;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 5:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 276;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 6:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 2000) {
                        $this->itemId = 261;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 2000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 7:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 3000) {
                        $this->itemId = 262;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 3000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
            }
        });

        $form->setTitle("Weapons");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton("Back, to main menu!");
        $form->addButton("Wooden Sword: $2500", 0, "textures/items/wood_sword");
        $form->addButton("Stone Sword : $5000", 0, "textures/items/stone_sword");
        $form->addButton("Golden Sword : $10000", 0, "textures/items/gold_sword");
        $form->addButton("Iron Sword : $15000", 0, "textures/items/iron_sword");
        $form->addButton("Diamond Sword : $25000", 0, "textures/items/diamond_sword");
        $form->addButton("Bow : $2000", 0, "textures/items/bow_standby");
        $form->addButton("Arrows(64x) : $3000", 0, "textures/items/arrow");
        $form->sendToPlayer($player);
    }

    public function toolsForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $event, array $data){
            $result = $data[0];
            $player = $event->getPlayer();
            if($result === null){
            }
            switch($result){
                case 0:
                    $this->mainForm($player);
                    break;
                case 1:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 278;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 2:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 285;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 3:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 20000) {
                        $this->itemId = 257;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 20000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 4:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 5000) {
                        $this->itemId = 274;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 5000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 5:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 2500) {
                        $this->itemId = 270;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 2500);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
            }
        });

        $form->setTitle("Tools");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton("Back, to main menu!");
        $form->addButton("Diamond Pickaxe : $25000", 0, "textures/items/diamond_pickaxe");
        $form->addButton("Gold Pickaxe : $15000", 0, "textures/items/gold_pickaxe");
        $form->addButton("Iron Pickaxe : $10000", 0, "textures/items/iron_pickaxe");
        $form->addButton("Stone Pickaxe : $5000", 0, "textures/items/stone_pickaxe");
        $form->addButton("Wood Pickaxe : $2500", 0, "textures/items/wood_pickaxe");
        $form->sendToPlayer($player);
    }

    public function armorsForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $event, array $data){
            $result = $data[0];
            $player = $event->getPlayer();
            if($result === null){
            }
            switch($result){
                case 0:
                    $this->mainForm($player);
                    break;
                case 1:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 310;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 2:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 311;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 3:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 312;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 4:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 313;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 5:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 302;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 6:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 303;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 7:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 304;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 8:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 305;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 9:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 17000) {
                        $this->itemId = 306;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 17000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 10:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 17000) {
                        $this->itemId = 307;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 17000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 11:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 17000) {
                        $this->itemId = 308;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 17000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 12:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 17000) {
                        $this->itemId = 309;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 17000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 13:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 12000) {
                        $this->itemId = 314;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 12000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 14:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 12000) {
                        $this->itemId = 315;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 12000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 15:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 12000) {
                        $this->itemId = 317;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 12000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 16:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 12000) {
                        $this->itemId = 317;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 12000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 17:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 298;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 18:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 299;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 19:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 300;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 20:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 301;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
            }
        });

        $form->setTitle("Armour");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton("Back, to main menu!");
        //DIAMOND
        $form->addButton("Diamond Helmet : $25000", 0, "textures/items/diamond_helmet");
        $form->addButton("Diamond Chestplate : $25000", 0, "textures/items/diamond_chestplate");
        $form->addButton("Diamond Leggings : $25000", 0, "textures/items/diamond_leggings");
        $form->addButton("Diamond Boots : $25000", 0, "textures/items/diamond_boots");
        //chainmail
        $form->addButton("Chainmail Helmet : $15000", 0, "textures/items/chainmail_helmet");
        $form->addButton("Chainmail Chestplate : $15000", 0, "textures/items/chainmail_chestplate");
        $form->addButton("Chainmail Leggings : $15000", 0, "textures/items/chainmail_leggings");
        $form->addButton("Chainmail Boots : $15000", 0, "textures/items/chainmail_boots");
        //IRON
        $form->addButton("Iron Helmet : $17000", 0, "textures/items/iron_helmet");
        $form->addButton("Iron Chestplate : $17000", 0, "textures/items/iron_chestplate");
        $form->addButton("Iron Leggings : $17000", 0, "textures/items/iron_leggings");
        $form->addButton("Iron Boots : $17000", 0, "textures/items/iron_boots");
        //GOLD
        $form->addButton("Gold Helmet : $12000", 0, "textures/items/gold_helmet");
        $form->addButton("Gold Chestplate : $12000", 0, "textures/items/gold_chestplate");
        $form->addButton("gold Leggings : $12000", 0, "textures/items/gold_leggings");
        $form->addButton("gold Boots : $12000", 0, "textures/items/gold_boots");
        //LEATHER
        $form->addButton("Leather Helmet : $10000", 0, "textures/items/leather_helmet");
        $form->addButton("Leather Chestplate : $10000", 0, "textures/items/leather_chestplate");
        $form->addButton("Leather Leggings : $10000", 0, "textures/items/leather_leggings");
        $form->addButton("Leather Boots : $10000", 0, "textures/items/leather_boots");
        $form->sendToPlayer($player);
    }

    public function specialitemsForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $event, array $data){
            $result = $data[0];
            $player = $event->getPlayer();
            if($result === null){
            }
            switch($result){
                case 0:
                    $this->mainForm($player);
                    break;
                case 1:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 20000) {
                        $this->itemId = 466;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 20000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 13:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 15000) {
                        $this->itemId = 322;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 15000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 3:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 396;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
            }
        });

        $form->setTitle("Special Items");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton("Back, to main menu!");
        $form->addButton("Enchanted Gapples : $20000", 1, "https://www.digminecraft.com/food_recipes/images/golden_apple2.png");
        $form->addButton("Gapples : $150000", 1, "https://www.digminecraft.com/food_recipes/images/golden_apple.png");
        $form->addButton("Golden Carrot : $10000", 1, "https://www.digminecraft.com/food_recipes/images/golden_carrot.png");
        $form->sendToPlayer($player);
    }

    public function maskForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $event, array $data) {
            $result = $data[0];
            $player = $event->getPlayer();
            if ($result === null) {
            }
            switch ($result) {
                case 0:
                    $this->mainForm($player);
                    break;
                case 1:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 10000) {
                        $this->itemId = 397;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 10000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 2:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 5000) {
                        $this->itemId = 298;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                        EconomyAPI::getInstance()->reduceMoney($player, 5000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 3:
                    $this->itemId = 397;
                    $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                    EconomyAPI::getInstance()->reduceMoney($player, 2000);
                    break;
                case 4:
                    $this->itemId = 397;
                    $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                    EconomyAPI::getInstance()->reduceMoney($player, 1000);
                    break;
                case 5:
                    $this->itemId = 397;
                    $player->getInventory()->addItem(Item::get($this->itemId, 0, 1));
                    EconomyAPI::getInstance()->reduceMoney($player, 1000);
                    break;
            }
        });

        $form->setTitle("Masks");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton("Back, to main menu!");
        $form->addButton("Dragon : $10000", 1, "https://img4.hostingpics.net/pics/436796skulldragon.png");
        $form->addButton("Wither : $5000", 1, "https://img4.hostingpics.net/pics/826437skullwither.png");
        $form->addButton("Creeper : $2000", 1, "https://img4.hostingpics.net/pics/556676skullcreeper.png");
        $form->addButton("Zombie : $1000", 1, "https://img4.hostingpics.net/pics/415562skullzombie.png");
        $form->addButton("Skeleton : $1000", 1, "https://img4.hostingpics.net/pics/589367skullskeleton.png");
        $form->sendToPlayer($player);
    }

    public function blocksForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $event, array $data){
            $result = $data[0];
            $player = $event->getPlayer();
            if($result === null){
            }
            switch($result){
                case 0:
                    $this->mainForm($player);
                    break;
                case 1:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 1;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 2:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 17;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 3:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 20;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 4:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 24;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 5:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 45;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                    break;
                case 6:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 98;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 7:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 155;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 8:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 80;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 9:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 1;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
                case 10:
                    $money = EconomyAPI::getInstance()->myMoney($player->getName());
                    if ($money >= 25000) {
                        $this->itemId = 44;
                        $player->getInventory()->addItem(Item::get($this->itemId, 0, 64));
                        EconomyAPI::getInstance()->reduceMoney($player, 25000);
                    }else{
                        $player->sendMessage("You Don't Have Enough Money.");
                    }
                    break;
            }
        });

        $form->setTitle("Blocks");
        $name = $player->getName();
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $money = $eco->myMoney($name);
        $form->setContent("Your Money: " . $money);
        $form->addButton("Back, to main Menu!");
        $form->addButton("Stone : $25000", 1, "textures/items/stone");
        $form->addButton("Oak Logs : $25000", 1, "textures/items/log");
        $form->addButton("Glass : $25000", 1, "textures/items/glass");
        $form->addButton("Sandstone : $25000", 1, "textures/items/sandstone");
        $form->addButton("Stone Bricks : $25000", 1, "textures/items/bricks");
        $form->addButton("Quartz : $25000", 1, "textures/items/quartz_block");
        $form->addButton("Snow : $25000", 1, "textures/items/snow");
        $form->addButton("Stone Slab : $25000", 1, "textures/items/stone_slab");
        $form->addButton("Shelf : $25000", 1, "textures/items/bookshelf");
        $form->sendToPlayer($player);
    }
}
