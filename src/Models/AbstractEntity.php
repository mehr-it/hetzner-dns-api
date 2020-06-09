<?php /** @noinspection PhpDocMissingThrowsInspection */


	namespace MehrIt\HetznerDnsApi\Models;


	use DateTime;
	use DateTimeInterface;
	use DateTimeZone;
	use JsonSerializable;

	abstract class AbstractEntity implements JsonSerializable
	{
		/**
		 * Creates a new instance from given data array
		 * @param array $data The data
		 * @return static the new instance
		 */
		public static abstract function fromArray(array $data);

		/**
		 * Returns the record as array
		 * @return array The record data
		 */
		public abstract function toArray(): array;


		/**
		 * @inheritDoc
		 */
		public function jsonSerialize() {
			return $this->toArray();
		}


		/**
		 * Converts the given date to string
		 * @param DateTimeInterface $date The date
		 * @return string The date string
		 */
		protected static function dateToString(DateTimeInterface $date): string {

			// output date as UTC string
			return (new DateTime('@' . $date->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z');
		}

		/**
		 * Converts a string to date time
		 * @param string $date The date string
		 * @return DateTime The date time instance
		 */
		protected static function dateFromString(string $date): DateTime {
			return (new DateTime($date));
		}


	}