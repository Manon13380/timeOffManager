<?php

namespace App\Controller\Admin;

use App\Entity\LeaveRequest;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LeaveRequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LeaveRequest::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('userName');
        yield DateField::new('startDate');
        yield DateField::new('endDate');
        yield TextField::new('reason');
        yield TextField::new('status');

    }
  
}
