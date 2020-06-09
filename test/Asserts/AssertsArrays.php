<?php


	namespace MehrItHetznerDnsApiTest\Asserts;



    use MehrItHetznerDnsApiTest\Asserts\Constraints\ArrayHasKeysAndValuesAssoc;

    trait AssertsArrays
	{
        /**
         * @param array $array
         * @return ArrayHasKeysAndValuesAssoc
         */
        public static function arrayHasKeysAndValuesAssoc(array $array) {
            return new ArrayHasKeysAndValuesAssoc($array);
        }

        /**
         * Assert that array contains keys and values
         * @param array $expected
         * @param array $actual
         * @param string $message
         */
        public static function assertArrayHasKeysAndValuesAssoc($expected, $actual, $message = '') {

            self::assertThat($actual, static::arrayHasKeysAndValuesAssoc($expected), $message);
        }
    }
