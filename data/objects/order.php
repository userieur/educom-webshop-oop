<?php

class ORDER
{
    public $invoice;
    public $invoiceLines = [];
//--------------------------------------------------------------------
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }
//--------------------------------------------------------------------
    public function getInvoiceLines()
    {
        return $this->invoiceLines;
    }
//--------------------------------------------------------------------
    public function addInvoiceLine(invoiceline $invoiceline, $key)
    {
        $this->invoiceLines[$key]=$invoiceline;
    }
//--------------------------------------------------------------------
}