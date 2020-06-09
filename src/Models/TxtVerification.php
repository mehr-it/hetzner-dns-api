<?php


	namespace MehrIt\HetznerDnsApi\Models;


	class TxtVerification extends AbstractEntity
	{
		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {

			$model = new static();

			$model->name  = $data['name'] ?? null;
			$model->token = $data['token'] ?? null;

			return $model;
		}


		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var string
		 */
		protected $token;

		/**
		 * Sets the name
		 * @param string $name The name
		 * @return $this
		 */
		public function name(string $name): TxtVerification {
			$this->name = $name;

			return $this;
		}

		/**
		 * Sets the token
		 * @param string $token The token
		 * @return $this
		 */
		public function token(string $token): TxtVerification {
			$this->token = $token;

			return $this;
		}

		/**
		 * Gets the name
		 * @return string The name
		 */
		public function getName(): ?string {
			return $this->name;
		}

		/**
		 * Gets the token
		 * @return string The token
		 */
		public function getToken(): ?string {
			return $this->token;
		}



		/**
		 * @inheritDoc
		 */
		public function toArray(): array {

			return array_filter(
				[
					'name'  => $this->name,
					'token' => $this->token,
				],
				function ($v) {
					return $v !== null;
				}
			);
		}


	}