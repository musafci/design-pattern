<?php

namespace App\ChainOfResponsibility;

// Handler Interface
interface Middleware
{
    public function setNext(Middleware $middleware): Middleware;

    public function handle(string $request): string;
}

// Abstract Middleware Class: Implements chain logic
abstract class AbstractMiddleware implements Middleware
{
    private ?Middleware $nextMiddleware = null;

    public function setNext(Middleware $middleware): Middleware
    {
        $this->nextMiddleware = $middleware;
        return $middleware;
    }

    public function handle(string $request): string
    {
        if ($this->nextMiddleware) {
            return $this->nextMiddleware->handle($request);
        }

        return "Request unhandled.";
    }
}

// Concrete Middleware: Authentication
class AuthenticationMiddleware extends AbstractMiddleware
{
    public function handle(string $request): string
    {
        if ($request === "authenticated") {
            return "Authentication passed. " . parent::handle($request);
        }

        return "Authentication failed.";
    }
}

// Concrete Middleware: Logging
class LoggingMiddleware extends AbstractMiddleware
{
    public function handle(string $request): string
    {
        echo "Request logged.\n";
        return parent::handle($request);
    }
}

// Concrete Middleware: Validation
class ValidationMiddleware extends AbstractMiddleware
{
    public function handle(string $request): string
    {
        if ($request !== "") {
            return "Validation passed. " . parent::handle($request);
        }

        return "Validation failed.";
    }
}

// Client Code
function clientCode(Middleware $middleware, string $request)
{
    echo $middleware->handle($request) . PHP_EOL;
}

// Setting up the chain
$authentication = new AuthenticationMiddleware();
$logging = new LoggingMiddleware();
$validation = new ValidationMiddleware();

$authentication->setNext($logging)->setNext($validation);

// Example: Process a valid request
echo "Processing valid request:\n";
clientCode($authentication, "authenticated");

// Example: Process an invalid request
echo "\nProcessing invalid request:\n";
clientCode($authentication, "");
