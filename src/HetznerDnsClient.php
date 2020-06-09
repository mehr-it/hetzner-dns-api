<?php


	namespace MehrIt\HetznerDnsApi;


	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\BadResponseException;
	use MehrIt\HetznerDnsApi\Concerns\Records;
	use MehrIt\HetznerDnsApi\Concerns\Zones;
	use MehrIt\HetznerDnsApi\Exceptions\HetznerDnsApiErrorException;
	use Psr\Http\Message\ResponseInterface;

	class HetznerDnsClient
	{

		use Records;
		use Zones;

		protected $baseUri = 'https://dns.hetzner.com/api/v1';

		protected $apiToken;



		/**
		 * @var Client
		 */
		protected $client;

		/**
		 * Creates a new instance
		 * @param string $apiToken The API token
		 * @param string|null $baseUri Overrides the default base URI if not empty
		 * @param Client|null $httpClient The HTTP client instance to use. If omitted one will be created automatically
		 */
		public function __construct(string $apiToken, string $baseUri = null, Client $httpClient = null) {

			$this->apiToken = $apiToken;
			$this->client   = $httpClient;

			if ($baseUri)
				$this->baseUri = $baseUri;
		}

		/**
		 * Sends a request to the API
		 * @param string $method The request method
		 * @param string $path The path
		 * @param array $options The request options
		 * @return ResponseInterface
		 * @throws \GuzzleHttp\Exception\GuzzleException
		 */
		protected function request(string $method, string $path, array $options = []): ResponseInterface {

			// add API token to headers
			$options['headers'] = array_merge(
				[
					'Auth-API-Token' => $this->apiToken,
				],
				$options['headers'] ?? []
			);

			// send request
			return $this->handleApiErrors(function() use ($method, $path, $options) {
				return $this->client()->request($method, "{$this->baseUri}/{$path}", $options);
			});
		}

		/**
		 * Executes the given callback with API error handling
		 * @param callable $callback The callback
		 * @return mixed The callback return
		 * @throws HetznerDnsApiErrorException
		 */
		protected function handleApiErrors(callable $callback) {
			try {
				return call_user_func($callback);
			}
			catch (BadResponseException $ex) {

				$errorMessage = null;

				// try to extract the error message
				$response = $ex->getResponse();
				if ($response) {
					$body = $response->getBody()->getContents();
					if ($body) {
						$bodyData = @json_decode($body, true);

						if (is_array($bodyData))
							$errorMessage = ($bodyData['error']['message'] ?? $bodyData['message'] ?? null);
					}
				}

				throw new HetznerDnsApiErrorException($errorMessage ? ('Hetzner DNS API returned error: ' . $errorMessage) : 'Hetzner DNS API returned an unspecified error', $ex->getCode(), $ex);
			}
		}

		/**
		 * Gets a HTTP client instance
		 * @return Client The HTTP client
		 */
		protected function client(): Client {

			if (!$this->client)
				$this->client = new Client();

			return $this->client;
		}



	}