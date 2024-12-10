<?php

// Subject Interface
interface ReportGeneratorInterface
{
    public function generateReport(): string;
}

// Real Subject
class RealReportGenerator implements ReportGeneratorInterface
{
    public function __construct()
    {
        // Simulate a heavy operation like database or API calls
        sleep(2);
        echo "RealReportGenerator initialized.\n";
    }

    public function generateReport(): string
    {
        return "Generated a detailed report.";
    }
}

// Proxy
class ReportGeneratorProxy implements ReportGeneratorInterface
{
    private ?RealReportGenerator $realReportGenerator = null;

    public function generateReport(): string
    {
        if ($this->realReportGenerator === null) {
            echo "Initializing RealReportGenerator through Proxy...\n";
            $this->realReportGenerator = new RealReportGenerator();
        }
        return $this->realReportGenerator->generateReport();
    }
}

// Usage Example
function clientCode(ReportGeneratorInterface $reportGenerator)
{
    echo "Client: Requesting report for the first time...\n";
    echo $reportGenerator->generateReport() . PHP_EOL;

    echo "Client: Requesting report for the second time...\n";
    echo $reportGenerator->generateReport() . PHP_EOL;
}

// Proxy Example
$proxy = new ReportGeneratorProxy();
clientCode($proxy);
