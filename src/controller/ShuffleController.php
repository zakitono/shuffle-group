<?php

class ShuffleController extends Controller
{
    public function index()
    {
        //レンダリング
        //Controller.phpのrenderメソッドで処理する
        return $this->render([
            'groups' => [],
        ]);
    }

    public function create()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundEx();
        }

        $groups = [];
        //Employeeモデルの取得、Employeeモデル内でfetchAllNames処理する
        $employees = $this->databaseManager->get('Employee')->fetchAllNames();

        shuffle($employees);
        $cnt = count($employees);

        if ($cnt % 2 === 0) {
            $groups = array_chunk($employees, 2);
        } else {
            $extra = array_pop($employees);
            $groups = array_chunk($employees, 2);
            array_push($groups[0], $extra);
        }

        return $this->render([
            'groups' => $groups,
        ], 'index');
    }
}
