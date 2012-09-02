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

/**
 * Storage interface for getting/saving a XHProf run.
 */
interface StorageInterface
{
    /**
     * Returns XHProf data given a run id ($run) of a given type
     * 
     * @param Mixed $run_id
     * @param String $namespace
     */
    public function get($run_id, $namespace);
    
    /**
     * Save XHProf data for a profiler run of specified type.
     * 
     * @param Mixed $data
     * @param String $namespace
     * @param Mixed $run_id
     */
    public function save($data, $namespace, $run_id = null);
}
