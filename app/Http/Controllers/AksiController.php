<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\MasterAction;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AksiController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Aksi", "view") !== true) {
            return view('error.403');
        }

        $data = MasterAction::all();

        return view('aksi.list', compact('data'));
    }
}
