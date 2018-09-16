<?php

namespace Tests\AnnotationRoute;

use AnnotationRoute\RecursivePhpFileIterator;
use PHPUnit\Framework\TestCase;

/**
 * Class RecursivePhpFileIteratorTest
 *
 * @package Tests\AnnotationRoute
 * @covers \AnnotationRoute\RecursivePhpFileIterator
 */
class RecursivePhpFileIteratorTest extends TestCase
{
    public function testFindsCorrectFilesWithPostfix()
    {
        $files = $this->getFilenames(new RecursivePhpFileIterator(__DIR__ . '/Fixtures', 'Controller'));

        $this->assertCount(2, $files);
        $this->assertContains('HomeController.php', $files);
        $this->assertContains('UsersController.php', $files);
        $this->assertNotContains('Base.php', $files);
    }

    public function testFindsCorrectFilesWithoutPostfix()
    {
        $files = $this->getFilenames(new RecursivePhpFileIterator(__DIR__ . '/Fixtures'));

        $this->assertCount(3, $files);
        $this->assertContains('HomeController.php', $files);
        $this->assertContains('UsersController.php', $files);
        $this->assertContains('Base.php', $files);
    }

    /**
     * Get all filenames for a given RecursivePhpFileIterator
     *
     * @param RecursivePhpFileIterator $files
     * @return array
     */
    private function getFilenames(RecursivePhpFileIterator $files)
    {
        $filenames = [];

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $filenames[] = $file->getFilename();
        }
        return $filenames;
    }
}
