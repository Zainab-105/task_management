<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function DTFilters($request)
    {
        $filters = array(
            // 'draw'          =>  $request['draw'],
            'offset'        =>  isset($request['start']) ? $request['start'] : 0,
            'limit'         =>  isset($request['length']) ? $request['length'] : 25,
            'sort_column'   =>  (isset($request['order'][0]['column']) && isset($request['columns'][$request['order'][0]['column']]['data'])) ? $request['columns'][$request['order'][0]['column']]['data'] : 'created_at',
            'sort_order'    =>  isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'DESC',
            'search'        =>  isset($request['search']['value']) ? $request['search']['value'] : '',
        );
        return $filters;
    }
}
