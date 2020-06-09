<?php


	namespace MehrItHetznerDnsApiTest\Asserts\Constraints;


    use PHPUnit\Framework\Constraint\Constraint;
    use PHPUnit\Framework\ExpectationFailedException;
    use SebastianBergmann\Comparator\ComparisonFailure;
    use SebastianBergmann\Comparator\Factory as ComparatorFactory;

    class ArrayHasKeysAndValuesAssoc extends Constraint
    {
        private $array;


        public function __construct($array) {
        	parent::__construct();

        	$this->array = $array;

            ksort($this->array);
        }





	    	    /**
         * @inheritdoc
         */
        public function evaluate($other, $description = '', $returnResult = false) {
            // If $this->value and $other are identical, they are also equal.
            if ($this->array === $other) {
                return true;
            }

            ksort($other);

            $comparatorFactory = ComparatorFactory::getInstance();

            try {
                $comparator = $comparatorFactory->getComparatorFor(
                    $this->array,
	                $other
                );

                $comparator->assertEquals(
                    $this->array,
	                $other
                );
            }
            catch (ComparisonFailure $f) {
                if ($returnResult) {
                    return false;
                }

                $f = new ComparisonFailure($this->array, $other, $this->exporter->export($this->array), $this->exporter->export($other), false, $f->getMessage());

                throw new ExpectationFailedException(
                    \trim($description . "\n" . 'Failed asserting that assoc array has specified keys and values.'),
                    $f
                );
            }

            return true;
        }

        /**
         * @inheritdoc
         */
        public function toString(): string {

            return \sprintf(
                'array has keys and values %s',
                $this->exporter->export($this->array)
            );
        }

    }
