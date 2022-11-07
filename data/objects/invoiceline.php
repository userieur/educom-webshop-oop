<?php

    class InvoiceLine {
        public $id;
        public $invoice_id;
        public $article_id;
        public $sales_amount;
        public $sales_price;

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setInvoiceId($invoice_id)
        {
            $this->invoice_id = $invoice_id;
        }

        public function getInvoiceId()
        {
            return $this->invoice_id;
        }

        public function setArticleId($article_id)
        {
            $this->article_id = $article_id;
        }

        public function getArticleId()
        {
            return $this->article_id;
        }

        public function setSalesAmount($sales_amount)
        {
            $this->sales_amount = $sales_amount;
        }

        public function getSalesamount()
        {
            return $this->sales_amount;
        }

        public function setSalesPrice($sales_price)
        {
            $this->sales_price = $sales_price;
        }

        public function getSalesPrice()
        {
            return $this->sales_price;
        }

        }