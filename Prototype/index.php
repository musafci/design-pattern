<?php

namespace App\Prototype;

// Prototype Interface
interface ReportPrototype
{
    public function clone(): ReportPrototype;
}

// Concrete Prototype
class Report implements ReportPrototype
{
    private $title;
    private $content;
    private $format;

    public function __construct($title, $content, $format = 'PDF')
    {
        $this->title = $title;
        $this->content = $content;
        $this->format = $format;
    }

    // Clone method
    public function clone(): ReportPrototype
    {
        return clone $this;
    }

    // Setters for customization
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getReportDetails()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'format' => $this->format,
        ];
    }
}

// Usage Example
$baseReport = new Report('Annual Report', 'Base Content for Annual Report');

// Clone the base report for customization
$salesReport = $baseReport->clone();
$salesReport->setTitle('Sales Report');
$salesReport->setContent('Customized content for Sales Report.');

$financeReport = $baseReport->clone();
$financeReport->setTitle('Finance Report');
$financeReport->setContent('Detailed financial analysis.');

echo "Base Report: " . json_encode($baseReport->getReportDetails()) . PHP_EOL;
echo "Sales Report: " . json_encode($salesReport->getReportDetails()) . PHP_EOL;
echo "Finance Report: " . json_encode($financeReport->getReportDetails()) . PHP_EOL;
