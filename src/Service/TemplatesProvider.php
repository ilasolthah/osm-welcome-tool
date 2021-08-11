<?php

namespace App\Service;

use App\Entity\Template;

class TemplatesProvider
{
    private array $templates = [];

    public function __construct(private string $projectDirectory)
    {
        $glob = glob(sprintf('%s/templates/messages/*/*/*.md', $this->projectDirectory));

        foreach ($glob as $path) {
            if (is_readable($path) === true) {
                $region = basename(dirname(dirname($path)));
                $locale = basename(dirname($path));

                $markdown = file_get_contents($path);

                $template = new Template($path, $locale, $markdown);

                $this->templates[$region][] = $template;
            }
        }
    }

    public function getTemplates(string $region): array
    {
        return $this->templates[$region] ?? [];
    }
}
