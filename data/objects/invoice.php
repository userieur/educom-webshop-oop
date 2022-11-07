<?php

    class Invoice {
        public $id;
        public $invoice_num;
        public $user_id;
        public $date;

        public function setUserId($id)
        {
            $this->user_id = $id;
        }

        public function getUserId()
        {
            return $this->user_id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setInvoiceNum($invoice_num)
        {
            $this->invoice_num = $invoice_num;
        }

        public function getInvoiceNum()
        {
            return $this->invoice_num;
        }

    }