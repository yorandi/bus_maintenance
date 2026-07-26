<div class="d-flex flex-wrap gap-2 no-print">
    <a href="{{ $excelUrl }}" class="btn btn-success btn-sm">
        <i class="fas fa-file-excel"></i> Excel
    </a>
    <a href="{{ $pdfUrl }}" class="btn btn-danger btn-sm">
        <i class="fas fa-file-pdf"></i> PDF
    </a>
    <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
        <i class="fas fa-print"></i> Print
    </button>
</div>
