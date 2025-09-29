<?php

namespace App\Http\Controllers;

use App\Models\Pengantar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PengantarController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $query = Pengantar::with(['resident', 'user']);

    switch ($user->role_id) {
        case 2: // User biasa
            $query->where('user_id', $user->id);
            break;

        case 3: // Kepala RT
            $query->whereHas('resident', function ($q) use ($user) {
                $q->where('rt', $user->rt)
                  ->where('rw', $user->rw);
            });
            break;

        case 4: // Kepala RW
            $query->whereHas('resident', function ($q) use ($user) {
                $q->where('rw', $user->rw);
            });
            break;

        default: // Admin, Kades, Staff
            // Bisa melihat semua
            break;
    }

        $pengantars = $query->latest()->paginate(10);
        return view('pages.pengantar.index', compact('pengantars'));
    }

   public function create()
{
    // Langsung tampilkan view, data user akan kita ambil di Blade
    return view('pages.pengantar.create');
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
             // DIUBAH: Cek ke tabel 'users', bukan 'residents'
            'resident_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|size:16',
            'purpose' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pengantar::create([
            'user_id' => Auth::id(),
            'resident_id' => $request->resident_id,
            'name' => $request->name,
            'NIK' => $request->NIK,
            'purpose' => $request->purpose,
            'date' => $request->date,
            'report_date' => Carbon::now()
        ]);

        return redirect()->route('pengantar.index')
            ->with('success', 'Surat pengantar berhasil diajukan!');
    }

     public function show(Pengantar $pengantar)
    {
        $pengantar->load('resident', 'user');
        return view('pages.pengantar.show', compact('pengantar'));
    }

    public function edit(Pengantar $pengantar)
    {
        $user = Auth::user();
        if ($user->role_id == 2 && $pengantar->user_id != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit pengajuan ini!');
        }
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat pengantar tidak dapat diedit karena sudah diproses!');
        }
        $residents = User::where('role_id', 2)->orderBy('name')->get(); // Menggunakan User
        return view('pages.pengantar.edit', compact('pengantar', 'residents'));
    }

    public function update(Request $request, Pengantar $pengantar)
    {
        // ... (fungsi update Anda, pastikan validasi 'resident_id' ke 'users,id') ...
        $validator = Validator::make($request->all(), [
            'resident_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|size:16'. $pengantar->id,
            'purpose' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today'
        ]);
        // ... sisa fungsi update
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $pengantar->update($request->only(['resident_id', 'name', 'NIK', 'purpose', 'date']));
        return redirect()->route('pengantar.index')->with('success', 'Surat pengantar berhasil diperbarui!');
    }

    public function destroy(Pengantar $pengantar)
    {
        // ... (fungsi destroy Anda) ...
        $user = Auth::user();
        if ($user->role_id == 2 && $pengantar->user_id != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus pengajuan ini!');
        }
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat tidak dapat dihapus!');
        }
        $pengantar->delete();
        return redirect()->route('pengantar.index')->with('success', 'Surat pengantar berhasil dihapus!');
    }

    public function processRT(Request $request, Pengantar $pengantar)
{
    $user = Auth::user();

    if ($user->role_id == 3) { // Kepala RT
        $resident = $pengantar->resident;
        if ($resident->rt != $user->rt || $resident->rw != $user->rw) {
            return redirect()->back()->with('error', 'Anda tidak berhak memproses pengajuan ini!');
        }
    }

    $request->validate([
        'status' => 'required|in:accepted,rejected',
        'notes' => 'nullable|string|max:500'
    ]);

    $pengantar->update([
        'status_rt' => $request->status,
        'notes_rt' => $request->notes
    ]);

    return redirect()->route('dashboard.rt')
        ->with('success', 'Status RT berhasil diupdate!');
}


    public function processRW(Request $request, Pengantar $pengantar)
{
    $user = Auth::user();

    if ($user->role_id == 4) { // Kepala RW
        $resident = $pengantar->resident;
        if ($resident->rw != $user->rw) {
            return redirect()->back()->with('error', 'Anda tidak berhak memproses pengajuan ini!');
        }
    }

    if ($pengantar->status_rt !== 'accepted') {
        return redirect()->back()->with('error', 'Surat harus disetujui RT dulu!');
    }

    $request->validate([
        'status' => 'required|in:accepted,rejected',
        'notes' => 'nullable|string|max:500'
    ]);

    $pengantar->update([
        'status_rw' => $request->status,
        'notes_rw' => $request->notes
    ]);

    return redirect()->route('dashboard.rw')
        ->with('success', 'Status RW berhasil diupdate!');
}


    public function dashboardRT()
    {
        $user = Auth::user();
        $query = Pengantar::with('resident', 'user');

        // Filter untuk Kepala RT (role_id 6)
        if ($user->role_id == 6) {
            $query->whereHas('resident', function($q) use ($user) {
                $q->where('rt', $user->rt)->where('rw', $user->rw);
            });
        }

        $pengantars = $query->latest()->get();
        return view('pages.pengantar.dashboard-rt', compact('pengantars'));
    }

    public function dashboardRW()
    {
        $user = Auth::user();
        $query = Pengantar::with('resident', 'user')->where('status_rt', 'accepted');

        // Filter untuk Kepala RW (role_id 3)
        if ($user->role_id == 3) {
            $query->whereHas('resident', function($q) use ($user) {
                $q->where('rw', $user->rw);
            });
        }

        $pengantars = $query->latest()->get();
        return view('pages.pengantar.dashboard-rw', compact('pengantars'));
    }


    public function getDetail($id)
    {
        $pengantar = Pengantar::with('resident', 'user')->findOrFail($id);
        
        $statusColors = [
            'pending' => 'warning',
            'accepted' => 'success',
            'rejected' => 'danger'
        ];
        
        $statusTexts = [
            'pending' => 'Menunggu',
            'accepted' => 'Disetujui',
            'rejected' => 'Ditolak'
        ];
        
        return response()->json([
            'name' => $pengantar->name,
            'NIK' => $pengantar->NIK,
            'resident_name' => $pengantar->resident->name ?? null,
            'purpose' => $pengantar->purpose,
            'date' => $pengantar->date->format('d/m/Y'),
            'created_at' => $pengantar->created_at->format('d/m/Y H:i'),
            'status_rt' => $pengantar->status_rt,
            'status_rt_text' => $statusTexts[$pengantar->status_rt],
            'status_rt_color' => $statusColors[$pengantar->status_rt],
            'notes_rt' => $pengantar->notes_rt,
            'status_rw' => $pengantar->status_rw,
            'status_rw_text' => $statusTexts[$pengantar->status_rw],
            'status_rw_color' => $statusColors[$pengantar->status_rw],
            'notes_rw' => $pengantar->notes_rw,
        ]);
    }
     
}