<?php

namespace App\Http\Controllers;
use App\Models\EmployeeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ListController extends Controller
{
    /**
     * Вывод списка постов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = EmployeeList::all();

        return view('list', ['employees' => $employees]);
    }

    /**
     * Сохранение новой записи
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:50',
            'position' => 'required|max:20',
            'date' =>'required',
            'salary' => 'required|max:9999',
            'boss' => 'required|max:99999'
        ]);



        $employee = EmployeeList::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'position' => $request->position,
           'date' => $request->date,
           'salary' => $request->salary,
           'boss' => $request->boss,
            'image'=>$request->image
        ]);


        return response()->json(['code'=>200, 'message'=>'Запись успешно создана','data' => $employee], 200);

    }





    /**
     * Вывод определенного поста
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = EmployeeList::find($id);

        return response()->json($employee);
    }

    /**
     * Удаление поста из базы данных
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = EmployeeList::find($id)->delete();

        return response()->json(['success'=>'Запись успешно удалена']);
    }
}
