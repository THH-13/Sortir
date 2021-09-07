<?php

namespace App\Data;

use App\Entity\Campus;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Campus
     */
    public $campus;

    /**
     * @var \DateTime
     */
    public $startDate;

    /**
     * @var \DateTime
     */
    public $endDate;

    /**
     * @var string
     */
    public $status;



}