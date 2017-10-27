<?php

namespace Eventival;

use Stiphle\Throttle\LeakyBucket;

class EmailQueue {

	const limits = [
		'single' => 5,
		'mass' => 100
	];

	const sleep_time = 1;

	public function __construct() {
		$this->throttler = new LeakyBucket;

		$this->counts = [];
	}

	public function nextEmail(string $identifier) {
		$msg = $this->getNextMail($identifier);
		
		if ( $msg ) {

			$limit = isset(self::limits[$identifier]) ? self::limits[$identifier] : 1;

			$this->throttler->throttle($identifier, $limit, 1000);

			return $msg;

		} else {
			sleep(self::sleep_time);
		}
	}

	private function getNextMail(string $identifier) {
		// transaction begin
		// do I have next email
		// read next email
		// update mail entry as being processed
		// beging
		if ( !isset($this->counts[$identifier]) ) {
				$this->counts[$identifier] = 0;
			}

		$this->counts[$identifier]++;


		return "{$identifier} mail message {$this->counts[$identifier]}\n";
	}
}

