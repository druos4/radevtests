<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestsRequest;
use App\Models\Test;
use App\Services\TestService;
use Illuminate\Http\Request;
use App\Models\User;

class TestsController extends Controller
{
    private $service;

    public function __construct(TestService $testService)
    {
        $this->service = $testService;
    }

    public function index(Request $request)
    {
        $result = $this->service->getItemsForAdmin($request);
        $locations = $this->service->getLocationsList();
        $managers = $this->service->getManagersList();
        $tests = $result['items'];
        $filter = $result['filter'];
        $breadcrumbs = [
            ['title' => 'Админпанель', 'url' => '/admin',],
            ['title' => 'Тесты', 'url' => '',],
        ];
        return view('admin.tests.index', compact('tests','breadcrumbs','locations','managers','filter'));
    }

    public function create()
    {
        if(auth()->user()->hasRole('admin')){
            $users = User::orderBy('name','asc')->get();
            $breadcrumbs = [
                ['title' => 'Админпанель', 'url' => '/admin',],
                ['title' => 'Тесты', 'url' => '/admin/tests',],
                ['title' => 'Создание теста', 'url' => '',],
            ];
            return view('admin.tests.create',compact('users','breadcrumbs'));
        } else {
            return redirect()->route('admin.tests.index')->with('warning','У вас не достаточно прав!');
        }
    }

    public function store(StoreTestsRequest $request)
    {
        $id = $this->service->storeItem($request);

        return redirect()->route('admin.tests.index')->with('success','Тест ['.$id.'] создан!');
    }

    public function edit(Test $test)
    {
        $users = User::orderBy('name','asc')->get();
        $breadcrumbs = [
            ['title' => 'Админпанель', 'url' => '/admin',],
            ['title' => 'Тесты', 'url' => '/admin/tests',],
            ['title' => 'Редактирование теста', 'url' => '',],
        ];
        return view('admin.tests.edit', compact( 'test','users','breadcrumbs'));
    }

    public function criteria(Request $request)
    {
        $criteria = $this->service->getCriteria($request->get('mark'));
        return response()->json(['criteria' => $criteria]);
    }

    public function update(Request $request, Test $test)
    {
        $id = $this->service->updateItem($request, $test);
        return redirect()->route('admin.tests.index')->with('success','Тест ['.$id.'] обновлен!');
    }

    public function destroy(Test $test)
    {
        $this->service->deleteItem($test);
        return response()->json(['id' => $test->id]);
    }

}
