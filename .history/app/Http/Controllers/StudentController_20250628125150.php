<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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
}
