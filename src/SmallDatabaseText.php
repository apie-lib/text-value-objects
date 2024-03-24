<?php
namespace Apie\TextValueObjects;

use Apie\Core\Attributes\FakeMethod;
use Apie\Core\Attributes\ProvideIndex;
use Apie\Core\ValueObjects\Interfaces\HasRegexValueObjectInterface;
use Apie\Core\ValueObjects\IsStringWithRegexValueObject;
use Apie\TextValueObjects\Concerns\IndexesWords;
use Faker\Generator;

#[FakeMethod('createRandom')]
#[ProvideIndex('getIndexes')]
class SmallDatabaseText implements HasRegexValueObjectInterface
{
    use IndexesWords;
    use IsStringWithRegexValueObject;

    public static function getRegularExpression(): string
    {
        return '/^.{0,255}$/';
    }

    protected function convert(string $input): string
    {
        return trim($input);
    }

    public static function createRandom(Generator $generator): self
    {
        return new static($generator->realText(80));
    }
}