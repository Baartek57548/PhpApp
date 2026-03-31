<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class Layout
{
    private string $title = 'INF Backend App';

    public function __construct(
        private string $page,
        private string $layoutName,
        private string $basePath = __DIR__ . '/..',
    ) {
    }

    public function render(): string
    {
        return $this->renderFile($this->getLayoutFilePath(), [
            'title' => $this->title,
            'content' => $this->getPageContent(),
        ]);
    }

    public function getPageContent(): string
    {
        return $this->renderFile($this->getPageFilePath());
    }

    private function getLayoutFilePath(): string
    {
        return sprintf('%s/layout/%s.php', $this->basePath, $this->layoutName);
    }

    private function getPageFilePath(): string
    {
        return sprintf('%s/page/%s.php', $this->basePath, $this->page);
    }

    /**
     * @param array<string, string> $variables
     */
    private function renderFile(string $filePath, array $variables = []): string
    {
        if (!is_file($filePath)) {
            throw new RuntimeException(sprintf('Template file not found: %s', $filePath));
        }

        extract($variables, EXTR_SKIP);

        ob_start();
        include $filePath;

        return (string) ob_get_clean();
    }
}
