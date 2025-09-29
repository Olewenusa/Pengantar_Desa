<?php

namespace App\Http\Controllers;

use App\Models\Pengantar;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
use Carbon\Carbon;

class PengantarController extends Controller
{
<<<<<<< HEAD
    public function index()
    {
        $user = Auth::user();
        $query = Pengantar::with('resident');

        // FILTER BERDASARKAN ROLE (LOGIC BARU)
        if ($user->role == 'User') {
            // User hanya lihat pengajuan yang dia buat sendiri
            $query->where('user_id', $user->id);
        } 
        elseif ($user->role == 'Kepala RT') {
            // Kepala RT lihat pengajuan di RT & RW yang sama
            $query->whereHas('resident', function($q) use ($user) {
                $q->where('rt', $user->rt)->where('rw', $user->rw);
            });
        } 
        elseif ($user->role == 'Kepala RW') {
            // Kepala RW lihat pengajuan di RW yang sama
            $query->whereHas('resident', function($q) use ($user) {
                $q->where('rw', $user->rw);
            });
        }
        // Admin, Staff Desa, Kepala Desa lihat semua (no filter)

        $pengantars = $query->latest()->paginate(10);
        return view('pages.pengantar.index', compact('pengantars'));
    }

=======
    // Menampilkan semua surat pengantar
    public function index()
    {
        $pengantars = Pengantar::with('resident')->latest()->paginate(10);
        return view('pages.pengantar.index', compact('pengantars'));
    }

