<?php


	namespace MehrItHetznerDnsApiTest\Helpers;


	use MehrIt\HetznerDnsApi\Exceptions\HetznerDnsApiErrorException;
	use MehrIt\HetznerDnsApi\Models\Zone;

	trait ZoneHelper
	{
		/**
		 * Fetches the id of the given zone
		 * @param string $name The name
		 * @return string|null The zone id or null if not existing
		 */
		protected function fetchZoneId(string $name): ?string {
			try {
				$zones = $this->makeClient()->getZoneByName($name)->getZones();

				return $zones[0]->getId();
			}
			catch (HetznerDnsApiErrorException $ex) {
				if ($ex->getCode() == 404)
					return null;

				throw $ex;
			}
		}

		/**
		 * Deletes the given zone if exists
		 * @param string $name The name
		 */
		protected function deleteZoneIfExists(string $name) {

			$zoneId = $this->fetchZoneId($name);

			if ($zoneId)
				$this->makeClient()->deleteZone($zoneId);

		}

		/**
		 * Creates the given zone if not exists
		 * @param string $name The zone name
		 * @param int $ttl The TTL
		 * @return string The zone id
		 */
		protected function createZone(string $name, int $ttl = 86400): string {

			$this->deleteZoneIfExists($name);

			return $this->makeClient()
				->createZone(
					(new Zone())
						->name($name)
						->ttl($ttl)
				)
				->getZone()
				->getId();
		}
	}