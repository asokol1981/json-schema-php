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
use ASokol1981\JsonSchema\Draft07\IfSchema;
use ASokol1981\JsonSchema\Draft07\IntegerSchema;
use ASokol1981\JsonSchema\Draft07\NumberSchema;
use ASokol1981\JsonSchema\Draft07\StringSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class IfSchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new IfSchema(new StringSchema());
    }

    public static function provider(): array
    {
        return [
            'if' => [
                fn() => new IfSchema(new StringSchema()),
                ['if' => ['type' => 'string']],
            ],
            'if_bool' => [
                fn() => new IfSchema(true),
                ['if' => true],
            ],
            'then' => [
                fn() => (new IfSchema(new StringSchema()))->thenSchema(new IntegerSchema()),
                [
                    'if' => ['type' => 'string'],
                    'then' => ['type' => 'integer']
                ],
            ],
            'then_bool' => [
                fn() => (new IfSchema(new StringSchema()))->thenSchema(true),
                [
                    'if' => ['type' => 'string'],
                    'then' => true
                ],
            ],
            'else' => [
                fn() => (new IfSchema(new StringSchema()))->elseSchema(new NumberSchema()),
                [
                    'if' => ['type' => 'string'],
                    'else' => ['type' => 'number']
                ],
            ],
            'else_bool' => [
                fn() => (new IfSchema(new StringSchema()))->elseSchema(true),
                [
                    'if' => ['type' => 'string'],
                    'else' => true
                ],
            ],
            'all' => [
                fn() => (new IfSchema(new StringSchema()))
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
                    // if
                    ->thenSchema(new IntegerSchema())
                    ->elseSchema(new NumberSchema()),
                [
                    'if' => ['type' => 'string'],
                    // if
                    'then' => ['type' => 'integer'],
                    'else' => ['type' => 'number'],
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
                ],
            ],
        ];
    }

    #[DataProvider('provider')]
    public function test(\Closure $callback, array $expected)
    {
        $schema = $callback();

        $this->assertSame($expected, $schema->toArray());
    }
}
