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

class Redis extends AbstractStorage implements StorageInterface
{
    /**
     * @var \Redis
     */
    protected $redis;
    
    /**
     *
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }
    
    /**
     * Returns XHProf data given a run id ($run_id) of a given namespace
     * 
     * @param Mixed $run_id
     * @param String $namespace
     * @return Mixed
     */
    public function get($run_id, $namespace)
    {
        $key = $this->_getKey($run_id, $type);
        
        $data = $this->redis->get($key);
        
        if(!$data) {
            throw new \RuntimeException(sprintf('Could not find key %s', $key));
        }
        
        return unserialize($data);
    }
    
    /**
     * Save XHProf data for a profiler run of specified namespace.
     * 
     * @param Mixed $data
     * @param String $namespace
     * @param Mixed $run_id
     */
    public function save($data, $namespace, $run_id = null)
    {
        $data = serialize($data);
        
        if($run_id === null) {
            $run_id = $this->_getId($namespace);
        }
        
        $key = $this->_getKey($run_id, $namespace);
        
        if(!$this->redis->set($key, $data)) {
            throw new \RuntimeException(sprintf('Could not insert %s', $key));
        }

        return $run_id;
    }
    
    protected function _getKey($run_id, $namespace)
    {
        return sprintf('xhprof:%s:%s', $run_id, $namespace);
    }
}