<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;

class ExtracurricularController extends Controller
{
    /**
     * List semua ekskul dengan pagination.
     */
    public function index(Request $request)
    {
        $extracurriculars = Extracurricular::paginate(10);
        return JsonResponseHelper::paginated('extracurricular', 'list', $extracurriculars);
    }

    /**
     * Tambah ekskul baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:extracurriculars,name',
            'description' => 'nullable|string',
        ]);

        try {
            $extracurricular = Extracurricular::create($data);
            return JsonResponseHelper::success('extracurricular', 'create', $extracurricular, 201);
        } catch (\Exception $e) {
            return JsonResponseHelper::error('Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Tampilkan detail ekskul.
     */
    public function show($id)
    {
        $extracurricular = Extracurricular::find($id);

        if (!$extracurricular) {
            return JsonResponseHelper::error('Data tidak ditemukan', 404);
        }

        return JsonResponseHelper::success( $extracurricular);
    }

    /**
     * Update ekskul.
     */
    public function update(Request $request, $id)
    {
        $extracurricular = Extracurricular::find($id);

        if (!$extracurricular) {
            return JsonResponseHelper::error('Data tidak ditemukan', 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:extracurriculars,name,' . $extracurricular->id,
            'description' => 'nullable|string',
        ]);

        try {
            $extracurricular->update($data);
            return JsonResponseHelper::success( $extracurricular);
        } catch (\Exception $e) {
            return JsonResponseHelper::error('Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Hapus ekskul.
     */
    public function destroy($id)
    {
        $extracurricular = Extracurricular::find($id);

        if (!$extracurricular) {
            return JsonResponseHelper::error('Data tidak ditemukan', 404);
        }

        try {
            $extracurricular->delete();
            return JsonResponseHelper::success(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return JsonResponseHelper::error('Terjadi kesalahan saat menghapus data', 500);
        }
    }
}
