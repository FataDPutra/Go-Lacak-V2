<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    // Menampilkan daftar program
    public function index()
    {
        $programs = Program::with('rekenings')->get();
        return inertia('Programs/Index', ['programs' => $programs]);
    }

    // Menyimpan data program baru atau mengedit data program
public function storeOrUpdate(Request $request, $id = null)
{
    // Validasi input
    $request->validate([
        'nama_program' => 'required|string|max:255',
        'status' => 'required|in:program,subprogram,kegiatan',
        'no_rek' => 'required|string|max:255|unique:rekening,no_rek,' . ($id ? $id : 'NULL'),
    ]);

    \Log::info('Data yang diterima di backend:', $request->all()); // Logging data input

    DB::beginTransaction();
    try {
        if ($id) {
            // Jika ada ID, berarti ini proses update
            $program = Program::findOrFail($id);

            // Update data program
            $program->update([
                'nama_program' => $request->nama_program,
                'status' => $request->status,
            ]);

            \Log::info('Data program yang diperbarui:', $program->toArray()); // Tambahkan log untuk melihat update

            // Update rekening terkait
            if ($program->rekenings->isNotEmpty()) {
                $program->rekenings[0]->update(['no_rek' => $request->no_rek]);
            } else {
                $program->rekenings()->create(['no_rek' => $request->no_rek]);
            }
            $message = 'Program berhasil diperbarui!';
        } else {
            // Jika tidak ada ID, berarti ini proses create
            $program = Program::create([
                'nama_program' => $request->nama_program,
                'status' => $request->status,
            ]);
            
            // Simpan rekening baru
            $program->rekenings()->create([
                'no_rek' => $request->no_rek,
            ]);
            $message = 'Program berhasil ditambahkan!';
        }

        DB::commit();
        return redirect()->route('programs.index')->with('success', $message);
    } catch (\Exception $e) {
        \Log::error('Error menyimpan program:', ['message' => $e->getMessage()]); // Logging error
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    // Menghapus program dan rekening terkait
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $program = Program::findOrFail($id);

            // Hapus rekening terkait
            $program->rekenings()->delete();

            // Hapus program
            $program->delete();

            DB::commit();
            return redirect()->route('programs.index')->with('success', 'Program berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
