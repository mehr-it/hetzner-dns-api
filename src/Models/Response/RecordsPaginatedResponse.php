<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\Meta;
	use MehrIt\HetznerDnsApi\Models\ResponseRecord;
	use Psr\Http\Message\ResponseInterface;

	class RecordsPaginatedResponse extends AbstractResponse
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


			$model = new static();

			$model->records = array_map(function($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid record data', $body);

				return ResponseRecord::fromArray($item);

			}, $data['records']);

			$model->meta = Meta::fromArray((array)($data['meta'] ?? []));

			return $model;
		}

		/**
		 * @var ResponseRecord[]
		 */
		protected $records = [];

		/**
		 * @var Meta
		 */
		protected $meta;

		/**
		 * Gets the records
		 * @return ResponseRecord[] The records
		 */
		public function getRecords(): array {
			return $this->records;
		}

		/**
		 * Gets the meta data
		 * @return Meta The meta data
		 */
		public function getMeta(): Meta {
			return $this->meta;
		}


	}