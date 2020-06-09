<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\ResponseZone;
	use Psr\Http\Message\ResponseInterface;

	class ZoneResponse extends AbstractResponse
	{
		/**
		 * @inheritDoc
		 */
		public static function create(ResponseInterface $response) {

			// parse body
			$body = $response->getBody()->getContents();
			$data = static::parseJson($body);

			if (!is_array($data['zone'] ?? null))
				throw new InvalidResponseException('Response does not contain zone data', $body);


			$model = new static();

			$model->zone = ResponseZone::fromArray($data['zone']);

			return $model;
		}


		/**
		 * @var ResponseZone
		 */
		protected $zone;

		/**
		 * Gets the zone
		 * @return ResponseZone The zone
		 */
		public function getZone(): ResponseZone {
			return $this->zone;
		}

	}