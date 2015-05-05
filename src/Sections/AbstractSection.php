<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 04.05.2015
 * Time: 20:43
 */

namespace LarusVK\Sections;


use LarusVK\Client;

/**
 * Class AbstractSection
 * @package LarusVK\Sections
 */
class AbstractSection {


    protected  $parent;


    public function __construct(Client $parent){

        $this->parent = $parent;

    }
}