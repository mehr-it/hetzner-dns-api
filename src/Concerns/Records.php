<?php


	namespace MehrIt\HetznerDnsApi\Concerns;


	use InvalidArgumentException;
	use MehrIt\HetznerDnsApi\Exceptions\ValidationException;
	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrIt\HetznerDnsApi\Models\Response\RecordResponse;
	use MehrIt\HetznerDnsApi\Models\Response\RecordsBulkCreateResponse;
	use MehrIt\HetznerDnsApi\Models\Response\RecordsBulkUpdateResponse;
	use MehrIt\HetznerDnsApi\Models\Response\RecordsPaginatedResponse;

	trait Records
	{
		/**
		 * Returns information about a single record
		 * @param string $recordId The record id
		 * @return RecordResponse The response
		 */
		public function getRecord(string $recordId): RecordResponse {

			return RecordResponse::create(
				$this->request('GET', 'records/' . urlencode($recordId))
			);
		}

		/**
		 * Updates a record
		 * @param string $recordId The record id
		 * @param Record $record The record
		 * @return RecordResponse The response
		 */
		public function updateRecord(string $recordId, Record $record): RecordResponse {

			$this->validateRecord($record);

			return RecordResponse::create(
				$this->request('PUT', 'records/' . urlencode($recordId), [
					'json' => $record,
				])
			);
		}

		/**
		 * Deletes a record
		 * @param string $recordId The record id
		 */
		public function deleteRecord(string $recordId): void {
			$this->request('DELETE', 'records/' . urlencode($recordId));
		}

		/**
		 * Creates a new record
		 * @param Record $record The record
		 * @return RecordResponse The response
		 */
		public function createRecord(Record $record): RecordResponse {

			$this->validateRecord($record);

			return RecordResponse::create(
				$this->request('POST', 'records', [
					'json' => $record,
				])
			);
		}

		/**
		 * Returns all records associated with user.
		 * @param string|null $zoneId The zone id
		 * @param int|null $perPage The number of records per page. Returns all by default
		 * @param int $page The page number
		 * @return RecordsPaginatedResponse
		 */
		public function getAllRecords(string $zoneId = null, int $perPage = null, int $page = 1): RecordsPaginatedResponse {

			if ($perPage !== null && $perPage < 1)
				throw new InvalidArgumentException('PerPage must be greater than 0');
			if ($page < 1)
				throw new InvalidArgumentException('Page must be greater than 0');

			$query = [];

			if ($zoneId)
				$query['zone_id'] = $zoneId;
			if ($page >= 1)
				$query['page'] = $page;
			if($perPage)
				$query['per_page'] = $perPage;

			return RecordsPaginatedResponse::create(
				$this->request('GET', 'records', [
					'query' => $query
				])
			);
		}

		/**
		 * Creates several records at once
		 * @param Record[] $records The records
		 * @return RecordsBulkCreateResponse
		 */
		public function bulkCreateRecords(array $records): RecordsBulkCreateResponse {

			foreach($records as $curr) {
				$this->validateRecord($curr);
			}


			return RecordsBulkCreateResponse::create(

				$this->request('POST', 'records/bulk', [
					'json' => [
						'records' => $records,
					]
				])
			);
		}

		/**
		 * Update several records at once.
		 * @param Record[] $records
		 * @return RecordsBulkUpdateResponse
		 */
		public function bulkUpdateRecords(array $records) {

			foreach ($records as $curr) {
				$this->validateRecord($curr);
			}

			return RecordsBulkUpdateResponse::create(

				$this->request('PUT', 'records/bulk', [
					'json' => [
						'records' => $records,
					]
				])
			);
		}


		/**
		 * Validates the given record
		 * @param Record $record The record
		 * @throws ValidationException
		 */
		protected function validateRecord(Record $record): void {

			if (trim($record->getName()) === '')
				throw new ValidationException('Record name must not be empty');
			if (trim($record->getTtl()) === '')
				throw new ValidationException('Record ttl must not be empty');
			if (trim($record->getType()) === '')
				throw new ValidationException('Record type must not be empty');
			if (trim($record->getValue()) === '')
				throw new ValidationException('Record value must not be empty');
			if (trim($record->getZoneId()) === '')
				throw new ValidationException('Record zoneId must not be empty');
		}

	}