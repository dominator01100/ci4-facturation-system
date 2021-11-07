<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    public $categories =[
		'name' => 'required|min_length[3]|max_length[255]'
	];

    public $tags =[
		'name' => 'required|min_length[3]|max_length[255]'
	];

    public $products =[
		'name' => 'required|min_length[3]|max_length[255]',
		'code' => 'required|min_length[3]|max_length[10]',
		'description' => 'required|min_length[3]|max_length[2000]',
		'entry' => 'required|is_natural',
		'exit' => 'required|is_natural',
		'stock' => 'required|is_natural',
		'price' => 'required|decimal'
	];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
}
