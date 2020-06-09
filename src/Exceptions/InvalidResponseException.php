<?php


	namespace MehrIt\HetznerDnsApi\Exceptions;


	use RuntimeException;
	use Throwable;

	class InvalidResponseException extends RuntimeException
	{

		protected $responseBody;

		/**
		 * @inheritDoc
		 */
		public function __construct($message = "", $responseBody = '', $code = 0, Throwable $previous = null) {

			$this->responseBody = $responseBody;

			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function getResponseBody() {
			return $this->responseBody;
		}



	}