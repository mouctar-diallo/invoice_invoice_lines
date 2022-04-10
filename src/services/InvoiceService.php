<?php
namespace App\services;

use App\Entity\Invoice;
use App\Entity\InvoiceLines;
use App\Form\InvoiceFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceService extends AbstractController{

    public function addInvoiceLines($invoice_lines, $invoice) {
        $invoices = array();
        foreach($invoice_lines as $line_invoice ){
            $result = $line_invoice->getQuantity() * $line_invoice->getAmount();
            $amount_vat = $result * 0.18;
            $line_invoice->setVatAmount($amount_vat);
            $total = intval($amount_vat) + intval($result);
            $line_invoice->setInvoice($invoice);
            $line_invoice->setTotal($total);
            $invoices = $line_invoice;
        }

        return $invoices;
    }

    public function findLastInsertInvoiceId($invoiceRepo) {
        $last_invoice_id =  $invoiceRepo->findOneBy([], ['id' => 'desc']);
        $number_invoice = $last_invoice_id ? (int) $last_invoice_id->getId()  + 1 : random_int(1,100);
        return $number_invoice;
    }

    public function initForm($request) {
        $invoice = new Invoice();
        $invoices_lines = new InvoiceLines();
        $invoice->getInvoiceLines()->add($invoices_lines);

        return $invoice;
    }

    public function resetForm($entity, $form) {
        unset($entity);
        unset($form);
    }
}