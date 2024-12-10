<?php

// Component Interface
interface FileSystemComponent
{
    public function getSize(): int;
    public function getName(): string;
}

// Leaf Class: Represents individual files
class File implements FileSystemComponent
{
    private string $name;
    private int $size;

    public function __construct(string $name, int $size)
    {
        $this->name = $name;
        $this->size = $size;
    }


    public function getSize(): int
    {
        return $this->size;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

// Composite Class: Represents directories that can contain files or other directories
class Directory implements FileSystemComponent
{
    private string $name;
    private array $children = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function add(FileSystemComponent $component): void
    {
        $this->children[] = $component;
    }

    public function getSize(): int
    {
        $totalSize = 0;
        foreach ($this->children as $child) {
            $totalSize += $child->getSize();
        }
        return $totalSize;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

// Client Code
function clientCode(FileSystemComponent $component)
{
    echo "Component: " . $component->getName() . " | Size: " . $component->getSize() . " KB\n";
}

// Usage Example
$file1 = new File("File1.txt", 50);
$file2 = new File("File2.txt", 100);
$file3 = new File("File3.txt", 75);

$directory1 = new Directory("Documents");
$directory2 = new Directory("Images");

$directory1->add($file1);
$directory1->add($file2);
$directory2->add($file3);

$rootDirectory = new Directory("Root");
$rootDirectory->add($directory1);
$rootDirectory->add($directory2);

echo "Root Directory Size: " . $rootDirectory->getSize() . " KB\n";

// Output the individual file details
clientCode($file1);
clientCode($file2);
clientCode($directory1);
clientCode($rootDirectory);
