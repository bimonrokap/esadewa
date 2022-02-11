<?php
namespace App\Repositories\Datatable;

use Carbon\Carbon;
use Request;

class DatatableHelper {

    protected $builder;
    protected $total;
    protected $constant = ['check', 'no'];
    protected $no;
    protected $softDeleted = false;
    private $id = 'id';

    /**
     * DT columns definitions container (add/edit/remove/filter/order/escape).
     *
     * @var array
     */
    protected $columnDef = [
        'column'           => [], // Colom Value
        'filter'           => [], // Filter
        'addFilter'        => [], // Add Filter
        'defaultAction'    => [], // Default Action
        'constraintFilter' => [], // Constraint Filter ,[match, like, date]
    ];

    /**
     * Create datatable from Eloquent Builder
     *
     * @param $builder
     * @return $this
     */
    public function create($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Set filter for data status
     *
     * @return $this
     */
    public function setDataStatus()
    {
        if (Request::has('data-status'))
        {
            $dataStatus = Request::input('data-status');

            switch ($dataStatus)
            {
                case 99:
                    $this->builder->onlyTrashed();
                    break;
                case 'all':
                    $this->builder->withTrashed();
                    break;
            }
        }

        return $this;
    }

    public function setSoftDeleted($option){
        $this->softDeleted = $option;
        return $this;
    }

    /**
     * Set id
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Edit Column
     *
     * @param $index
     * @param $func
     * @return $this
     */
    public function editColumn($index, $func)
    {
        $this->columnDef['column'][ $index ][] = $func;

        return $this;
    }

    /**
     * Set default Action
     *
     * @param array $action
     * @param array $setting
     * @return $this
     */
    public function defaultAction($action = array(), $setting = array())
    {
        if(empty($action)){
            $this->columnDef['column']['action'][] = function ($daa) {
                return '';
            };
        }else{
            foreach ($action as $row)
            {
                $this->columnDef['column']['action'][] = $this->getDefaultAction($row, $setting);
            };
        }

        return $this;
    }

    /**
     * For add filter
     *
     * @param $index
     * @param $func
     * @return $this
     */
    public function addFilter($index, $func)
    {
        $this->columnDef['addFilter'][] = ['index' => $index, 'content' => $func];

        return $this;
    }

    /**
     * For add filter
     *
     * @param $index
     * @param $func
     * @return $this
     */
    public function filterColumn($index, $func)
    {
        $this->columnDef['filter'][] = ['index' => $index, 'content' => $func];

        return $this;
    }

    /**
     * Set Filter Constraing for default Filter
     *
     * @param $index
     * @param $constraint
     * @return $this
     */
    public function filterConstraint($index, $constraint = null)
    {
        if(is_array($index)){
            foreach ($index as $key => $row){
                $this->columnDef['constraintFilter'][ $key ] = $row;
            }
        } else {
            $this->columnDef['constraintFilter'][ $index ] = $constraint;
        }

        return $this;
    }

    /**
     * Mare function for generate json datatable
     *
     * @param bool $array
     * @return \Illuminate\Http\JsonResponse
     */
    public function make($array = true)
    {
        $data = [
            'data'            => $this->getData(),
            'recordsTotal'    => $this->total,
            'recordsFiltered' => $this->total,
            'draw'            => intval(Request::input('draw'))
        ];

        if ($array)
        {
            return $data;
        }

        return response()->json($data);
    }

    private function isSoftDeleteAndTrashed($data){
        if($this->softDeleted && $data->trashed()){
            return true;
        }

        return false;
    }

    private function getDefaultAction($action, $setting)
    {
        $setting['param-model'] = isset($setting['param-model']) ? $setting['param-model'] : 'id';
        switch ($action)
        {
            case 'show':
                $action = function ($data) use ($setting)
                {
                    //if (!$data->trashed())
                    //{
                        return
                            '<a href="' . route($setting['route'] . '.show', $data->id) . '" class="btn btn-primary btn-xs m-btn m-btn--icon m-btn--icon-only tooltips ajaxify" title="Detail ' . $setting['title'] . '">
                                <i class="la la-eye"></i>
                            </a> ';
                    //}
                };

                return $action;
                break;
            case 'edit':
                $action = function ($data) use ($setting)
                {
                    //if (!$data->trashed())
                    //{
                        return
                            '<a href="' . route($setting['route'] . '.edit',$data->id) . '" class="btn btn-info btn-xs m-btn m-btn--icon m-btn--icon-only tooltips ajaxify" title="Edit ' . $setting['title'] . '">
                                <i class="la la-pencil"></i>
                            </a> ';
                    //}
                };

                return $action;
                break;
            case 'delete':
                $action = function ($data) use ($setting)
                {
                    //if (!$data->trashed())
                    //{
                        return
                            '<a href="' . route($setting['route'] . '.destroy', $data->id) . '" class="btn btn-danger btn-delete btn-xs m-btn m-btn--icon m-btn--icon-only tooltips" title="Delete ' . $setting['title'] . '">
                                <i class="la la-trash"></i>
                            </a> ';
                    //}
                };

                return $action;
                break;
            case 'restore':
                $action = function ($data) use ($setting)
                {
                    //if ($data->trashed())
                    //{
                        return
                            '<a title="Restore Data ' . $setting['title'] . '" href="' . route($setting['route'] . '.restore', ['id' => $data->id]) . '" class="tooltips btn btn-icon-only green-meadow">
                                <i title="Aktif" class="fa fa-recycle"></i>
                            </a> ';
                    //}
                };

                return $action;
                break;
            case 'destroy':
                $action = function ($data) use ($setting)
                {
                    //if ($data->trashed())
                    //{
                        return
                            '<a title="Delete Permanent Data ' . $setting['title'] . '" href="' . route($setting['route'] . '.forcedestroy', ['id' => $data->id]) . '" class="btn btn-icon-only grey-gallery tooltips">
                            <i class="fa fa-times"></i>
                        </a> ';
                    //}
                };

                return $action;
                break;
        }
    }

    /**
     * Get total number from record
     *
     * @return mixed
     */
    private function totalRecords()
    {
        $this->total = $this->builder->count();

        return $this->total;
    }

    private function setupFilter()
    {
        $setColumn = collect($this->columnDef['filter'])->pluck('index')->toArray(); // Index Set Filter

        $tmpColumn = collect(Request::input('columns'))->where('searchable', "true");
        $column = $tmpColumn->pluck('search.value','data');
        $columnName = $tmpColumn->pluck('name', 'data');

        $setFilter = collect($this->columnDef['filter'])->pluck('index')->toArray();
        foreach ($column as $key => $value)
        {
            if(!in_array($key, $setFilter)) { // Jika Tidak Di set
                // Jika Ada yang Di cari
                if ($value != '')
                {
                    if (!in_array($key, $setColumn))
                    {
                        $data = $columnName[$key] != '' ? $columnName[$key] : $key;

                        if (isset($this->columnDef['constraintFilter'][ $key ])) // Jika Ada Constrain
                        {
                            $constraint = $this->columnDef['constraintFilter'][ $key ];

                            if ($constraint == 'daterange')
                            {
                                $between = explode(' - ', $value);
                                $this->builder->whereRaw('DATE(' . $data . ') between \'' . @$between[0] . '\' AND \'' . @$between[1] . '\'');
                            } else if ($constraint == 'match')
                            {
                                $this->builder->where($data, $value);
                            } else if ($constraint == 'date') {
                                $value = Carbon::parse($value)->toDateString();
                                $this->builder->whereDate($data, $value);
                            }
                        } else
                        {
                            $this->builder->where($data, 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        }

        foreach ($this->columnDef['filter'] as $row)
        {
            if (isset($column[$row['index']]) && $column[$row['index']] != '')
            {
                $this->builder = $row['content']($this->builder, $column[$row['index']]);
            }
        }

        foreach ($this->columnDef['addFilter'] as $row)
        {
            if (Request::input($row['index']) != '')
            {
                $this->builder = $row['content']($this->builder, Request::input($row['index']));
            }
        }
    }

    private function setupOrder()
    {
        $orderColumn = Request::input('columns.' . Request::input('order.0.column') . '.name') != '' ? Request::input('columns.' . Request::input('order.0.column') . '.name') : Request::input('columns.' . Request::input('order.0.column') . '.data');
        $this->builder->orderBy($orderColumn, Request::input('order.0.dir'));
    }

    private function setupPaging()
    {

        $iTotalRecords = $this->totalRecords();
        $iDisplayLength = intval(Request::input('length'));
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval(Request::input('start'));
        $this->no = 1 + $iDisplayStart;

        $this->builder
            ->limit($iDisplayLength)
            ->offset($iDisplayStart);
    }

    private function getData()
    {

        $this->setupFilter();
        $this->setupPaging();
        $this->setupOrder();

        $result = $this->builder
            ->addSelect([$this->id])
            ->get();

        $data = [];
        foreach ($result as $row)
        {
            $value = $this->setupRow($row);

            $data[] = $value;
        }

        return $data;
    }

    private function setupRow($row)
    {
        $data = $this->setupColumnRow($row); // Setup column manual if exist
        $data = $this->setupConstantRow($row, $data);
        $data = $this->setupDataRow($row, $data);

        return $data;
    }

    private function setupColumnRow($row)
    {
        $data = [];
        foreach ($this->columnDef['column'] as $key => $value)
        {
            if (is_array($value))
            {
                $tmp = '';
                foreach ($value as $val)
                {
                    if (!is_null($val))
                    {
                        $tmp .= $val($row);
                    }
                }

                $data[ $key ] = $tmp;
            } else
            {
                $data[ $value['index'] ] = $value['content']($row);
            }
        }

        return $data;
    }

    /**
     * Setup Constant Row
     *
     * @param $row
     * @param $data
     * @return mixed
     */
    private function setupConstantRow($row, $data)
    {
        // Check if request datatable contain constant
        $column = collect(Request::input('columns'))->pluck('data')->intersect($this->constant);
        $collect = collect($data)->keys(); // Get record before who set first

        $diff = $column->diff($collect); // Get Constant who don't set manual

        foreach ($diff as $value)
        {
            $data[ $value ] = $this->getDefaultConstant($value, $row);
        }

        return $data;
    }

    /**
     * Setup data default
     *
     * @param $row
     * @param $data
     * @return mixed
     */
    private function setupDataRow($row, $data)
    {
        $collect = collect($data)->keys(); // Get data who set manual
        $diff = collect(Request::input('columns'))->pluck('data')->diff($collect); // Get data who not set yet

        foreach ($diff as $value)
        {
            $data[ $value ] = $row->$value == null || '' ? '<i class="empty-text">empty</i>' : $row->$value;
        }

        return $data;
    }

    /**
     * Default Constant
     *
     * @param $col
     * @param $data
     * @return string
     */
    private function getDefaultConstant($col, $data)
    {
        $html = '';
        switch ($col)
        {
            case 'check':
                $html = '<input type="checkbox" name="id[]" value="' . $data->id . '">';
                break;

            case 'no':
                $html = $this->no;
                $this->no ++;
                break;
        }

        return $html;
    }
}