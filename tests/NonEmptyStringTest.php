<?php
namespace Apie\Tests\TextValueObjects;

use Apie\Core\ValueObjects\Exceptions\InvalidStringForValueObjectException;
use Apie\Fixtures\TestHelpers\TestWithFaker;
use Apie\Fixtures\TestHelpers\TestWithOpenapiSchema;
use Apie\TextValueObjects\NonEmptyString;
use PHPUnit\Framework\TestCase;

class NonEmptyStringTest extends TestCase
{
    use TestWithFaker;
    use TestWithOpenapiSchema;
    /**
     * @test
     * @dataProvider inputProvider
     */
    public function fromNative_allows_all_strings_that_are_not_empty(string $expected, string $input)
    {
        $testItem = NonEmptyString::fromNative($input);
        $this->assertEquals($expected, $testItem->toNative());
    }

    /**
     * @test
     * @dataProvider inputProvider
     */
    public function it_allows_all_strings_that_are_not_empty(string $expected, string $input)
    {
        $testItem = new NonEmptyString($input);
        $this->assertEquals($expected, $testItem->toNative());
    }

    public function inputProvider()
    {
        yield ['test', 'test'];
        yield ['trimmed', '   trimmed   '];
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function it_refuses_empty_strings(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        new NonEmptyString($input);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function it_refuses_empty_strings_with_fromNative(string $input)
    {
        $this->expectException(InvalidStringForValueObjectException::class);
        NonEmptyString::fromNative($input);
    }

    public function invalidProvider()
    {
        yield [''];
        yield [' '];
        yield ["          \t\n\r\n"];
    }

    /**
     * @test
     */
    public function it_works_with_schema_generator()
    {
        $this->runOpenapiSchemaTestForCreation(
            NonEmptyString::class,
            'NonEmptyString-post',
            [
                'type' => 'string',
                'format' => 'nonemptystring',
                'pattern' => true,
            ]
        );
    }

    /**
     * @test
     */
    public function it_works_with_apie_faker()
    {
        $this->runFakerTest(NonEmptyString::class);
    }
}
