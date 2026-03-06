<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Certificado Analítico</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; margin: 40px; }
        .header { text-align: center; border-bottom: 2px solid #0055ff; padding-bottom: 20px; margin-bottom: 40px; }
        .logo { font-size: 28px; font-weight: bold; color: #050814; letter-spacing: 2px; }
        .subtitle { font-size: 14px; color: #666; text-transform: uppercase; letter-spacing: 1px; }

        .title { text-align: center; font-size: 22px; font-weight: bold; text-transform: uppercase; margin-bottom: 40px; color: #050814; }

        .student-info { margin-bottom: 40px; background-color: #f8f9fa; padding: 20px; border-left: 4px solid #0055ff; }
        .student-info p { margin: 5px 0; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; font-size: 13px; }
        th { background-color: #0055ff; color: #fff; text-transform: uppercase; font-size: 12px; }

        .total-row td { font-weight: bold; background-color: #f1f5f9; }

        .footer { margin-top: 80px; text-align: center; }
        .signature { display: inline-block; width: 250px; border-top: 1px solid #333; padding-top: 10px; margin: 0 20px; }
        .signature p { margin: 0; font-size: 12px; }

        .validation { margin-top: 60px; font-size: 10px; color: #999; text-align: center; font-family: monospace; border-top: 1px dashed #ccc; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">SIGCL PRO</div>
        <div class="subtitle">Sistema de Gestión de Centros Locales</div>
    </div>

    <div class="title">Certificado Analítico de Cursada</div>

    <p style="text-align: justify; font-size: 14px; margin-bottom: 20px;">
        Por la presente se certifica que el/la estudiante cuyos datos obran a continuación, ha cursado las evaluaciones correspondientes al módulo de formación indicado, obteniendo el siguiente registro académico:
    </p>

    <div class="student-info">
        <p><strong>Estudiante:</strong> {{ $user->last_name ?? '' }}, {{ $user->name }}</p>
        <p><strong>Documento de Identidad (DNI):</strong> {{ $user->dni ?? 'No registrado' }}</p>
        <p><strong>Módulo:</strong> {{ $training->name }}</p>
        <p><strong>Docente a Cargo:</strong> {{ $training->teacher->name ?? 'Mentor' }} {{ $training->teacher->last_name ?? '' }}</p>
        <p><strong>Fecha de Emisión:</strong> {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Evaluación</th>
                <th style="text-align: center;">Nota Obtenida</th>
                <th style="text-align: center;">Nota Máxima</th>
                <th style="text-align: center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalScore = 0;
                $evalCount = $training->evaluations->count();
            @endphp
            @forelse($training->evaluations as $eval)
                @php
                    $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first();
                    $score = $grade ? $grade->score : 0;
                    $totalScore += $score;
                    // Supongamos que se aprueba con el 60% de la nota máxima
                    $isApproved = $score >= ($eval->max_score * 0.6);
                @endphp
                <tr>
                    <td>{{ $eval->name }}</td>
                    <td style="text-align: center; font-weight: bold; color: {{ $isApproved ? '#008000' : '#cc0000' }}">{{ $score }}</td>
                    <td style="text-align: center;">{{ $eval->max_score }}</td>
                    <td style="text-align: center; font-weight: bold; color: {{ $isApproved ? '#008000' : '#cc0000' }}">
                        {{ $isApproved ? 'APROBADO' : 'DESAPROBADO' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; font-style: italic;">No se registraron evaluaciones.</td>
                </tr>
            @endforelse

            @if($evalCount > 0)
                <tr class="total-row">
                    <td style="text-align: right;">PROMEDIO GENERAL:</td>
                    <td style="text-align: center;">{{ number_format($totalScore / $evalCount, 2) }}</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 14px;">
        <p><strong>Porcentaje de Asistencia Registrado:</strong>
            @php
                $totalClasses = $training->courseClasses->count();
                $attendedClasses = $enrollment->attendances->count();
                $attendancePercentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100) : 0;
            @endphp
            {{ $attendancePercentage }}% ({{ $attendedClasses }} de {{ $totalClasses }} asistencias)
        </p>
    </div>

    <div class="footer">
        <div class="signature">
            <p><strong>{{ $training->teacher->name ?? 'Dirección' }} {{ $training->teacher->last_name ?? '' }}</strong></p>
            <p>Firma Autorizada</p>
        </div>
        <div class="signature">
            <p><strong>SIGCL INSTITUCIONAL</strong></p>
            <p>Sello de la Red</p>
        </div>
    </div>

    <div class="validation">
        DOCUMENTO GENERADO ELECTRÓNICAMENTE POR SIGCL PRO.<br>
        ID DE VALIDACIÓN SEGURO: {{ strtoupper(md5($enrollment->id . $user->email . date('Y-m-d'))) }} | FECHA: {{ date('Y-m-d H:i:s') }}
    </div>

</body>
</html>
