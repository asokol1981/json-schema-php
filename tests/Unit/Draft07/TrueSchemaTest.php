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

use PHPUnit\Framework\TestCase;
use ASokol1981\JsonSchema\Draft07\TrueSchema;

class TrueSchemaTest extends TestCase
{
    public function test()
    {
        $schema = new TrueSchema();
        $expected = true;

        $this->assertSame($expected, $schema->toArray());
    }
}
