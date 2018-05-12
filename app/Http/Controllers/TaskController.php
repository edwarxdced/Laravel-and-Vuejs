<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task; 
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $task = Task::orderBy('id','DESC')->paginate(3);
        return [
            'paginate' => [
                'total'        => $task->total(),
                'current_page' => $task->currentPage(),
                'per_page'     => $task->perPage(),
                'last_page'    => $task->lastPage(),
                'from'         => $task->firstItem(),
                'to'           => $task->lastItem(),
                'total'        => $task->total(),
            ],
            'tasks' => $task
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'keep' => 'required'
        ]);
        Task::create($request->all());
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'keep' => 'required'
        ]);

        Task::find($id)->update($request->all());
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}
