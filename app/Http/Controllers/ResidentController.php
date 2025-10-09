<?php

namespace App\Http\Controllers;

use App\Models\resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

function store(Request $request)
{
    $dataRW = [
        1 => 7,  
        2 => 9, 
        3 => 3, 
        4 => 10,
        5 => 10, 
        6 => 7, 
        7 => 4, 
        8 => 8, 
        9 => 7, 
        10 => 2, 
    ];

    $validated = $request->validate([
        // ... (validasi NIK, nama, dll.)
        
        'RW' => ['required', 'numeric', 'in:' . implode(',', array_keys($dataRW))],
        'RT' => [
            'required',
            'numeric',
            // Logika kustom menggunakan Rule::exists atau Closure
            function ($attribute, $value, $fail) use ($request, $dataRW) {
                $rw = $request->input('RW');

                // Cek apakah RW valid dan ada di data kita
                if (!isset($dataRW[$rw])) {
                    // Tidak perlu pesan error di sini karena validasi 'in' untuk RW sudah menangani
                    return;
                }
                
                // Cek apakah RT yang dimasukkan tidak melebihi batas maksimal di RW tersebut
                $maxRT = $dataRW[$rw];
                if ($value > $maxRT) {
                    $fail("Untuk RW {$rw}, nomor RT tidak boleh lebih dari {$maxRT}.");
                }
            },
        ],
    ]);

    Resident::create($validated);

    return redirect('/resident')->with('success', 'Berhasil Menambahkan Data');
}


class ResidentController extends Controller
{
     public function index()
    {
        // FIX: Panggil paginate() langsung, bukan setelah all()
        $residents = Resident::latest()->paginate(perPage: 5); // latest() untuk mengurutkan dari terbaru

        return view("pages.resident.index", [
            'residents' => $residents,
        ]);
    }

    public function create()
        {
            $wilayahData = [
            '1' => 7,  
            '2' => 9, 
            '3' => 3, 
            '4' => 10,
            '5' => 10, 
            '6' => 7, 
            '7' => 4, 
            '8' => 8, 
            '9' => 7, 
            '10' => 2, 
        ];

        return view('pages.resident.create', [
            'wilayahData' => $wilayahData
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => ['required','min:16','max:16'],
            'name' => ['required','min:1','max:100'],
            'gender' => ['required',Rule::in(['Laki-Laki','Perempuan'])],
            'birth_date' => ['required','string'],
            'birth_place'=>['required','max:100'],
            'address' => ['required','max:700'],
            'religion'=>['nullable','max:50'],
            'phone'=>['nullable','max:15'],
            'RT'=>['required','max:2'],
            'RW'=>['required','max:2'],
        ]);

         Resident::create($validatedData);

         return redirect('/resident')->with('success','Berhasil Menambahkan Data');
    }

    public function edit($id)
        {
            $resident = Resident::findOrFail($id);
             $wilayahData = [
                    '1' => 7,  
                    '2' => 9, 
                    '3' => 3, 
                    '4' => 10,
                    '5' => 10, 
                    '6' => 7, 
                    '7' => 4, 
                    '8' => 8, 
                    '9' => 7, 
                    '10' => 2,
                ];

            return view('pages.resident.edit',[
                'resident' => $resident,
                'wilayahData' => $wilayahData
            ]); 
        }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nik' => ['required','min:16','max:16'],
            'name' => ['required','min:1','max:100'],
            'gender' => ['required',Rule::in(['Laki-Laki','Perempuan'])],
            'birth_date' => ['required','string'],
            'birth_place'=>['required','max:100'],
            'address' => ['required','max:700'],
            'religion'=>['nullable','max:50'],
            'phone'=>['nullable','max:15'],
            'RT'=>['required','max:2'],
            'RW'=>['required','max:2'],
            
        ]);

         Resident::findOrFail($id)->update($validatedData);

         return redirect('/resident')->with('success','Berhasil Mengubah Data');
    }

    public function destroy($id)
        {
            $resident = Resident::findOrFail($id);
            $resident->delete();
            

            return redirect('/resident')->with('success','Berhasil Menghapus Data');
        }

}
