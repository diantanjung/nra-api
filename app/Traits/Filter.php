<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

/**
 * FILTER QUERY PARAMS
 *
 * @param (boolean) active
 *  The returned resources active (deleted_at) status
 *      TRUE  => only active
 *      FALSE => only inactive
 *      NULL  => active AND inactive
 *
 * @param (boolean) ascending
 *  Query resource in ascending order
 *      TRUE         => ascending
 *      FALSE | NULL => descending
 *
 * @param (int) limit
 *  Number of results
 *
 * @param (string) orderBy
 *  Column by which we order the query
 *
 * @param (string) orderDir
 *  Order direction for the query (ASC|DESC)
 *
 * @param (array) query
 *
 *
 * @param (array) rules
 *
 *
 * @param (int) start
 *  The nr of the element in order from which we begin the query
 *
 */

trait Filter
{

    private static $supportedRules = ['exact', 'contains', 'between', 'boolean', 'different', 'null'];
    private static $defaultRule = 'contains';


    private $active;

    private $search;
    private $rules;
    private $orderBy;
    private $orderDir;

    private $page;

    private $query;



    // Check if the model has a custom order column by default

    private function defaultOrderBy(){
        return property_exists($this, 'defaultOrderBy') ? $this->defaultOrderBy : 'id';
    }



    // Check if the model has a custom order direction by default

    private function defaultOrderDir(){
        return property_exists($this, 'defaultOrderDir') ? $this->defaultOrderDir : 'ASC';
    }


    // Check if the model has custom search rules by default

    private function defaultSearchRules() {
        return property_exists($this, 'defaultSearchRules') ? $this->defaultSearchRules : [];
    }




    /*
     * Return the search rule for that attribute
     * Used to decide what type of search query we use for the giver attr
     *
     * Supported rules are stored in self::$supportedRules
     * Filter default rule is in self::$defaultRule
     *
     * We can define default search rules inside our models with the $defaultSearchRules attr
     * It has to be an associative array $attribute => rule format
     *
     * If the request has a search rule we use that
     * Otherwise fall back to model default for that attribute
     * Otherwise fall back to filter default
     *
     */

    private function getRuleForAttribute($attr) {


        // the default search rule
        $rule = self::$defaultRule;


        // if the model has a default search rule for that attribute
        if(array_has($this->defaultSearchRules(), $attr)){

            // and if the filter supports that rule
            if(in_array($this->defaultSearchRules[$attr], self::$supportedRules)){

                // overwrite the filters default with the models default
                $rule = $this->defaultSearchRules[$attr];
            }
        }

        // if the request has a search rule for that attribute
        if(array_has($this->rules, $attr)){

            // and if the filter supports that rule
            if(in_array($this->rules[$attr], self::$supportedRules)){

                // overwrite the filters and models default with the request
                $rule = $this->rules[$attr];
            }
        }


        // the search rule for the requested attribute
        return $rule;
    }


    private function setActiveStatus($status){
        $this->active = $status;
    }


    private function setSearch($search, $rules = []) {

        $search = json_decode($search, true);

        $this->setRules($rules);

        $this->search = [];
        // Check if the search query specifies the deleted/active status
        if(array_key_exists('active', $search)){

            $this->setActiveStatus($search['active']);

            // remove that to avoid querying it again by a different rule
            unset($search['active']);
        }
        foreach($search as $attribute => $query) {

            //if($query) {
            $path = $attribute;

            $attrArray = explode(".", $attribute);
            $attr = array_values(array_slice($attrArray, -1))[0];

            $relationship = (count($attrArray) == 1) ? 'self' : preg_replace('/'.$attr.'$/', '', $attribute);
            $relationship = rtrim($relationship,".");

            $model = 'self';

            if($relationship != 'self'){
                $model = array_values(array_slice($attrArray, -2))[0];
            }


            $this->search[$relationship][] = [
                'query'        => $query,
                'rule'         => $this->getRuleForAttribute($attribute),
                'path'         => $path,
                'attribute'    => $attr,
                'model'        => $model
            ];


            //}
        }
    }



    private function setRules($rules)
    {
        if ($rules) {
            $this->rules = json_decode($rules, true);
        }
    }

    private function setOrderBy($orderBy = 'id') {
        $this->orderBy = $orderBy;
    }

    private function setOrderDir($orderDir='ASC'){
        $this->orderDir = $orderDir;
    }


    private function getOrderBy() {
        return isset($this->orderBy) ? $this->orderBy : $this->defaultOrderBy();
    }


    private function getOrderDir() {
        return isset($this->orderDir) ? $this->orderDir : $this->defaultOrderDir();
    }


    private function orderResults() {
        $this->query->orderBy($this->getOrderBy(), $this->getOrderDir());
        return $this;
    }

    private function activeStatus(){
        if(isset($this->active)){

            if($this->active == '0')
                $this->query->onlyTrashed();
        } else {
            $this->query->withTrashed();
        }

        return $this;
    }

    public function containsMatch($attribute, $query)
    {
        $this->query->where($attribute, 'like', '%' . $query . '%');
    }

    public function betweenMatch($attribute, $query)
    {
        $this->query->whereBetween($attribute,$query);
    }

