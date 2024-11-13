<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kegiatan;
use App\Models\MasterKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid)
    {
        $aset = Aset::findOrFail($uuid); // Ensure the UUID is correctly passed
        $kegiatan = Kegiatan::with(['masterKegiatan', 'user'])
            ->where('id_aset', $aset->id)->latest('created_at')->paginate(10);
        $masterKegiatan = MasterKegiatan::all();

        return view('kegiatan.index', compact('aset', 'kegiatan', 'masterKegiatan'));
    }


    public function store(Request $request, $uuid)
    {
        $aset = Aset::where('id', $uuid)->firstOrFail();

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'id_master_kegiatan' => 'required|exists:master_kegiatans,id',
            'custom_kegiatan' => 'nullable|string|required_if:is_custom,1',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password tidak valid!'],
            ]);
        }

        // Get the selected MasterKegiatan
        $masterKegiatan = MasterKegiatan::findOrFail($request->id_master_kegiatan);

        // Create kegiatan with proper handling of custom_kegiatan
        Kegiatan::create([
            'id_aset' => $aset->id,
            'id_user' => $user->id,
            'id_master_kegiatan' => $masterKegiatan->id,
            'custom_kegiatan' => $masterKegiatan->is_custom ? $request->custom_kegiatan : null,
        ]);

        return redirect()->route('kegiatan.index', ['uuid' => $aset->id])
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }


    public function validateUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password tidak valid.'],
            ]);
        }
        return true;
    }
}
