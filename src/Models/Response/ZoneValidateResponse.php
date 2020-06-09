<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrIt\HetznerDnsApi\Models\ResponseRecord;
	use Psr\Http\Message\ResponseInterface;

	class ZoneValidateResponse extends AbstractResponse
	{
		/**
		 * @inheritDoc
		 */
		public static function create(ResponseInterface $response) {

			// parse body
			$body = $response->getBody()->getContents();
			$data = static::parseJson($body);

			if (!is_array($data['valid_records'] ?? null))
				throw new InvalidResponseException('Response does not contain valid_records data', $body);
			if (($data['parsed_records'] ?? null) === null)
				throw new InvalidResponseException('Response does not contain parsed_records', $body);


			$model = new static();

			$model->validRecords = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return Record::fromArray($item);

			}, $data['valid_records']);

			$model->parsedRecords = (int)$data['parsed_records'];


			return $model;
		}

		/**
		 * @var Record[]
		 */
		protected $validRecords;

		/**
		 * @var int
		 */
		protected $parsedRecords;

		/**
		 * Gets the valid records
		 * @return Record[] The valid records
		 */
		public function getValidRecords(): array {
			return $this->validRecords;
		}

		/**
		 * Gets the parsed records count
		 * @return int The parsed records count
		 */
		public function getParsedRecords(): int {
			return $this->parsedRecords;
		}



	}