<?php

declare(strict_types=1);

namespace andreskrey\Tests\PHPUnit;

trait FilesDataProviderTrait
{
    public function equalDocumentsDataProvider()
    {
        $path = pathinfo(__FILE__, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'EqualDocuments';
        $directories = array_slice(scandir($path), 2);

        yield from $this->getFiles($path, $directories);
    }

    public function nonEqualDocumentsDataProvider()
    {
        $path = pathinfo(__FILE__, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'NonEqualDocuments';
        $directories = array_slice(scandir($path), 2);

        yield from $this->getFiles($path, $directories);
    }

    private function getFiles(string $path, array $testDirectories): \Generator
    {
        foreach ($testDirectories as $testPage) {
            $testCasePath = $path . DIRECTORY_SEPARATOR . $testPage . DIRECTORY_SEPARATOR;

            $original = file_get_contents($testCasePath . 'original.html');
            $other = file_get_contents($testCasePath . 'other.html');

            yield $testPage => [$original, $other];
        }
    }
}
