<?php

declare(strict_types=1);

namespace App;

class Application
{
    /**
     * @var list<string>
     */
    private array $allowedPages = [
        'homepage',
        'about',
        'articles',
        'dashboard',
    ];

    /**
     * @param array<string, mixed>|null $queryParameters
     * @param list<string>|null $allowedPages
     */
    public function __construct(
        private ?array $queryParameters = null,
        ?array $allowedPages = null,
    ) {
        if ($allowedPages !== null) {
            $this->allowedPages = $allowedPages;
        }
    }

    public function run(): void
    {
        echo $this->render();
    }

    public function render(): string
    {
        $page = $this->resolvePage($this->getRequestedPage());

        return $this->createLayout($page)->render();
    }

    public function resolvePage(?string $page): string
    {
        if ($page === null || !in_array($page, $this->allowedPages, true)) {
            return 'homepage';
        }

        return $page;
    }

    private function getRequestedPage(): ?string
    {
        $queryParameters = $this->queryParameters ?? $_GET;
        $page = $queryParameters['page'] ?? null;

        return is_string($page) ? $page : null;
    }

    private function createLayout(string $page): Layout
    {
        return new Layout($page, 'default');
    }
}
