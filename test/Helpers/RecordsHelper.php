<?php


	namespace MehrItHetznerDnsApiTest\Helpers;


	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrIt\HetznerDnsApi\Models\Response\RecordsPaginatedResponse;

	trait RecordsHelper
	{

		/**
		 * Fetches the record id
		 * @param string $zoneId The zone id
		 * @param string $name The record name
		 * @param string $type The type
		 * @return string|null The record id. Null if not exists
		 */
		protected function fetchRecordId(string $zoneId, string $name = '@', string $type = Record::TYPE_A) {

			/** @var RecordsPaginatedResponse $response */
			$response = $this->makeClient()->getAllRecords($zoneId);

			foreach($response->getRecords() as $currRecord) {
				if ($currRecord->getName() == $name && $currRecord->getType() == $type)
					return $currRecord->getId();
			}

			return null;
		}

		/**
		 * Deletes the given record if it exists
		 * @param string $zoneId The zone id
		 * @param string $name The record name
		 * @param string $type The type
		 */
		protected function deleteRecordIfExists(string $zoneId, string $name = '@', string $type = Record::TYPE_A) {

			$recordId = $this->fetchRecordId($zoneId, $name, $type);

			if ($recordId)
				$this->makeClient()->deleteRecord($recordId);

		}

		/**
		 * Creates the given record
		 * @param string $zoneId The zone id
		 * @param string $value The value
		 * @param string $name The name
		 * @param string $type The type
		 * @param int $ttl The TTL
		 * @return string The record id
		 */
		protected function createRecord(string $zoneId, string $value, string $name = '@', string $type = Record::TYPE_A, int $ttl = 300) {

			$this->deleteRecordIfExists($zoneId, $name, $type);

			return $this->makeClient()->createRecord(
				(new Record())
					->zoneId($zoneId)
					->value($value)
					->name($name)
					->type($type)
					->ttl($ttl)
			)->getRecord()->getId();

		}

	}