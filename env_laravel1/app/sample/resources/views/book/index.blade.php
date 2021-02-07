<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <table border="1">
    @foreach($books as $book)
    <tr>
      <td>{{ $book->id }}</td>
      <td>{{ $book->title }}</td>
      <td>{{ $book->insert_timestamp }}</td>
    </tr>
    @endforeach
  </table>
</body>
</html>