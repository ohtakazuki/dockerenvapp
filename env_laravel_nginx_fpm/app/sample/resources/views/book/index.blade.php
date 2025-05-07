<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Book List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->insert_timestamp }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No books found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>