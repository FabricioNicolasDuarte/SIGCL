<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta Oficial - {{ $training->name }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .subtitle { font-size: 12px; margin: 5px 0 0 0; color: #555; }

        .info-table { width: 100%; margin-bottom: 20px; border: none; }
        .info-table td { padding: 4px; border: none; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .text-left { text-align: left; }

        .presente { color: #008000; font-weight: bold; }
        .ausente { color: #cc0000; font-weight: bold; }

        .footer { margin-top: 50px; text-align: center; width: 100%; }
        .signature-box { display: inline-block; width: 250px; border-top: 1px solid #000; margin-top: 40px; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <p class="title">Acta Oficial de Cursada y Calificaciones</p>
        <p class="subtitle">SIGCL Pro - Sistema de Gestión de Centros Locales</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="text-align: left;"><strong>Módulo:</strong> {{ $training->name }}</td>
            <td style="text-align: right;"><strong>Fecha de Emisión:</strong> {{ date('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td style="text-align: left;"><strong>Sede / Nodo:</strong> {{ $training->campus->name ?? 'Virtual' }}</td>
            <td style="text-align: right;"><strong>Docente a Cargo:</strong> {{ $training->teacher->name }} {{ $training->teacher->last_name }}</td>
        </tr>
    </table>

    <h3>1. MATRIZ DE ASISTENCIAS</h3>
    <table>
        <thead>
            <tr>
                <th class="text-left">Estudiante (Apellidos, Nombres)</th>
                <th>DNI / ID</th>
                @foreach($training->courseClasses as $class)
                    <th>{{ \Carbon\Carbon::parse($class->date)->format('d/m') }}</th>
                @endforeach
                <th>Total Pres.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($training->enrollments as $enrollment)
                <tr>
                    <td class="text-left">{{ $enrollment->student->last_name ?? '' }}, {{ $enrollment->student->name }}</td>
                    <td>{{ $enrollment->student->dni ?? '--' }}</td>
                    @foreach($training->courseClasses as $class)
                        @php $att = $enrollment->attendances->where('course_class_id', $class->id)->first(); @endphp
                        <td>
                            @if($att)
                                <span class="presente">P</span>
                            @else
                                <span class="ausente">A</span>
                            @endif
                        </td>
                    @endforeach
                    <td style="font-weight:bold;">{{ $enrollment->attendances->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>2. LIBRO MATRIZ DE CALIFICACIONES</h3>
    <table>
        <thead>
            <tr>
                <th class="text-left">Estudiante (Apellidos, Nombres)</th>
                @foreach($training->evaluations as $eval)
                    <th>{{ $eval->name }} <br><span style="font-size: 8px; color: #666;">(Máx: {{ $eval->max_score }})</span></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($training->enrollments as $enrollment)
                <tr>
                    <td class="text-left">{{ $enrollment->student->last_name ?? '' }}, {{ $enrollment->student->name }}</td>
                    @foreach($training->evaluations as $eval)
                        @php $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first(); @endphp
                        <td>{{ $grade ? $grade->score : '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            Firma del Docente Titular<br>
            <strong>{{ $training->teacher->name }} {{ $training->teacher->last_name }}</strong>
        </div>
    </div>

</body>
</html>
