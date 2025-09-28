<?php

namespace App\Http\Controllers;

use App\Models\Pengantar;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PengantarController extends Controller
{
    // Menampilkan semua surat pengantar
    public function index()
    {
        $pengantars = Pengantar::with('resident')->latest()->paginate(10);
        return view('pages.pengantar.index', compact('pengantars'));
    }

    // Form untuk membuat surat pengantar baru
    public function create()
    {
        $residents = Resident::all();
        return view('pages.pengantar.create', compact('residents'));
    }

    // Menyimpan surat pengantar baru
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pengantar::create([
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

    // Menampilkan detail surat pengantar
    public function show(Pengantar $pengantar)
    {
        $pengantar->load('resident');
        return view('pages.pengantar.show', compact('pengantar'));
    }

    // Form edit surat pengantar (hanya jika masih pending)
    public function edit(Pengantar $pengantar)
    {
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat pengantar tidak dapat diedit karena sudah diproses!');
        }

        $residents = Resident::all();
        return view('pages.pengantar.edit', compact('pengantar', 'residents'));
    }

    // Update surat pengantar
    public function update(Request $request, Pengantar $pengantar)
    {
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pengantar->update($request->only(['resident_id', 'name', 'NIK', 'purpose', 'date']));

        return redirect()->route('pengantar.index')
            ->with('success', 'Surat pengantar berhasil diperbarui!');
    }

    // Hapus surat pengantar (hanya jika masih pending)
    public function destroy(Pengantar $pengantar)
    {
        if ($pengantar->status_rt !== 'pending') {
            return redirect()->back()->with('error', 'Surat pengantar tidak dapat dihapus karena sudah diproses!');
        }

        $pengantar->delete();

        return redirect()->route('pengantar.index')
            ->with('success', 'Surat pengantar berhasil dihapus!');
    }

    // Proses approval RT
    public function processRT(Request $request, Pengantar $pengantar)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        $pengantar->update([
            'status_rt' => $request->status,
            'notes_rt' => $request->notes
        ]);

        $message = $request->status === 'accepted'
            ? "Surat pengantar untuk {$pengantar->name} berhasil disetujui."
            : "Surat pengantar untuk {$pengantar->name} berhasil ditolak.";

        // Mengarahkan kembali ke rute dashboard RT secara eksplisit
        return redirect()->route('pengantar.dashboard.rt')->with('success', $message);
    }

    // Proses approval RW
    public function processRW(Request $request, Pengantar $pengantar)
    {
        if ($pengantar->status_rt !== 'accepted') {
            return redirect()->back()->with('error', 'Surat pengantar harus disetujui RT terlebih dahulu!');
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        $pengantar->update([
            'status_rw' => $request->status,
            'notes_rw' => $request->notes
        ]);

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

