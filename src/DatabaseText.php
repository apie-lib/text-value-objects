<?php
namespace Apie\TextValueObjects;

use Apie\Core\Attributes\FakeMethod;
use Apie\Core\Attributes\SchemaMethod;
use Apie\Core\ValueObjects\Interfaces\HasRegexValueObjectInterface;
use Apie\Core\ValueObjects\IsStringWithRegexValueObject;
use Faker\Generator;

#[FakeMethod('createRandom')]
#[SchemaMethod('createSchema')]
final class DatabaseText implements HasRegexValueObjectInterface
{
    use IsStringWithRegexValueObject;

    public static function getRegularExpression(): string
    {
        return '/^.{0,65535}$/';
    }

    protected function convert(string $input): string
    {
        return trim($input);
    }

    public static function createRandom(Generator $generator): self
    {
        return new DatabaseText($generator->realText(1024));
    }

    /**
     * Provide OpenAPI schema. This is overwritten as some libraries will try to generate strings of 65535 characters
     * all the time for example strings resulting in terrible performance.
     *
     * @return array<string, string|int>
     */
    public static function createSchema(): array
    {
        return [
            'type' => 'string',
            'minLength' => 0,
            'maxLength' => 65535,
            'example' => 'Lorem Ipsum',
        ];
    }
}
