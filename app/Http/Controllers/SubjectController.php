<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;


class SubjectController extends Controller
{

    public function getSubjectsByYearAndSemester(Request $request)
    {
        $academicYear = $request->input('academic_year'); // Get user-selected level
        $semester = $request->input('semester'); // Get user-selected semester
        $nationalId = $request->input('national_id'); // Get user national ID

        // Retrieve the student record based on national ID
        $student = User::where('national_id', $nationalId)->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $department = $student->department; // Get the student's department

        if ($academicYear == "المستوى الأول" || $academicYear == "المستوى الثاني") {
            // Get subjects for academic year 1 or 2
            $subjects = Subject::where('acadimc_year', $academicYear)
                ->where('semester', $semester)
                ->pluck('name');
        } elseif ($academicYear == "المستوى الثالث" || $academicYear == "المستوى الرابع") {
            // Get subjects for academic year 3 or 4 based on department
            $subjects = Subject::where('acadimc_year', $academicYear)
                ->where('semester', $semester)
                ->where('department', $department)
                ->pluck('name');
        } else {
            return response()->json(['message' => 'Invalid academic year'], 400);
        }

        if ($subjects->isEmpty()) {
            return response()->json(['message' => 'لا يوجد مواد لهذا المستوى او الترم الدراسي'], 404);
        }

        return response()->json($subjects);
    }


    public function enroll(Request $request)
    {

        $subjectName = $request->input('Subject-Name');
        // $studentId = $request->input('Student-Id');
        $national_id = $request->input('National_Id');

        // Find the student and subject

        $student = User::where('national_id', $national_id)->firstOrFail();
        $subject = Subject::where('name', $subjectName)->firstOrFail();


        if ($student->gpa <= 1.00) {
            return response()->json([
                'error' => ' لا يمكنك التسجيل لأن المعدل التراكمي أقل من 1.0'
            ], 400);
        }

        //Check requirements

        if ($subject->requirement) {
            $requiredSubject = Subject::where('name', $subject->requirement)->first();

            if (!$student->subject()->where('name', $requiredSubject->name)->exists()) {
                return response()->json([
                    'error' => 'لتفوم بتسجيل ماده ' . $subject->name . ', عليك اخذ مقرر ' . $requiredSubject->name
                ], 400);
            }
        }

        // Enroll the student in the subject

        $student->subject()->attach($subject->id);

        $enrolledSubjects = $student->subject()->get();


        return response()->json([
            'enrolled_subjects' => $enrolledSubjects->map(function ($subject) {
                return [
                    'name' => $subject->name,
                    'credit_hours' => $subject->credit,
                    'doctor_name' => $subject->dr_name,
                ];
            })->toArray(),
            'student_info' => [
                'name' => $student->name,
                'academic_year' => $student->acadimc_year
            ],
        ], 200);
    }


    public function getTimetable(Request $request)
    {
        $nationalId = $request->input('National-Id');

        $student = User::with('subject')->where('national_id', $nationalId)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $subjects = $student->subject->map(function ($subject) {
            return [
                'name' => $subject->name,
                'credit_hours' => $subject->credit,
                'doctor_name' => $subject->dr_name,
                'location' => $subject->location,
                'schedule' => $subject->schedule,
            ];
        });

        $data = [
            'student_info' => [
                'name' => $student->name,
                'academic_year' => $student->acadimc_year,
            ],
            'timetable' => $subjects,
        ];

        // Load the view and pass the data to it
        $pdf = FacadePdf::loadView('pdf.timetable', $data);

        // Return the PDF as a response
        return $pdf->download('timetable.pdf');

    }


}
