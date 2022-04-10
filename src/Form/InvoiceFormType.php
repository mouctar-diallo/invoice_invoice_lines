<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Form\InvoiceLinesFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InvoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('custumer_id', NumberType::class, ['attr' => ['class' => 'form-control'], 'disabled' => 'disabled'])
            ->add('invoice_lines', CollectionType::class, [
                'entry_type' => InvoiceLinesFormType::class,
                'allow_add' => true,
                'entry_options' => ['label' => false]
            ])
            ->add('add', SubmitType::class, ['attr' => ['class' => 'btn btn-success mt-2'], 'label' => 'add invoce'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
