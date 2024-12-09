<?php

// Abstract Product Interfaces
interface Button
{
    public function render(): string;
}

interface Form
{
    public function render(): string;
}

// Concrete Products for Web
class WebButton implements Button
{
    public function render(): string
    {
        return '<button>Web Button</button>';
    }
}

class WebForm implements Form
{
    public function render(): string
    {
        return '<form>Web Form</form>';
    }
}

// Concrete Products for Mobile
class MobileButton implements Button
{
    public function render(): string
    {
        return '[Mobile Button]';
    }
}

class MobileForm implements Form
{
    public function render(): string
    {
        return '[Mobile Form]';
    }
}

// Abstract Factory Interface
interface UIFactory
{
    public function createButton(): Button;
    public function createForm(): Form;
}

// Concrete Factories
class WebUIFactory implements UIFactory
{
    public function createButton(): Button
    {
        return new WebButton();
    }

    public function createForm(): Form
    {
        return new WebForm();
    }
}

class MobileUIFactory implements UIFactory
{
    public function createButton(): Button
    {
        return new MobileButton();
    }

    public function createForm(): Form
    {
        return new MobileForm();
    }
}

// Usage Example
function renderUI(UIFactory $factory)
{
    $button = $factory->createButton();
    $form = $factory->createForm();

    echo $button->render() . PHP_EOL;
    echo $form->render() . PHP_EOL;
}

// Client Code
$platform = 'mobile'; // Change to 'web' or 'mobile'

if ($platform === 'web') {
    $factory = new WebUIFactory();
} elseif ($platform === 'mobile') {
    $factory = new MobileUIFactory();
} else {
    throw new \InvalidArgumentException("Unknown platform: $platform");
}

renderUI($factory);
