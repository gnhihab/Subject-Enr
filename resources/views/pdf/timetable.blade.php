<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>جدول دراسي</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>الفصل الدراسي الأول للعام الأكاديمي {{ $student_info['academic_year'] }}</h2>
        <h3>اسم الطالب: {{ $student_info['name'] }}</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>المقرر الدراسي</th>
                <th>ساعات معتمدة</th>
                <th>اسم الدكتور</th>
                <th>المكان</th>
                <th>الجدول</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timetable as $subject)
                <tr>
                    <td>{{ $subject['name'] }}</td>
                    <td>{{ $subject['credit_hours'] }}</td>
                    <td>{{ $subject['doctor_name'] }}</td>
                    <td>{{ $subject['location'] }}</td>
                    <td>{{ $subject['schedule'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
