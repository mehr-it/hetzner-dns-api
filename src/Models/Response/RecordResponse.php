<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\ResponseRecord;
	use Psr\Http\Message\ResponseInterface;

	class RecordResponse extends AbstractResponse
	{
		/**
		 * @inheritDoc
		 */
		public static function create(ResponseInterface $response) {

			// parse body
			$body = $response->getBody()->getContents();
			$data = static::parseJson($body);

			if (!is_array($data['record'] ?? null))
				throw new InvalidResponseException('Response does not contain record data', $body);


			$model = new static();

			$model->record = ResponseRecord::fromArray($data['record']);

			return $model;
		}


		/**
		 * @var ResponseRecord
		 */
		protected $record;

		/**
		 * Gets the record
		 * @return ResponseRecord The record
		 */
		public function getRecord(): ResponseRecord {
			return $this->record;
		}

	}