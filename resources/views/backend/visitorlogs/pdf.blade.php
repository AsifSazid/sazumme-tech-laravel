<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visitor Logs</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        .text-center{ text-align: center}
    </style>
</head>
<body>
    <h2>Visitor Logs</h2>
    <table>
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Title</th>
                <th>Short Description</th>
                <th>Created By</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitorlogs as $index => $visitorlog)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $visitorlog->title }}</td>
                    <td class="text-center">{{ $visitorlog->short_description }}</td>
                    <td class="text-center">{{ $visitorlog->user->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $visitorlog->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
