<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permisson;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRole(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::all();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '"  class=" btn btn-danger btn-delete-role">Xóa</a>';
                    $btn .= '  <a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-success btn-edit">Sửa</a>';
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('updated_at', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at));
                })
                ->rawColumns(['action', 'created_at', 'updated_at'])
                ->make(true);

        }
    }

    public function index()
    {
        $permissions = Permisson::all()->groupBy('group');
        return view('be.roles.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'permission_ids' => 'required',
        ],
            [
                'name.required' => 'Tên không được để trống',
                'name.unique' => 'Tên đã tồn tại',
                'display_name.required' => 'Tên hiển thị không được để trống',
                'permission_ids.required' => 'Quyền không được để trống',
            ]);
        $role = Role::query()->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'group' => $request->group,
            'guard_name' => 'web'
        ]);
        $role->permissions()->attach($request->permission_ids);

        return response()->json([
            'status' => 'success', // 'success', 'error
            'success' => true,
            'message' => 'Thêm thành công'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permisson::all()->groupBy('group');
        return response()->json([
            'status' => 'success', // 'success', 'error
            'success' => true,
            'role' => $role,
            'permission' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
            'permission_ids' => 'required',
        ],
            [
                'name.required' => 'Tên không được để trống',
                'name.unique' => 'Tên đã tồn tại',
                'display_name.required' => 'Tên hiển thị không được để trống',
                'permission_ids.required' => 'Quyền không được để trống',
            ]);
        $role = Role::query()->findOrFail($id);
        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'group' => $request->group,
            'guard_name' => 'web'
        ]);
        $role->permissions()->sync($request->permission_ids);
        return response()->json([
            'status' => 'success', // 'success', 'error
            'success' => true,
            'message' => 'Cập nhật thành công'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::query()->where('id', $id)->delete();
        return response()->json([
            'status' => 'success', // 'success', 'error
            'success' => true,
            'message' => 'Xóa thành công'
        ]);
    }
}
