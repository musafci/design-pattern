<?php

// Subsystem Class 1: Order Service
class OrderService
{
    public function getOrderDetails(int $orderId): string
    {
        return "Order details for Order ID: {$orderId}";
    }
}

// Subsystem Class 2: Payment Service
class PaymentService
{
    public function processPayment(int $orderId): string
    {
        return "Payment processed for Order ID: {$orderId}";
    }
}

// Subsystem Class 3: Notification Service
class NotificationService
{
    public function sendInvoiceEmail(int $orderId): string
    {
        return "Invoice email sent for Order ID: {$orderId}";
    }
}

// Facade Class
class InvoiceFacade
{
    private $orderService;
    private $paymentService;
    private $notificationService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->paymentService = new PaymentService();
        $this->notificationService = new NotificationService();
    }

    public function generateInvoice(int $orderId): string
    {
        $orderDetails = $this->orderService->getOrderDetails($orderId);
        $paymentStatus = $this->paymentService->processPayment($orderId);
        $notificationStatus = $this->notificationService->sendInvoiceEmail($orderId);

        return "{$orderDetails}\n{$paymentStatus}\n{$notificationStatus}\nInvoice generation completed.";
    }
}

// Client Code
function clientCode(InvoiceFacade $facade, int $orderId)
{
    echo $facade->generateInvoice($orderId);
}

// Usage Example
$invoiceFacade = new InvoiceFacade();
clientCode($invoiceFacade, 123);
