<?php

declare(strict_types=1);

namespace Eminiarts\Tabs\Tests\Feature;

use Eminiarts\Tabs\Tab;
use PHPUnit\Framework\TestCase;

class TabTest extends TestCase
{
    public function testCanInstantiateWithConstructor(): void
    {
        $tab = new Tab('Test Tab', []);

        self::assertSame('Test Tab', $tab->toArray()['title']);
    }

    public function testCanInstantiateThroughMake(): void
    {
        $tab = Tab::make('Test Tab', []);

        self::assertSame('Test Tab', $tab->toArray()['title']);
    }

    public function testResolvesNameCorrectly(): void
    {
        $tabWithoutName = Tab::make('My awesome tab', []);
        $tabWithName = Tab::make('My awesome tab with a name', [])->name('Tab name');

        self::assertSame('My awesome tab', $tabWithoutName->toArray()['name']);
        self::assertSame('my-awesome-tab', $tabWithoutName->toArray()['slug']);
        self::assertSame('Tab name', $tabWithName->toArray()['name']);
        self::assertSame('tab-name', $tabWithName->toArray()['slug']);
    }

    public function testShowIf(): void
    {
        $tabBoolean = Tab::make('Show if', [])->showIf(true);
        $tabClosure = Tab::make('Show if', [])->showIf(function () {
            return true;
        });

        self::assertTrue($tabBoolean->toArray()['shouldShow']);
        self::assertTrue($tabClosure->toArray()['shouldShow']);
    }

    public function testShowUnless(): void
    {
        $tabBoolean = Tab::make('Show unless', [])->showUnless(false);
        $tabClosure = Tab::make('Show unless', [])->showUnless(function () {
            return false;
        });

        self::assertTrue($tabBoolean->toArray()['shouldShow']);
        self::assertTrue($tabClosure->toArray()['shouldShow']);
    }
}
