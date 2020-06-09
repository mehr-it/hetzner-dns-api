<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrIt\HetznerDnsApi\Models\ResponseRecord;
	use Psr\Http\Message\ResponseInterface;

	class RecordsBulkUpdateResponse extends AbstractResponse
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
			if (!is_array($data['failed_records'] ?? null))
				throw new InvalidResponseException('Response does not contain failed_records data', $body);


			$model = new static();

			$model->records = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return ResponseRecord::fromArray($item);

			}, $data['records']);

			$model->failedRecords = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return Record::fromArray($item);

			}, $data['failed_records']);


			return $model;
		}

		/**
		 * @var ResponseRecord[]
		 */
		protected $records = [];

		/**
		 * @var Record[]
		 */
		protected $failedRecords = [];


		/**
		 * Gets the records
		 * @return ResponseRecord[] The records
		 */
		public function getRecords(): array {
			return $this->records;
		}

		/**
		 * Gets the failed records from the request
		 * @return Record[] The failed records the from request
		 */
		public function getFailedRecords(): array {
			return $this->failedRecords;
		}

	}