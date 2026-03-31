<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{
    public function testResolvePageReturnsRequestedAllowedPage(): void
    {
        $application = new Application();

        self::assertSame('about', $application->resolvePage('about'));
    }

    public function testResolvePageFallsBackToHomepageForUnknownPage(): void
    {
        $application = new Application();

        self::assertSame('homepage', $application->resolvePage('not-existing-page'));
    }

    public function testRenderOutputsRequestedPageInsideLayout(): void
    {
        $application = new Application(['page' => 'dashboard']);

        $html = $application->render();

        self::assertStringContainsString('Hello World App', $html);
        self::assertStringContainsString('This is user Dashboard', $html);
    }
}
