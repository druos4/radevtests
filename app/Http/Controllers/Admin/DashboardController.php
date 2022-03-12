<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;

class DashboardController extends Controller
{
    public function index()
    {
        //abort_unless(\Gate::allows('permission_access'), 403);
        $breadcrumbs = [
            ['title' => 'Админпанель', 'url' => '',],
        ];
        return view('admin.index', compact('breadcrumbs'));
    }

}