    public function booleanMatch($attribute,$query)
    {
        $this->query->where($attribute,$query);
    }


    /*
     * Set the query where options based on the requests
     * query and rule parameters
     */
    private function search(){

        /*
         * Check if the request specified any search criteria
         */
        if(isset($this->search)){
            foreach($this->search as $relationship => $params){

                /*
                 * Check if the requested search parameter group
                 * contains internal or external attribute
                 * (search in self or related model)
                 */
                if($relationship == 'self'){
                    foreach($params as $q){
                        $query = $q['query'];
                        $rule = $q['rule'];
                        $attribute = $q['attribute'];
                        if($query==null && !$rule){
                            $rule = 'null';
                        }



                        if($query && $rule!="ignore"){
                            switch ($rule) {
                                case 'exact':
                                    $this->query->where($attribute, $query);
                                    break;

                                case 'contains':
                                    $this->query->where($attribute, 'like', '%' . $query . '%');
                                    break;

                                case 'between':
                                    $query = array_values($query);
                                    if(in_array ($attribute, $this->dates)){
                                        $this->query->where($attribute, ">=", \Carbon\Carbon::parse($query[0]." 00:00:00")->toDateTimeString())
                                                    ->where($attribute, '<', \Carbon\Carbon::parse($query[1]." 23:59:59")->toDateTimeString());
                                    } else {
                                        $this->whereBetween($attribute, $query);
                                    }
                                    break;

                                case 'boolean':
                                    $this->booleanMatch($attribute, $query);
                                    break;

                                case 'different':
                                    if(is_array($query)){
                                        $this->query->whereNotIn($attribute, $query);
                                    } else {
                                        $this->query->where($attribute, '<>' ,$query);
                                    }
                                    break;
                            }

                        } else {
                            if($rule == 'null') {
                                $this->query->whereNull($attribute);
                            }
                        }

                    }
                } else {

                    /*
                     * In case of external parameter search
                     * we lazy load the relationship and
                     * include the search criteria
                     */
                    $this->query->with($relationship)->whereHas($relationship, function($queryHandler) use ($params)
                    {

                        foreach($params as $q){
                            $query = $q['query'];
                            $rule = $q['rule'];
                            $attribute = $q['attribute'];
                            if($query==null && !$rule){
                                $rule = 'null';
                            }

                            if($query && $rule!="ignore")
                            {
                                switch ($rule) {
                                    case 'exact':
                                        $queryHandler->where($attribute, $query);
                                        break;

                                    case 'contains':
                                        $queryHandler->where($attribute, 'like', '%' . $query . '%');
                                        break;

                                    case 'between':
                                      $query = array_values($query);
                                        if(in_array ($attribute, $this->dates)){
                                            $queryHandler->where($attribute, ">=", \Carbon\Carbon::parse($query[0]." 00:00:00")->toDateTimeString())
                                                        ->where($attribute, '<', \Carbon\Carbon::parse($query[1]." 23:59:59")->toDateTimeString());
                                        } else {
                                            $this->whereBetween($attribute, $query);
                                        }
                                        break;

                                    case 'boolean':
                                        $queryHandler->where($attribute, $query);
                                        break;

                                    case 'different':
                                        if(is_array($query)){
                                            $this->query->whereNotIn($attribute, $query);
                                        } else {
                                            $this->query->where($attribute, '<>' ,$query);
                                        }
                                        break;
                                }
                            } else {
                                if($rule == 'null') {
                                    $queryHandler->whereNull($attribute);
                                }
                            }

                        }
                    });
                }
            }

        }

        return $this;
    }

    public function scopeFilter($query, $filter)
    {

        $this->query = $query;

        $this->page = $filter->input('page', 1);


        // If the request has specified a search query
        // supports JSON key => value (attribute => query string) pair
        if($filter->has('query')){

            // If the request has specified the rules by what we should search
            // supports JSON key => value (attribute => rule string) pair
            $rules = $filter->has('rules') ? $filter->input('rules') : [];

            $this->setSearch($filter->input('query'), $rules);
        }


        // If the request has specified the column we order by
        if($filter->has('orderBy')){

            $orderByAttribute = $filter->input('orderBy');

            // If the specified column exists in our model
            if(\Schema::hasColumn($this->getTable(), $orderByAttribute)){

                $this->setOrderBy($filter->input('orderBy'));

                // If the request has specified the order direction
                if($filter->has('orderDir')){
                    $this->setOrderDir($filter->input('orderDir'));

                    // The request can also specify ascending ordering
                    // by passing an 'ascending' parameter
                } else if($filter->has('ascending')) {
                    if($filter->input('ascending')){
                        $this->setOrderDir('ASC');
                    } else {
                        $this->setOrderDir('DESC');
                    }
                }
            }
        }


        /*
         * Check if the request has specified to retrieve active/trashed/both results
         * Overwrites the active query parameter
         */
        if($filter->has('active')){
            $this->setActiveStatus($filter->input('active'));
        }

        $this->activeStatus()
            ->search()
            ->orderResults();


        if ($filter->has('start')) {
            $this->query->skip($filter->input('start'));
        }

        return $this->query->paginate($filter->input('limit',10));

    }



}
