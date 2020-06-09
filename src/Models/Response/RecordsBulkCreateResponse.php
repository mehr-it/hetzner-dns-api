<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrIt\HetznerDnsApi\Models\ResponseRecord;
	use Psr\Http\Message\ResponseInterface;

	class RecordsBulkCreateResponse extends AbstractResponse
	{
		/**
		 * @inheritDoc
		 */
		public static function create(ResponseInterface $response) {

			// parse body
			$body = $response->getBody()->getContents();
			$data = static::parseJson($body);

			if (!is_array($data['records'] ?? null))
				throw new InvalidResponseException('Response does not contain records data', $body);
			if (!is_array($data['valid_records'] ?? null))
				throw new InvalidResponseException('Response does not contain valid_records data', $body);
			if (!is_array($data['invalid_records'] ?? null))
				throw new InvalidResponseException('Response does not contain invalid_records data', $body);


			$model = new static();

			$model->records = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return ResponseRecord::fromArray($item);

			}, $data['records'] ?? []);

			$model->validRecords = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return Record::fromArray($item);

			}, $data['valid_records'] ?? []);


			$model->invalidRecords = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return Record::fromArray($item);

			}, $data['invalidRecords'] ?? []);


			return $model;
		}

		/**
		 * @var ResponseRecord[]
		 */
		protected $records = [];

		/**
		 * @var Record[]
		 */
		protected $validRecords = [];

		/**
		 * @var Record[]
		 */
		protected $invalidRecords = [];

		/**
		 * Gets the records
		 * @return ResponseRecord[] The records
		 */
		public function getRecords(): array {
			return $this->records;
		}

		/**
		 * Gets the valid records from the request
		 * @return Record[] The valid records the from request
		 */
		public function getValidRecords(): array {
			return $this->validRecords;
		}

		/**
		 * Gets the invalid records from the request
		 * @return Record[] The invalid records the from request
		 */
		public function getInvalidRecords(): array {
			return $this->invalidRecords;
		}
	}