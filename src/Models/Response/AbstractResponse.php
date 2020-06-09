<?php


	namespace MehrIt\HetznerDnsApi\Models\Response;


	use InvalidArgumentException;
	use MehrIt\HetznerDnsApi\Exceptions\InvalidResponseException;
	use Psr\Http\Message\ResponseInterface;

	abstract class AbstractResponse
	{
		/**
		 * Creates a new instance
		 * @param ResponseInterface $response The HTTP response
		 * @return static`
		 */
		public static abstract function create(ResponseInterface $response);

		/**
		 * Parses the given JSON string
		 * @param string $string The JSON string
		 * @return mixed The parsed data
		 */
		protected static function parseJson(string $string) {

			$data = json_decode($string, true);

			if (JSON_ERROR_NONE !== json_last_error())
				throw new InvalidResponseException('Could not decode response JSON: ' . json_last_error_msg(), $string);

			return $data;
		}


		protected function __construct() {
			//
		}


	}