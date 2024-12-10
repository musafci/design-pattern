<?php

namespace App\Adapter;

// Target Interface
interface PaymentGateway
{
    public function processPayment(float $amount): string;
}

// Adaptee Class: Existing system with incompatible interface
class NewPaymentGateway
{
    public function makePayment(float $amount): string
    {
        return "Processing payment of $amount through the new payment gateway.";
    }
}

// Adapter Class
class PaymentGatewayAdapter implements PaymentGateway
{
    private NewPaymentGateway $newPaymentGateway;

    public function __construct(NewPaymentGateway $newPaymentGateway)
    {
        $this->newPaymentGateway = $newPaymentGateway;
    }

    public function processPayment(float $amount): string
    {
        // Adapts the new system's method to the target interface
        return $this->newPaymentGateway->makePayment($amount);
    }
}

// Client Code
function clientCode(PaymentGateway $gateway)
{
    echo $gateway->processPayment(100.50) . PHP_EOL;
}

// Usage Example
$newPaymentGateway = new NewPaymentGateway();
$adapter = new PaymentGatewayAdapter($newPaymentGateway);
clientCode($adapter); // Using the Adapter to interact with the new system
