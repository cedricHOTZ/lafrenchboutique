<?php

namespace App\Class;
use App\Entity\Category;

class Search{
    /**
     * Undocumented variable
     *
     * @var string
     */
    public $string = '';

/**
 * Undocumented variable
 *
 * @var null|float
 */
    public $max;


/**
 * Undocumented variable
 *
 * @var null|float
 */
    public $min;
    
    /**
     *
     * @var Category[]
     */

    public $categories = [];
}

