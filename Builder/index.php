<?php

namespace App\Builder;

// The Product
class Report
{
    private $header;
    private $content;
    private $footer;

    public function setHeader(string $header)
    {
        $this->header = $header;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function setFooter(string $footer)
    {
        $this->footer = $footer;
    }

    public function getReport(): string
    {
        return "Report: \nHeader: {$this->header}\nContent: {$this->content}\nFooter: {$this->footer}\n";
    }
}

// Builder Interface
interface ReportBuilder
{
    public function buildHeader();
    public function buildContent();
    public function buildFooter();
    public function getReport(): Report;
}

// Concrete Builder for a PDF Report
class PDFReportBuilder implements ReportBuilder
{
    private $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function buildHeader()
    {
        $this->report->setHeader('PDF Header');
    }

    public function buildContent()
    {
        $this->report->setContent('PDF Content');
    }

    public function buildFooter()
    {
        $this->report->setFooter('PDF Footer');
    }

    public function getReport(): Report
    {
        return $this->report;
    }
}

// Concrete Builder for an HTML Report
class HTMLReportBuilder implements ReportBuilder
{
    private $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function buildHeader()
    {
        $this->report->setHeader('HTML Header');
    }

    public function buildContent()
    {
        $this->report->setContent('HTML Content');
    }

    public function buildFooter()
    {
        $this->report->setFooter('HTML Footer');
    }

    public function getReport(): Report
    {
        return $this->report;
    }
}

// Director
class ReportDirector
{
    private $builder;

    public function setBuilder(ReportBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function buildReport(): Report
    {
        $this->builder->buildHeader();
        $this->builder->buildContent();
        $this->builder->buildFooter();

        return $this->builder->getReport();
    }
}

// Usage Example
$director = new ReportDirector();

// Build a PDF Report
$pdfBuilder = new PDFReportBuilder();
$director->setBuilder($pdfBuilder);
$pdfReport = $director->buildReport();
echo $pdfReport->getReport();

// Build an HTML Report
$htmlBuilder = new HTMLReportBuilder();
$director->setBuilder($htmlBuilder);
$htmlReport = $director->buildReport();
echo $htmlReport->getReport();
