<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use MehrIt\HetznerDnsApi\Models\Meta;
	use MehrIt\HetznerDnsApi\Models\ResponseZone;
	use Psr\Http\Message\ResponseInterface;

	class ZonesPaginatedResponse extends AbstractResponse
	{
		/**
		 * @inheritDoc
		 */
		public static function create(ResponseInterface $response) {

			// parse body
			$body = $response->getBody()->getContents();
			$data = static::parseJson($body);

			if (!is_array($data['zones'] ?? null))
				throw new InvalidResponseException('Response does not contain zones data', $body);


			$model = new static();

			$model->zones = array_map(function ($item) use (&$body) {

				if (!is_array($item))
					throw new InvalidResponseException('Response contains invalid zone data', $body);

				return ResponseZone::fromArray($item);

			}, $data['zones']);

			$model->meta = Meta::fromArray((array)($data['meta'] ?? []));

			return $model;
		}


		/**
		 * @var ResponseZone[]
		 */
		protected $zones;

		/**
		 * @var Meta
		 */
		protected $meta;

		/**
		 * Gets the zones
		 * @return ResponseZone[] The zones
		 */
		public function getZones(): array {
			return $this->zones;
		}

		/**
		 * Gets the meta data
		 * @return Meta The meta data
		 */
		public function getMeta(): Meta {
			return $this->meta;
		}

	}
