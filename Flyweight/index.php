<?php

// Flyweight Class
class Shape
{
    private string $color; // Intrinsic state

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function draw(string $shapeType, int $x, int $y): string
    {
        return "Drawing a {$shapeType} of color {$this->color} at position ({$x}, {$y}).";
    }
}

// Flyweight Factory
class ShapeFactory
{
    private array $shapes = []; // Pool of Flyweight objects

    public function getShape(string $color): Shape
    {
        if (!isset($this->shapes[$color])) {
            $this->shapes[$color] = new Shape($color); // Create new Flyweight object
            echo "Creating new Shape with color: {$color}.\n";
        }
        return $this->shapes[$color];
    }

    public function getShapeCount(): int
    {
        return count($this->shapes);
    }
}

// Client Code
function clientCode(ShapeFactory $factory)
{
    $shapesToDraw = [
        ['type' => 'circle', 'color' => 'red', 'x' => 10, 'y' => 20],
        ['type' => 'square', 'color' => 'blue', 'x' => 15, 'y' => 25],
        ['type' => 'circle', 'color' => 'red', 'x' => 30, 'y' => 40],
        ['type' => 'triangle', 'color' => 'blue', 'x' => 50, 'y' => 60],
    ];

    foreach ($shapesToDraw as $shapeData) {
        $shape = $factory->getShape($shapeData['color']);
        echo $shape->draw($shapeData['type'], $shapeData['x'], $shapeData['y']) . PHP_EOL;
    }

    echo "Total unique shapes created: " . $factory->getShapeCount() . PHP_EOL;
}

// Usage Example
$shapeFactory = new ShapeFactory();
clientCode($shapeFactory);