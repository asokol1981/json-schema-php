<?php

declare(strict_types=1);

/*
 * This file is part of Json Schema PHP.
 *
 * (c) Aleksei Sokolov <asokol.beststudio@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ASokol1981\JsonSchema\Tests\Unit\Draft07;

use ASokol1981\JsonSchema\Draft07\AbstractJsonSchema;
use ASokol1981\JsonSchema\Draft07\NumberSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class NumberSchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new NumberSchema();
    }

    public static function provider(): array
    {
        return [
            'default' => [
                fn(NumberSchema $schema) => $schema,
                ['type' => 'number'],
            ],
            'multiple_of' => [
                fn(NumberSchema $schema) => $schema->setMultipleOf(1),
                ['type' => 'number', 'multipleOf' => 1.0],
            ],
            'minimum' => [
                fn(NumberSchema $schema) => $schema->setMinimum(1),
                ['type' => 'number', 'minimum' => 1.0],
            ],
            'exclusive_minimum' => [
                fn(NumberSchema $schema) => $schema->setExclusiveMinimum(1),
                ['type' => 'number', 'exclusiveMinimum' => 1.0],
            ],
            'maximum' => [
                fn(NumberSchema $schema) => $schema->setMaximum(1),
                ['type' => 'number', 'maximum' => 1.0],
            ],
            'exclusive_maximum' => [
                fn(NumberSchema $schema) => $schema->setExclusiveMaximum(1),
                ['type' => 'number', 'exclusiveMaximum' => 1.0],
            ],
            'all' => [
                fn(NumberSchema $schema) => $schema
                    // common
                    ->setId('id')
                    ->setSchema('schema')
                    ->setComment('comment')
                    ->setTitle('title')
                    ->setDescription('description')
                    ->setDefault('default')
                    ->setExamples(['examples'])
                    ->setReadOnly(true)
                    ->setWriteOnly(true)
                    ->setDeprecated(true)
                    // number
                    ->setMultipleOf(1)
                    ->setMinimum(2)
                    ->setExclusiveMinimum(3)
                    ->setMaximum(4)
                    ->setExclusiveMaximum(5),
                [
                    'type' => 'number',
                    // common
                    '$id' => 'id',
                    '$schema' => 'schema',
                    '$comment' => 'comment',
                    'title' => 'title',
                    'description' => 'description',
                    'default' => 'default',
                    'examples' => ['examples'],
                    'readOnly' => true,
                    'writeOnly' => true,
                    'deprecated' => true,
                    // number
                    'multipleOf' => 1.0,
                    'minimum' => 2.0,
                    'exclusiveMinimum' => 3.0,
                    'maximum' => 4.0,
                    'exclusiveMaximum' => 5.0,
                ],
            ],
        ];
    }

    #[DataProvider('provider')]
    public function test(\Closure $callback, array $expected)
    {
        $schema = new NumberSchema();
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }

    public static function exception_provider(): array
    {
        return [
            'multiple_of' => [
                fn(NumberSchema $schema) => $schema->setMultipleOf(-1),
            ],
        ];
    }

    #[DataProvider('exception_provider')]
    public function test_exception(\Closure $callback)
    {
        $schema = new NumberSchema();

        $this->expectException(\InvalidArgumentException::class);
        $callback($schema);
    }
}
