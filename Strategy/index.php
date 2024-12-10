<?php

// Strategy Interface
interface PaymentStrategy
{
    public function pay(float $amount): string;
}

// Concrete Strategy: PayPal
class PayPalPayment implements PaymentStrategy
{
    public function pay(float $amount): string
    {
        return "Paid $amount using PayPal.";
    }
}

// Concrete Strategy: Stripe
class StripePayment implements PaymentStrategy
{
    public function pay(float $amount): string
    {
        return "Paid $amount using Stripe.";
    }
}

// Concrete Strategy: Bank Transfer
class BankTransferPayment implements PaymentStrategy
{
    public function pay(float $amount): string
    {
        return "Paid $amount using Bank Transfer.";
    }
}

// Context Class
class PaymentContext
{
    private PaymentStrategy $paymentStrategy;

    public function setPaymentStrategy(PaymentStrategy $paymentStrategy): void
    {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function executePayment(float $amount): string
    {
        return $this->paymentStrategy->pay($amount);
    }
}

// Client Code
function clientCode(PaymentContext $context, PaymentStrategy $strategy, float $amount)
{
    $context->setPaymentStrategy($strategy);
    echo $context->executePayment($amount) . PHP_EOL;
}

// Usage Example
$context = new PaymentContext();

// Pay using PayPal
$paypalPayment = new PayPalPayment();
clientCode($context, $paypalPayment, 100.50);

// Pay using Stripe
$stripePayment = new StripePayment();
clientCode($context, $stripePayment, 200.75);

// Pay using Bank Transfer
$bankTransferPayment = new BankTransferPayment();
clientCode($context, $bankTransferPayment, 300.00);
