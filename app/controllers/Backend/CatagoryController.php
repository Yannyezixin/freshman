<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Catagory as CatagoryModel;
use Validator;
use Input;
use Redirect;

class CatagoryController extends BaseController {

    /**
     * Backend Catagory index
     *
     * @return Response
     */
    public function showcatagory(){

        /**
         * take the catagory information
         */
        foreach(CatagoryModel::all() as $catagory){

            $catagories[] = array(
                            'id'=> $catagory['id'],
                            'catagory' => $catagory['catagory']
                        );
        }

        return View::make('Backend.Catagory.Catagory_part',array('page' => 'catagory',
            'catagories' => $catagories));
    }

    /**
     * Backend New Catagory
     *
     * @return Redirect
     */
    public function newcatagory()
    {
        $validator = Validator::make(Input::all(),array(
            'catagory' => 'required|min:4|max:20'
        ));

        if($validator->fails()){
            return Redirect::route('BackendShowCatagory')
                ->withInput()
                ->withErrors($validator);
        }

        $catagory = Input::get('catagory');
        if (CatagoryModel::where('catagory','=',$catagory)->count() !== '0'){

            return Redirect::route('BackendShowCatagory')
                    ->with(array(
                        'error' => "$catagory 已经存在，请选择其他名字"
                    ));
        }
        $catagory = new CatagoryModel(array('catagory'=>$catagory));
        $catagory->save();

        return Redirect::route('BackendShowCatagory')
            ->with('success','目录创建成功');
    }

    /**
     * Backend Update Catagory
     *
     * @return Redirect
     */
    public function updatecatagory()
    {
        $catagory = CatagoryModel::find(Input::get('id'));

        $validator = Validator::make(Input::all(),array(
                'catagory' => 'required|min:4|max:20'
            ));
        if($validator->fails()){
            return Redirect::route('BackendShowCatagory')
                ->withInput()
                ->withErrors($validator);
        }

        $catagory->catagory = Input::get('catagory');
        $catagory->save();

        return Redirect::route('BackendShowCatagory')
            ->with('success','栏目名修改成功');
    }

    /**
     * Backend delete catagory
     *
     * @return Redirect
     */
    public function deletecatagory()
    {
        $catagory = CatagoryModel::find(Input::get('id'));

        $catagory->delete();

        return Redirect::route('BackendShowCatagory')
            ->with('success','栏目删除成功');
    }
}