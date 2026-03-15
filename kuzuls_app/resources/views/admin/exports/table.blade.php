<!doctype html>
<html lang="lv">
<head>
<meta charset="utf-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 6px; }
    th { background: #fff7cc; }
</style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <table>
        <thead>
            <tr>
                @if(count($rows))
                    @foreach(array_keys($rows[0]) as $h)
                        <th>{{ $h }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr>
                    @foreach($r as $v)
                        <td>{{ $v }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td>Nav datu</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>