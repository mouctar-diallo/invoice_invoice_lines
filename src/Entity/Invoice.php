<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $invoice_date;

    #[ORM\Column(type: 'integer')]
    private $invoice_number;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $custumer_id;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceLines::class, cascade: ["persist"])]
    private $invoice_lines;

    public function __construct()
    {
        $this->invoice_date = new \DateTime('now');
        $this->custumer_id = random_int(1,10000);
        $this->invoice_lines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceDate(): ?\DateTimeInterface
    {
        return $this->invoice_date;
    }

    public function setInvoiceDate(\DateTimeInterface $invoice_date): self
    {
        $this->invoice_date = $invoice_date;

        return $this;
    }

    public function getInvoiceNumber(): ?int
    {
        return $this->invoice_number;
    }

    public function setInvoiceNumber(int $invoice_number): self
    {
        $this->invoice_number = $invoice_number;

        return $this;
    }

    public function getCustumerId(): ?int
    {
        return $this->custumer_id;
    }

    public function setCustumerId(?int $custumer_id): self
    {
        $this->custumer_id = $custumer_id;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceLines>
     */
    public function getInvoiceLines(): Collection
    {
        return $this->invoice_lines;
    }

    public function addInvoiceLine(InvoiceLines $invoiceLine): self
    {
        if (!$this->invoice_lines->contains($invoiceLine)) {
            $this->invoice_lines[] = $invoiceLine;
            $invoiceLine->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLines $invoiceLine): self
    {
        if ($this->invoice_lines->removeElement($invoiceLine)) {
            // set the owning side to null (unless already changed)
            if ($invoiceLine->getInvoice() === $this) {
                $invoiceLine->setInvoice(null);
            }
        }

        return $this;
    }

}
