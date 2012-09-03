<?php
/**
 * @package     Xhprof
 * @author      Axel Etcheverry <axel@etcheverry.biz>
 * @copyright   Copyright (c) 2012 Axel Etcheverry (https://twitter.com/euskadi31)
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
