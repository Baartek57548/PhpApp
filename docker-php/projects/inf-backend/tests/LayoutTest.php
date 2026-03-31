<?php

declare(strict_types=1);

namespace App\Tests;

use App\Layout;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class LayoutTest extends TestCase
{
    public function testGetPageContentReturnsPageMarkup(): void
    {
        $layout = new Layout('about', 'default');

        $content = $layout->getPageContent();

        self::assertStringContainsString('This is about page', $content);
    }

    public function testRenderReturnsFullHtmlDocument(): void
    {
        $layout = new Layout('homepage', 'default');

        $html = $layout->render();

        self::assertStringContainsString('<!DOCTYPE html>', $html);
        self::assertStringContainsString('<title>INF Backend App</title>', $html);
        self::assertStringContainsString('This is Homepage', $html);
    }

    public function testGetPageContentThrowsExceptionWhenTemplateIsMissing(): void
    {
        $layout = new Layout('missing', 'default');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Template file not found');

        $layout->getPageContent();
    }
}
