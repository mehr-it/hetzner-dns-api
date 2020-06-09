<?php


	namespace MehrItHetznerDnsApiTest\Cases;


	use MehrIt\HetznerDnsApi\HetznerDnsClient;

	abstract class IntegrationTest extends TestCase
	{
		/**
		 * Gets the value of the given environment variable
		 * @param string $name The name
		 * @return string The variable name
		 */
		protected function getEnv(string $name) {

			$value = getenv($name);
			if (!$value)
				$this->markTestSkipped("The environment variable {$name} is required for this test");

			return $value;
		}

		/**
		 * Creates a client instance for integration tests
		 * @return HetznerDnsClient The DNS client instance
		 */
		protected function makeClient(): HetznerDnsClient {

			return new HetznerDnsClient($this->getEnv('API_TOKEN'));
		}
	}