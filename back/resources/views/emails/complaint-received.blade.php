<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Жалоба принята</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
    .wrapper { max-width: 580px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
    .header { background: #D1832C; padding: 32px 40px; }
    .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 700; }
    .header p { margin: 6px 0 0; color: rgba(255,255,255,.85); font-size: 14px; }
    .body { padding: 32px 40px; }
    .track-box { background: #fff8f0; border: 2px dashed #D1832C; border-radius: 8px; padding: 20px; text-align: center; margin: 24px 0; }
    .track-box .label { font-size: 13px; color: #888; margin-bottom: 8px; }
    .track-box .code { font-size: 28px; font-weight: 700; color: #D1832C; letter-spacing: 2px; }
    .info { font-size: 14px; color: #444; line-height: 1.7; }
    .info strong { color: #222; }
    .divider { border: none; border-top: 1px solid #eee; margin: 24px 0; }
    .footer { background: #f9f9f9; padding: 20px 40px; font-size: 12px; color: #aaa; text-align: center; border-top: 1px solid #eee; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <h1>АУГЗ — Ваша жалоба принята</h1>
      <p>Ассоциация участников государственных закупок Узбекистана</p>
    </div>

    <div class="body">
      <p class="info">Здравствуйте@if($complaint->name && !$complaint->anonymous), <strong>{{ $complaint->name }}</strong>@endif!</p>
      <p class="info">Мы получили вашу жалобу и зарегистрировали её в системе. Сохраните трек-код — он понадобится для отслеживания статуса.</p>

      <div class="track-box">
        <div class="label">Ваш трек-код</div>
        <div class="code">{{ $complaint->track_code }}</div>
      </div>

      <p class="info">Проверить статус жалобы можно на сайте:<br>
        <a href="{{ config('app.frontend_url', 'https://augz.uz') }}/report" style="color:#D1832C;">augz.uz/report</a>
      </p>

      <hr class="divider">

      <p class="info"><strong>Детали обращения:</strong></p>
      <p class="info">
        @if($complaint->organization)
          <strong>Организация:</strong> {{ $complaint->organization }}<br>
        @endif
        @if($complaint->tender_number)
          <strong>Номер тендера:</strong> {{ $complaint->tender_number }}<br>
        @endif
        @if($complaint->violation_date)
          <strong>Дата нарушения:</strong> {{ $complaint->violation_date->format('d.m.Y') }}<br>
        @endif
        <strong>Дата подачи:</strong> {{ $complaint->created_at->format('d.m.Y H:i') }}
      </p>

      <p class="info" style="color:#888; font-size:13px;">
        Наши специалисты рассмотрят обращение в течение 10 рабочих дней. Если у вас возникнут вопросы — пишите на
        <a href="mailto:info@augz.uz" style="color:#D1832C;">info@augz.uz</a>.
      </p>
    </div>

    <div class="footer">
      © {{ date('Y') }} АУГЗ. Это письмо отправлено автоматически, не отвечайте на него.
    </div>
  </div>
</body>
</html>
