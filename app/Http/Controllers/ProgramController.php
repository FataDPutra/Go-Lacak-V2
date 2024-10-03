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
    // Validasi input untuk program
    $request->validate([
        'nama_program' => 'required|string|max:255',
        'status' => 'required|in:program,subprogram,kegiatan',
        'no_rek' => $id ? 'nullable|string|max:255|unique:rekening,no_rek,' . $id : 'required|string|max:255|unique:rekening,no_rek',
    ]);

    \Log::info('Data yang diterima di backend:', $request->all());

    DB::beginTransaction();
    try {
        if ($id) {
            // Proses update
            $program = Program::findOrFail($id);

            // Update nama program dan status
            $program->update([
                'nama_program' => $request->nama_program,
                'status' => $request->status,
            ]);

            \Log::info('Program berhasil diperbarui:', $program->toArray());

            // Update rekening hanya jika ada perubahan no_rek
            if ($request->filled('no_rek')) {
                if ($program->rekenings->isNotEmpty()) {
                    $program->rekenings[0]->update(['no_rek' => $request->no_rek]);
                } else {
                    $program->rekenings()->create(['no_rek' => $request->no_rek]);
                }
                \Log::info('Rekening berhasil diperbarui atau dibuat.');
            }

            $message = 'Program berhasil diperbarui!';
        } else {
            // Proses create
            $program = Program::create([
                'nama_program' => $request->nama_program,
                'status' => $request->status,
            ]);
            
            // Simpan rekening baru
            $program->rekenings()->create([
                'no_rek' => $request->no_rek,
            ]);

            $message = 'Program dan rekening berhasil ditambahkan!';
        }

        DB::commit();
        return redirect()->route('programs.index')->with('success', $message);
    } catch (\Exception $e) {
        \Log::error('Error saat menyimpan program:', ['message' => $e->getMessage()]);
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
