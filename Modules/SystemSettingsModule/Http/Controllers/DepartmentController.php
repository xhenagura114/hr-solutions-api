<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SystemSettingsModule\Entities\Department;

class DepartmentController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $root_departments = [];
        $departments = Department::all()->filter(function ($item) use (&$root_departments) {
            //return CEO and GENERAL MANAGER
            if ($item->parent_id == -1) {
                $root_departments[] = $item->toArray();
            }

            //return all other
            return $item->parent_id != -1;
        })->values()->all();
        return view('systemsettingsmodule::departments.index', compact('departments', 'root_departments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('systemsettingsmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'department_name' => 'required|min:2|max:50|unique:departments,name',
        ]);

        $department_name = $request->input('department_name');
        $parent_department_id = $request->input('parent_department_id');

        $department = new Department;
        $department->name = $department_name;

        if ($parent_department_id) {
            $department->parent_id = $parent_department_id;
        }
        $department->save();

        return redirect()->route('system-settings.departments.index')->with(['flash_message' => 'Department successfully created!']);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('systemsettingsmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $departments = Department::all();

        return view('systemsettingsmodule::departments.edit', compact('department', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $rules = 'required|min:2|max:50';

        $department = Department::findOrFail($id);

        if ($department->name != $request->input('department_name')) {
            $rules .= '|unique:departments,name';
        }

        $this->validate($request, [
            'department_name' => $rules,
        ]);


        $department->name = $request->input('department_name');

        if ($request->input('parent_department_id') != null) {
            $department->parent_id = $request->input('parent_department_id');
        } else {
            $department->parent_id = null;
        }
        $department->save();

        return redirect()->route('system-settings.departments.index')->with(['flash_message' => 'Department Updated']);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function createFromTree(Request $request)
    {
        $department_name = $request->input('name');
        $parent_id = $request->input('parent_id');
        $dep_color = Department::where('id', $parent_id)->first();
        $department = new Department;
        $department->name = $department_name;

        if ($parent_id) {
            $department->parent_id = $parent_id;
            $department->color = $dep_color->color;
        }

        $department->save();


        return response()->json(['status' => 'success', 'id' => $department->id, 'color' => $department->color]);

    }

    public function changeDepartmentColor(Request $request)
    {
        $id = $request->input('id');
        $color = $request->input('color');

        $tree = $this->fetch_recursive(Department::all()->toArray(), $id);
        foreach ($tree as $t) {

            try {
                Department::where('id', $t['id'])->update(['color' => $color]);
            } catch (\Exception $e) {
                //
            }
        }

        return response()->json(['status' => 'Success', 'tree' => $tree]);
    }


    public function fetch_recursive($src_arr, $currentid, $parentfound = false, $departments = array())
    {
        foreach ($src_arr as $row) {
            if ((!$parentfound && $row['id'] == $currentid) || $row['parent_id'] == $currentid) {
                $rowdata = array();
                foreach ($row as $k => $v)
                    $rowdata[$k] = $v;
                $departments[] = $rowdata;
                if ($row['parent_id'] == $currentid)

                    $departments = array_merge($departments, $this->fetch_recursive($src_arr, $row['id'], true));
            }
        }
        return $departments;
    }

    public function editDepartment(Request $request)
    {

        $id = $request->input('id');
        $name = $request->input('name');

        try {
            Department::where('id', $id)->update(['name' => $name]);
            $message = 'success';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(['status' => $message]);
    }

    public function deleteDepartment(Request $request)
    {
        $id = $request->input('id');

        try {
            Department::destroy($id);
            $message = 'success';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(['status' => $message]);
    }


}