    // Form untuk membuat surat pengantar baru
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
    public function create()
    {
        $residents = Resident::all();
        return view('pages.pengantar.create', compact('residents'));
    }

<<<<<<< HEAD
=======
    // Menyimpan surat pengantar baru
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|size:16|unique:pengantar,NIK',
            'purpose' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today'
        ]);

        if ($validator->fails()) {
<<<<<<< HEAD
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pengantar::create([
            'user_id' => Auth::id(), // SIMPAN USER YANG BUAT PENGAJUAN
=======
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pengantar::create([
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
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

<<<<<<< HEAD
=======
    // Menampilkan detail surat pengantar
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
    public function show(Pengantar $pengantar)
    {
        $pengantar->load('resident');
        return view('pages.pengantar.show', compact('pengantar'));
    }

<<<<<<< HEAD
    public function edit(Pengantar $pengantar)
    {
        // Cek apakah user berhak edit (hanya yang buat pengajuan)
        if ($pengantar->user_id != Auth::id() && !in_array(Auth::user()->role, ['Admin', 'Staff Desa'])) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit pengajuan ini!');
        }

=======
    // Form edit surat pengantar (hanya jika masih pending)
    public function edit(Pengantar $pengantar)
    {
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat pengantar tidak dapat diedit karena sudah diproses!');
        }

        $residents = Resident::all();
        return view('pages.pengantar.edit', compact('pengantar', 'residents'));
    }

<<<<<<< HEAD
    public function update(Request $request, Pengantar $pengantar)
    {
        // Cek authorization
        if ($pengantar->user_id != Auth::id() && !in_array(Auth::user()->role, ['Admin', 'Staff Desa'])) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit pengajuan ini!');
        }

=======
    // Update surat pengantar
    public function update(Request $request, Pengantar $pengantar)
    {
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat pengantar tidak dapat diedit karena sudah diproses!');
        }

        $validator = Validator::make($request->all(), [
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|size:16|unique:pengantar,NIK,' . $pengantar->id,
            'purpose' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today'
        ]);

        if ($validator->fails()) {
<<<<<<< HEAD
            return redirect()->back()->withErrors($validator)->withInput();
=======
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        }

        $pengantar->update($request->only(['resident_id', 'name', 'NIK', 'purpose', 'date']));

        return redirect()->route('pengantar.index')
            ->with('success', 'Surat pengantar berhasil diperbarui!');
    }

<<<<<<< HEAD
    public function destroy(Pengantar $pengantar)
    {
        // Cek authorization
        if ($pengantar->user_id != Auth::id() && !in_array(Auth::user()->role, ['Admin', 'Staff Desa'])) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus pengajuan ini!');
        }

=======
    // Hapus surat pengantar (hanya jika masih pending)
    public function destroy(Pengantar $pengantar)
    {
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat pengantar tidak dapat dihapus karena sudah diproses!');
        }

        $pengantar->delete();

        return redirect()->route('pengantar.index')
            ->with('success', 'Surat pengantar berhasil dihapus!');
    }

<<<<<<< HEAD
    public function processRT(Request $request, Pengantar $pengantar)
    {
        $user = Auth::user();

        // Validasi: Kepala RT hanya bisa proses pengajuan di RT & RW nya
        if ($user->role == 'Kepala RT') {
            $resident = $pengantar->resident;
            if ($resident->rt != $user->rt || $resident->rw != $user->rw) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memproses pengajuan ini!');
            }
        }

        $validator = Validator::make($request->all(), [
=======
    // Proses approval RT
    public function processRT(Request $request, Pengantar $pengantar)
    {
        $request->validate([
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
            'status' => 'required|in:accepted,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

<<<<<<< HEAD
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

=======
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        $pengantar->update([
            'status_rt' => $request->status,
            'notes_rt' => $request->notes
        ]);

<<<<<<< HEAD
        $message = $request->status === 'accepted' 
            ? 'Surat pengantar telah disetujui RT!'
            : 'Surat pengantar telah ditolak RT!';

        return redirect()->route('dashboard.rt')->with('success', $message);
    }

    public function processRW(Request $request, Pengantar $pengantar)
    {
        $user = Auth::user();

        // Validasi: Kepala RW hanya bisa proses pengajuan di RW nya
        if ($user->role == 'Kepala RW') {
            $resident = $pengantar->resident;
            if ($resident->rw != $user->rw) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memproses pengajuan ini!');
            }
        }

=======
        $message = $request->status === 'accepted'
            ? "Surat pengantar untuk {$pengantar->name} berhasil disetujui."
            : "Surat pengantar untuk {$pengantar->name} berhasil ditolak.";

        // Mengarahkan kembali ke rute dashboard RT secara eksplisit
        return redirect()->route('pengantar.dashboard.rt')->with('success', $message);
    }

    // Proses approval RW
    public function processRW(Request $request, Pengantar $pengantar)
    {
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        if ($pengantar->status_rt !== 'accepted') {
            return redirect()->back()->with('error', 'Surat pengantar harus disetujui RT terlebih dahulu!');
        }

<<<<<<< HEAD
        $validator = Validator::make($request->all(), [
=======
        $request->validate([
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
            'status' => 'required|in:accepted,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

<<<<<<< HEAD
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

=======
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
        $pengantar->update([
            'status_rw' => $request->status,
            'notes_rw' => $request->notes
        ]);

<<<<<<< HEAD
        $message = $request->status === 'accepted' 
            ? 'Surat pengantar telah disetujui RW!'
            : 'Surat pengantar telah ditolak RW!';

        return redirect()->route('dashboard.rw')->with('success', $message);
    }

    public function dashboardRT()
    {
        $user = Auth::user();
        $query = Pengantar::with('resident');

        // Filter: Kepala RT hanya lihat pengajuan di RT & RW nya
        if ($user->role == 'Kepala RT') {
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
        $query = Pengantar::with('resident')->where('status_rt', 'accepted');

        // Filter: Kepala RW hanya lihat pengajuan di RW nya
        if ($user->role == 'Kepala RW') {
            $query->whereHas('resident', function($q) use ($user) {
                $q->where('rw', $user->rw);
            });
        }

        $pengantars = $query->latest()->get();

        return view('pages.pengantar.dashboard-rw', compact('pengantars'));
    }

    public function getDetail($id)
    {
        $pengantar = Pengantar::with('resident')->findOrFail($id);
        
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
=======
        $message = $request->status === 'accepted'
            ? "Surat pengantar untuk {$pengantar->name} berhasil disetujui."
            : "Surat pengantar untuk {$pengantar->name} berhasil ditolak.";

        // Mengarahkan kembali ke rute dashboard RW secara eksplisit
        return redirect()->route('pengantar.dashboard.rw')->with('success', $message);
    }

    // Dashboard untuk RT
    public function dashboardRT()
    {
        $pending = Pengantar::where('status_rt', 'pending')->count();
        $accepted = Pengantar::where('status_rt', 'accepted')->count();
        $rejected = Pengantar::where('status_rt', 'rejected')->count();
        
        $pengantars = Pengantar::with('resident')->latest()->paginate(10);

        return view('pages.pengantar.dashboard-rt', compact('pending', 'accepted', 'rejected', 'pengantars'));
    }

    // Dashboard untuk RW
    public function dashboardRW()
    {
        $pending = Pengantar::where('status_rt', 'accepted')->where('status_rw', 'pending')->count();
        $accepted = Pengantar::where('status_rw', 'accepted')->count();
        $rejected = Pengantar::where('status_rw', 'rejected')->count();
        
        $pengantars = Pengantar::with('resident')->where('status_rt', 'accepted')->latest()->paginate(10);

        return view('pages.pengantar.dashboard-rw', compact('pending', 'accepted', 'rejected', 'pengantars'));
    }
}

>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
