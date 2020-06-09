<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use Psr\Http\Message\ResponseInterface;

	class ZoneExportResponse extends AbstractResponse
	{
		/**
		 * @inheritDoc
		 */
		public static function create(ResponseInterface $response) {

			$model = new static();

			$model->plainZoneFile = $response->getBody()->getContents();


			return $model;
		}


		/**
		 * @var string
		 */
		protected $plainZoneFile;


		/**
		 * Gets the plain zone file as string
		 * @return string The plain zone file as string
		 */
		public function getPlainZoneFile(): string {
			return $this->plainZoneFile;
		}

	}