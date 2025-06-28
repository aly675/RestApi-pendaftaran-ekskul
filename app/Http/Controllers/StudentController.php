<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;

class StudentController extends Controller
{
    /**
     * List semua siswa dengan pagination.
     */
    public function index(Request $request)
    {
        $students = Student::with('extracurriculars')->paginate(10);
        return JsonResponseHelper::paginated('res_partner', 'list', $students);
    }

    /**
     * Simpan siswa baru + attach ekskul.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'street' => 'nullable|string',
            'grade' => 'nullable|string',
            'major' => 'nullable|in:AKL,MP,BR,RPL',
            'extracurricular_ids' => 'nullable|array',
            'extracurricular_ids.*' => 'exists:extracurriculars,id',
        ]);

        try {
            $student = Student::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'email' => $data['email'],
                'street' => $data['street'] ?? null,
                'grade' => $data['grade'] ?? null,
                'major' => $data['major'] ?? null,
            ]);

            if (!empty($data['extracurricular_ids'])) {
                $student->extracurriculars()->attach($data['extracurricular_ids']);
            }

            return JsonResponseHelper::success('res_partner', 'create', $student->load('extracurriculars'), 201);

        } catch (\Exception $e) {
            return JsonResponseHelper::error('Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Tampilkan detail siswa.
     */
    public function show($id)
    {
        $student = Student::with('extracurriculars')->find($id);

        if (!$student) {
            return JsonResponseHelper::error('Data tidak ditemukan', 404);
        }

        return JsonResponseHelper::success('res_partner', 'show', $student);
    }

    /**
     * Update data siswa + ekskul.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return JsonResponseHelper::error('Data tidak ditemukan', 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'mobile' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
            'street' => 'nullable|string',
            'grade' => 'nullable|string',
            'major' => 'nullable|in:AKL,MP,BR,RPL',
            'extracurricular_ids' => 'nullable|array',
            'extracurricular_ids.*' => 'exists:extracurriculars,id',
        ]);

        try {
            $student->update($data);

            if (isset($data['extracurricular_ids'])) {
                $student->extracurriculars()->sync($data['extracurricular_ids']);
            }

            return JsonResponseHelper::success('res_partner', 'update', $student->load('extracurriculars'));

        } catch (\Exception $e) {
            return JsonResponseHelper::error('Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Hapus data siswa.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return JsonResponseHelper::error('Data tidak ditemukan', 404);
        }

        try {
            $student->delete();
            return JsonResponseHelper::success('res_partner', 'delete', ['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return JsonResponseHelper::error('Terjadi kesalahan saat menghapus data', 500);
        }
    }
}
