<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Employee Report</h1>

    <h2>Overview</h2>
    <table>
        <tr><th>Metric</th><th>Value</th></tr>
        <tr><td>Total Employees</td><td>{{ $employees->count() }}</td></tr>
        <tr><td>Active Employees</td><td>{{ $employees->where('status', 'active')->count() }}</td></tr>
        <tr><td>On Leave</td><td>{{ $employees->where('status', 'on_leave')->count() }}</td></tr>
        <tr><td>Inactive</td><td>{{ $employees->where('status', 'inactive')->count() }}</td></tr>
    </table>

    <h2>Today's Attendance</h2>
    <table>
        <tr><th>Status</th><th>Count</th></tr>
        <tr><td>Present</td><td>{{ $attendance['present'] }}</td></tr>
        <tr><td>Absent</td><td>{{ $attendance['absent'] }}</td></tr>
        <tr><td>Late</td><td>{{ $attendance['late'] }}</td></tr>
    </table>
</body>
</html>
