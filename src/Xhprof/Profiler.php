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
namespace Xhprof;

class Profiler
{
    /**
     * @var Array
     */
    protected $options = array();
    
    /**
     * @var String
     */
    protected $defaultStorage = '\Xhprof\Storage\File';
    
    /**
     * @var String
     */
    protected $defaultNamespace = 'xhprof';
    
    /**
     * @var \Xhprof\Storage\StorageInterface
     */
    protected $storage;
    
    /**
     * 
     * @param Array|\Zend\Config\Reader\ReaderInterfaceLnull $options
     * @throws \InvalidArgumentException
     */
    public function __construct($options = array())
    {
        if(!empty($options)) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Set XHProf profiler options
     * 
     * @param Array|\Zend\Config\Reader\ReaderInterface $options
     * @return Xhprof\Profiler
     * @throws \InvalidArgumentException
     */
    public function setOptions($options)
    {
        if(is_array($options)) {
            $this->options = $options;
        } elseif($options instanceof \Zend\Config\Reader\ReaderInterface) {
            $this->options = $options->toArray();
        } else {
            throw new \InvalidArgumentException('Options must be an array of parameters or Zend\Config\Reader\ReaderInterface object.');
        }
        
        if(!isset($this->options['storage'])) {
            $this->options['storage'] = $this->defaultStorage;
        }
        
        if(!isset($this->options['namespace'])) {
            $this->options['namespace'] = $this->defaultNamespace;
        }
        
        return $this;
    }
    
    /**
     * Set option
     * 
     * @param String $name
     * @param Mixed $value
     * @return Xhprof\Profiler
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        
        return $this;
    }
    
    /**
     * Get all options
     * 
     * @return Array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Get option by name
     * 
     * @param String $name
     * @return Mixed
     * @throws \RuntimeException
     */
    public function getOption($name)
    {
        if(isset($this->options[$name])) {
            return $this->options[$name];
        }
        
        throw new \RuntimeException(sprintf('Option %s does not defined.', $name));
    }
    
    /**
     *
     * @return Boolean
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }
    
    /**
     * Get storage
     * 
     * @return \Xhprof\Storage\StorageInterface
     */
    public function getStorage()
    {
        if(empty($this->storage)) {
            $className = $this->getOption('storage');

            $this->storage = new $className($this->getOptions());
        }
        
        return $this->storage;
    }
    
    public function start()
    {
        xhprof_enable();
    }
    
    public function stop()
    {
        $xhprof_data = xhprof_disable();
        
        $this->run_id = $this->getStorage()->save(
            $xhprof_data, 
            $this->getOption('namespace')
        );
        
        return $this->run_id;
    }
    
    public function save($data, $namespace = null)
    {
        if(empty($namespace)) {
            $namespace = $this->getOption('namespace');
        }
        $this->run_id = $this->getStorage()->save(
            $data, 
            $namespace
        );
        
        return $this->run_id;
    }
    
    public function get($run_id, $namespace = null)
    {
        if(empty($namespace)) {
            $namespace = $this->getOption('namespace');
        }
        
        return $this->getStorage()->get(
            $run_id, 
            $namespace
        );
    }
    
    public function getProfilerUrl($url = null)
    {
        if(empty($url)) {
            if(!isset($this->options['url'])) {
                throw new \RuntimeException('Please config profiler url.');
            }
            
            $url = $this->getOption('url');
        }
        
        return str_replace(array(
            '{namespace}', 
            '{run}'
        ), array(
            $this->getOption('namespace'), 
            $this->run_id
        ), $url);
    }
}