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

class File extends AbstractStorage implements StorageInterface
{
    protected $suffix = 'xhprof';
    
    public function __construct($options = array())
    {
        if(!isset($options['path'])) {
            $options['path'] = ini_get("xhprof.output_dir");
            if(empty($options['path'])) {
                throw new \RuntimeException('Please specify directory location for XHProf runs.');
            }
        }
        
        parent::__construct($options);
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
        $filename = $this->_getFilename($run_id, $namespace);
        
        if(!file_exists($filename)) {
            throw new \RuntimeException(sprintf('Could not find file %s', $filename));
        }
        
        return unserialize(file_get_contents($filename));
    }
    
    /**
     * Save XHProf data for a profiler run of specified type.
     * 
     * @param Mixed $data
     * @param String $type
     * @param Mixed $run_id
     */
    public function save($data, $namespace, $run_id = null)
    {
        $data = serialize($data);
        
        if($run_id === null) {
            $run_id = $this->_getId($namespace);
        }
        
        $filename = $this->_getFilename($run_id, $namespace);
        $file = fopen($filename, 'w');
        
        if($file) {
            fwrite($file, $data);
            fclose($file);
        } else {
            throw new \RuntimeException(sprintf('Could not open %s', $filename));
        }
        
        return $run_id;
    }
    
    protected function _getFilename($run_id, $namespace)
    {
        $file = sprintf('%s.%s.%s', $run_id, $namespace, $this->suffix);
        
        if(isset($this->options['path']) && !empty($this->options['path'])) {
            $file = $this->options['path'] . '/' . $file;
        }
        
        return $file;
    }
}