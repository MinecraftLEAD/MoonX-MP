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

namespace pocketmine\world\sound;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever enum members are added, removed or changed.
 * @see EnumTrait::_generateMethodAnnotations()
 *
 * @method static self PIANO()
 * @method static self BASS_DRUM()
 * @method static self SNARE()
 * @method static self CLICKS_AND_STICKS()
 * @method static self DOUBLE_BASS()
 */
class NoteInstrument{
	use EnumTrait {
		__construct as Enum___construct;
	}

	protected static function setup() : iterable{
		return [
			new self("piano", 0),
			new self("bass_drum", 1),
			new self("snare", 2),
			new self("clicks_and_sticks", 3),
			new self("double_bass", 4)
		];
	}

	/** @var int */
	private $magicNumber;

	public function __construct(string $name, int $magicNumber){
		$this->Enum___construct($name);
		$this->magicNumber = $magicNumber;
	}

	/**
	 * @return int
	 */
	public function getMagicNumber() : int{
		return $this->magicNumber;
	}
}
