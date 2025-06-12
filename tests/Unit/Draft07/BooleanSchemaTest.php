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
use ASokol1981\JsonSchema\Draft07\BooleanSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class BooleanSchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new BooleanSchema();
    }

    public static function provider(): array
    {
        return [
            'default' => [
                fn(BooleanSchema $schema) => $schema,
                ['type' => 'boolean'],
            ],
            'all' => [
                fn(BooleanSchema $schema) => $schema
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
                    ->setDeprecated(true),
                [
                    'type' => 'boolean',
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
        $schema = new BooleanSchema();
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }
}
