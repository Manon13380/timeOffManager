<?php

namespace App\Controller\Admin;

use App\Entity\LeaveRequest;
use App\Entity\Enum\StatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LeaveRequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LeaveRequest::class;
    }

    public function configureFilters(Filters $filters): Filters
{
    return $filters
        ->add(ChoiceFilter::new('status')->setChoices([
            'Draft' => StatusEnum::Draft,
            'Submitted' => StatusEnum::Submitted,
            'Rejected' => StatusEnum::Rejected,
            'Approved' => StatusEnum::Approved,     
        ]));
}

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('userName');
        yield DateField::new('startDate');
        yield DateField::new('endDate');
        yield TextField::new('reason');
        yield ChoiceField::new('status')->setChoices([
            'Draft' => StatusEnum::Draft,
            'Submitted' => StatusEnum::Submitted,
            'Rejected' => StatusEnum::Rejected,
            'Approved' => StatusEnum::Approved,     
        ]);

    }


  
}
