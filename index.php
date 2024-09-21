<?php

declare(strict_types=1);

final readonly class Formatter
{
    public function __construct(
        private int $divisor,
        private string $output,
    ) {
        if (0 === $this->divisor) {
            throw new InvalidArgumentException('Divisor cannot be zero.');
        }
    }

    public function format(int $number): string|null
    {
        return 0 === $number % $this->divisor ? $this->output : null;
    }
}

final class FormatterCollection implements IteratorAggregate
{
    /**
     * @param positive-int $currentNumber
     * @param non-empty-array<Formatter> $formatters
     */
    public function __construct(
        private int $currentNumber,
        private readonly array $formatters,
    ) {}

    public function getIterator(): Traversable
    {
        while ($this->currentNumber) {
            $output = null;

            foreach ($this->formatters as $formatter) {
                $output .= $formatter->format($this->currentNumber);
            }

            yield $output ?: $this->currentNumber;
            --$this->currentNumber;
        }
    }
}

function displaySequenceNumber(int $number): void
{
    $formatters = new FormatterCollection(
        $number,
        [
            new Formatter(3, 'Fizz'),
            new Formatter(5, 'Buzz'),
        ],
    );

    foreach ($formatters as $output) {
        echo $output . PHP_EOL;
    }
}

$number = $argv[1] ?? null;

if (null === $number) {
    echo "
        Missing arg 'number'\n
        Usage: make display-formatted-sequence number=[number]\n
        Example: make display-formatted-sequence number=25\n
    ";
    return;
}

displaySequenceNumber((int) $number);
