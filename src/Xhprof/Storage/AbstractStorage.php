<?php
/**
 * @package     Xhprof
 * @author      Axel Etcheverry <axel@etcheverry.biz>
 * @copyright   Copyright (c) 2012 Axel Etcheverry (http://www.axel-etcheverry.com)
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 */

/**
 * @namespace
 */
namespace Xhprof\Storage;

class AbstractStorage
{
    protected $options = array();
    
    public function __construct($options = array())
    {
        $this->setOptions($options);
    }
    
    public function setOptions(array $options)
    {
        $this->options = $options;
        
        return $this;
    }
    
    protected function _getId($type)
    {
        return uniqid();
    }
}
