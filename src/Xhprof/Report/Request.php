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
namespace Xhprof\Report;

use Symfony\Component\HttpFoundation;

class Request
{
    protected $defaultParams = array(
        'run'        => array(XHPROF_STRING_PARAM, ''),
        'wts'        => array(XHPROF_STRING_PARAM, ''),
        'symbol'     => array(XHPROF_STRING_PARAM, ''),
        'sort'       => array(XHPROF_STRING_PARAM, 'wt'), // wall time
        'run1'       => array(XHPROF_STRING_PARAM, ''),
        'run2'       => array(XHPROF_STRING_PARAM, ''),
        'source'     => array(XHPROF_STRING_PARAM, 'xhprof'),
        'all'        => array(XHPROF_UINT_PARAM, 0),
    );
    
    protected $params = array();
    
    public function __construct(HttpFoundation\Request $request)
    {
        foreach ($this->defaultParams as $k => $v) {
            switch ($v[0]) {
                case XHPROF_STRING_PARAM:
                    $p = $request->get($k, $v[1]);
                    break;
                case XHPROF_UINT_PARAM:
                    $p = (int)$request->get($k, $v[1]);
                    break;
                case XHPROF_FLOAT_PARAM:
                    $p = (float)$request->get($k, $v[1]);
                    break;
                case XHPROF_BOOL_PARAM:
                    $p = (bool)$request->get($k, $v[1]);
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Invalid param type passed to %s : %s', __CLASS__, $v[0]));
            }
            
            if($p !== $v[1]) {
                $this->params[$k] = $p;
            }
        }
    }
    
    public function get($key)
    {
        return $this->params[$key];
    }
}
