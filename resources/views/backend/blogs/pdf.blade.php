<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blogs</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        .text-center{ text-align: center}
    </style>
</head>
<body>
    <h2>Blogs</h2>
    <table>
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Title</th>
                <th>Written By</th>
                <th>Status</th>
                <th>Approved By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $index => $blog)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $blog->title }}</td>
                    <td class="text-center">{{ $blog->user->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $blog->is_approved ? 'Approved' : 'Not Approved' }}</td>
                    <td class="text-center">{{ $blog->approved_by ? $blog->approved_by : '-'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
