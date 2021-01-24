<?php

class Blocksy_WP_Block_Parser extends WP_Block_Parser {
	function parse($document) {
		$result = parent::parse($document);

		foreach ($result as $index => $first_level_block) {
			$result[$index]['firstLevelBlock'] = true;
		}

		return $result;
	}
}
