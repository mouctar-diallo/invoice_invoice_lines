<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\InvoiceLines;
use App\Form\InvoiceFormType;
use App\services\InvoiceService;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    private $invoiceService;
    private $em;
    private $invoiceRepo;
    public function __construct( EntityManagerInterface $em, InvoiceRepository $invoiceRepo, InvoiceService $invoiceService) {
        $this->em = $em;
        $this->invoiceRepo = $invoiceRepo;
        $this->invoiceService = $invoiceService;
    }

    #[Route('/', name: 'create_invoice')]
    public function addInvoiceAndInvoiceLines(Request $request): Response
    {
        $invoice = $this->invoiceService->initForm($request);
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
           $number_invoice = $this->invoiceService->findLastInsertInvoiceId($this->invoiceRepo);
            $invoice->setInvoiceNumber($number_invoice);
            $this->em->persist($invoice);
            //add invoice lines
            $invoice_lines = $this->invoiceService
                ->addInvoiceLines($invoice->getInvoiceLines(),$invoice);
            $this->em->persist($invoice_lines);
            $this->em->flush();
        }
        $this->invoiceService->resetForm($invoice,$form);
        return $this->renderForm('invoice/add.html.twig', [
            'form' => $form,
        ]);
    }
}
