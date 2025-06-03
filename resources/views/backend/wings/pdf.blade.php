<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Wings</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        .text-center{ text-align: center}
    </style>
</head>
<body>
    <h2>Wings</h2>
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
            @foreach ($wings as $index => $wing)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $wing->title }}</td>
                    <td class="text-center">{{ $wing->short_description }}</td>
                    <td class="text-center">{{ $wing->user->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $wing->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
