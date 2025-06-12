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
use ASokol1981\JsonSchema\Draft07\StringSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class StringSchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new StringSchema();
    }

    public static function provider(): array
    {
        return [
            'default' => [
                fn(StringSchema $schema) => $schema,
                ['type' => 'string'],
            ],
            'enum' => [
                fn(StringSchema $schema) => $schema->setEnum(['foo', 'bar']),
                ['type' => 'string', 'enum' => ['foo', 'bar']],
            ],
            'min_length' => [
                fn(StringSchema $schema) => $schema->setMinLength(5),
                ['type' => 'string', 'minLength' => 5],
            ],
            'max_length' => [
                fn(StringSchema $schema) => $schema->setMaxLength(5),
                ['type' => 'string', 'maxLength' => 5],
            ],
            'pattern' => [
                fn(StringSchema $schema) => $schema->setPattern('[0-9]{5}'),
                ['type' => 'string', 'pattern' => '[0-9]{5}'],
            ],
            'format' => [
                fn(StringSchema $schema) => $schema->setFormat('date'),
                ['type' => 'string', 'format' => 'date'],
            ],
            'content_media_type' => [
                fn(StringSchema $schema) => $schema->setContentMediaType('application/json'),
                ['type' => 'string', 'contentMediaType' => 'application/json'],
            ],
            'content_encoding' => [
                fn(StringSchema $schema) => $schema->setContentEncoding('utf-8'),
                ['type' => 'string', 'contentEncoding' => 'utf-8'],
            ],
            'all' => [
                fn(StringSchema $schema) => $schema
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
                    // string
                    ->setMinLength(5)
                    ->setMaxLength(5)
                    ->setPattern('[0-9]{5}')
                    ->setFormat('date')
                    ->setContentMediaType('application/json')
                    ->setContentEncoding('utf-8'),
                [
                    'type' => 'string',
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
                    // string
                    'minLength' => 5,
                    'maxLength' => 5,
                    'pattern' => '[0-9]{5}',
                    'format' => 'date',
                    'contentMediaType' => 'application/json',
                    'contentEncoding' => 'utf-8',
                ],
            ],
        ];
    }

    #[DataProvider('provider')]
    public function test(\Closure $callback, array $expected)
    {
        $schema = new StringSchema();
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }

    public static function format_provider(): array
    {
        $options = [];
        foreach ([
            'date' => 'setFormatDate',
            'time' => 'setFormatTime',
            'date-time' => 'setFormatDateTime',
            'email' => 'setFormatEmail',
            'idn-email' => 'setFormatIdnEmail',
            'hostname' => 'setFormatHostname',
            'idn-hostname' => 'setFormatIdnHostname',
            'ipv4' => 'setFormatIpv4',
            'ipv6' => 'setFormatIpv6',
            'uri' => 'setFormatUri',
            'uri-reference' => 'setFormatUriReference',
            'iri' => 'setFormatIri',
            'iri-reference' => 'setFormatIriReference',
            'uuid' => 'setFormatUuid',
            'json-pointer' => 'setFormatJsonPointer',
            'relative-json-pointer' => 'setFormatRelativeJsonPointer',
            'regex' => 'setFormatRegex',
        ] as $format => $method) {
            $options[$format] = [
                fn(StringSchema $schema) => $schema->$method(),
                ['type' => 'string', 'format' => $format],
            ];
        }
        return $options;
    }

    #[DataProvider('format_provider')]
    public function test_format(\Closure $callback, array $expected)
    {
        $schema = new StringSchema();
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }

    public static function exception_provider(): array
    {
        return [
            'min_length' => [
                fn(StringSchema $schema) => $schema->setMinLength(-1),
            ],
            'max_length' => [
                fn(StringSchema $schema) => $schema->setMaxLength(-1),
            ],
        ];
    }

    #[DataProvider('exception_provider')]
    public function test_exception(\Closure $callback)
    {
        $schema = new StringSchema();

        $this->expectException(\InvalidArgumentException::class);
        $callback($schema);
    }
}
