<?php

/**
 * Imagine a collection of blog posts, and we want to traverse them one by one without exposing the underlying data structure.
 */

// Blog Iterator Interface
interface BlogIterator
{
    public function current(): string;
    public function next(): void;
    public function hasNext(): bool;
    public function reset(): void;
}

// Blog Collection Interface (Aggregate)
interface BlogCollection
{
    public function createIterator(): BlogIterator;
}

// Concrete Collection
class BlogPostCollection implements BlogCollection
{
    private array $posts = [];

    public function addPost(string $post): void
    {
        $this->posts[] = $post;
    }

    public function createIterator(): BlogIterator
    {
        return new BlogPostIterator($this->posts);
    }
}

// Concrete Iterator
class BlogPostIterator implements BlogIterator
{
    private array $posts;
    private int $position = 0;

    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public function current(): string
    {
        if (!$this->hasNext()) {
            throw new OutOfBoundsException("No more posts available.");
        }
        return $this->posts[$this->position];
    }

    public function next(): void
    {
        if ($this->hasNext()) {
            $this->position++;
        }
    }

    public function hasNext(): bool
    {
        return $this->position < count($this->posts);
    }

    public function reset(): void
    {
        $this->position = 0;
    }
}

// Client Code
$blogPosts = new BlogPostCollection();
$blogPosts->addPost("Post 1: Understanding PHP");
$blogPosts->addPost("Post 2: Laravel Basics");
$blogPosts->addPost("Post 3: Design Patterns");

$iterator = $blogPosts->createIterator();

try {
    while ($iterator->hasNext()) {
        echo $iterator->current() . PHP_EOL;
        $iterator->next();
    }

    // Resetting the iterator to iterate again
    echo "\nResetting Iterator...\n\n";
    $iterator->reset();

    while ($iterator->hasNext()) {
        echo $iterator->current() . PHP_EOL;
        $iterator->next();
    }
} catch (OutOfBoundsException $e) {
    echo $e->getMessage();
}
