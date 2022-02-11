<?php

namespace App\Http\Controllers\Admin\Help;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use App\Repositories\Permission\Permission;

class FaqController extends Controller
{

    private $route = 'admin.help.faq';
    private $config, $layout;
    private $title = 'FAQ';
    private $permission = 'help-faq';

    public function __construct()
    {
        $this->model = new Faq();
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
            'permission'=> $this->permission
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        $data['faqs'] = Faq::orderBy('order')->get();

        return view($this->layout . '.index', $data);
    }
}
