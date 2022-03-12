<?php

namespace App\Services;

use App\Blog;
use App\BlogCategory;
use App\BlogCategoryIn;
use App\BlogComment;
use App\BlogLang;
use App\BlogLike;
use App\BlogRecomend;
use App\BlogView;
use App\MapDistrictGk;
use App\MapGk;
use App\MapGkMarker;
use App\MapGkSeo;
use App\MapMarker;
use App\Models\Test;
use Carbon\Carbon;
use voku\helper\HtmlDomParser;

class TestService
{
    const PAGINATION_ADMIN = 20;
    private $id;

    public function __construct()
    {
    }

    /**
     * @param int $id
     */
    private function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    private function getId()
    {
        return $this->id;
    }

    /**
     * Сохранение нового теста
     * @return int
     */
    public function storeItem($request)
    {
        $request['day'] = str_replace('T',' ',$request->get('day')).':00';
        $request['user_id'] = (empty($request->get('user_id'))) ? null : $request->get('user_id');
        $request['criteria'] = $this->getCriteria($request->get('mark'));
        $test = Test::create($request->all());
        return $test->id;
    }

    /**
     * Опредение критерия на основе оценки
     * @param int $mark
     * @return int
     */
    public function getCriteria($mark = null)
    {
        $arrCriteria = config('tests.criteria');
        krsort($arrCriteria);
        if(!empty($mark)){
            foreach($arrCriteria as $key => $val){
                if($mark >= $key){
                    return $val;
                }
            }
        }
        return 0;
    }


    /**
     * Получение списка тестов и активного фильтра для админки
     * @return array
     */
    public function getItemsForAdmin($request = [])
    {
        $query = Test::with('manager');
        if (!empty($request['id'])) {
            $query->where('id', $request['id']);
        }
        if (!empty($request['mark'])) {
            $query->where('mark', $request['mark']);
        }
        if (!empty($request['criteria'])) {
            $query->where('criteria', $request['criteria']);
        }
        if (!empty($request['fio'])) {
            $query->where('fio', 'LIKE', '%'.$request['fio'].'%');
        }
        if (!empty($request['location'])) {
            $query->where('location',$request['location']);
        }
        if (!empty($request['manager'])) {
            $query->where('user_id',$request['manager']);
        }
        if (!empty($request['day'])) {
            $query->where('day','>=',$request['day'].' 00:00:00')->where('day','<=',$request['day'].'23:59:59');
        }

        $items = $query->orderBy('id', 'desc')->paginate($this::PAGINATION_ADMIN);
        return ['items' => $items, 'filter' => $request];
    }

    public function getLocationsList()
    {
        $items = Test::select('location')->groupBy('location')->orderBy('location','asc')->pluck('location');
        return $items;
    }

    public function getManagersList(){
        $items = [];
        $res = Test::select('user_id')->with('manager')->groupBy('user_id')->get();
        if(!empty($res)){
            foreach($res as $r){
                if(!empty($r->manager)){
                    $items[$r->user_id] = $r->manager->name;
                }
            }
        }
        return $items;
    }

    /**
     * Удаление теста
     * @param object $test
     */
    public function deleteItem($test)
    {
       $test->delete();
    }


    /**
     * Сохранение теста
     * @param object $test
     * @param object $request
     * @return int
     */
    public function updateItem($request, $test)
    {
        if(auth()->user()->hasRole('manager')){
            $test->update([
                'mark' => $request->get('mark'),
                'criteria' => $this->getCriteria($request->get('mark')),
                'user_id' => ($test->mark != $request->get('mark')) ? auth()->id() : $test->user_id,
            ]);
        } else {
            $request['day'] = str_replace('T',' ',$request->get('day'));
            if(strlen($request['day']) == 16){$request['day'].=':00';}
            $request['user_id'] = (empty($request->get('user_id'))) ? null : $request->get('user_id');
            $request['criteria'] = $this->getCriteria($request->get('mark'));
            $test->update($request->all());
        }
        return $test->id;
    }

}
