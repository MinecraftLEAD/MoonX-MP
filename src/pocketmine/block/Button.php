<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataValidator;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\sound\RedstonePowerOffSound;
use pocketmine\world\sound\RedstonePowerOnSound;

abstract class Button extends Flowable{

	/** @var int */
	protected $facing = Facing::DOWN;
	/** @var bool */
	protected $powered = false;

	protected function writeStateToMeta() : int{
		return $this->facing | ($this->powered ? BlockLegacyMetadata::BUTTON_FLAG_POWERED : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		//TODO: in PC it's (6 - facing) for every meta except 0 (down)
		$this->facing = BlockDataValidator::readFacing($stateMeta & 0x07);
		$this->powered = ($stateMeta & BlockLegacyMetadata::BUTTON_FLAG_POWERED) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		//TODO: check valid target block
		$this->facing = $face;
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	abstract protected function getActivationTime() : int;

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if(!$this->powered){
			$this->powered = true;
			$this->world->setBlock($this, $this);
			$this->world->scheduleDelayedBlockUpdate($this, $this->getActivationTime());
			$this->world->addSound($this->add(0.5, 0.5, 0.5), new RedstonePowerOnSound());
		}

		return true;
	}

	public function onScheduledUpdate() : void{
		if($this->powered){
			$this->powered = false;
			$this->world->setBlock($this, $this);
			$this->world->addSound($this->add(0.5, 0.5, 0.5), new RedstonePowerOffSound());
		}
	}
}
