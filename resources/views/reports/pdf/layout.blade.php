<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 4px; }
        .meta { margin-bottom: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px; vertical-align: top; }
        th { background: #edf2f7; }
        .badge { font-weight: bold; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <div class="meta">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
    @yield('table')
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
