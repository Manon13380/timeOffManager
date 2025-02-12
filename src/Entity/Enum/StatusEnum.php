<?php

namespace App\Entity\Enum;
enum StatusEnum : string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case Approved = 'approved';
    case Rejected = 'rejected';
}