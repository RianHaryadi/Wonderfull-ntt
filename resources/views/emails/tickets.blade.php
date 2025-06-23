<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Digital Ticket - Wonderfull NTT</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f3f4f6;
      margin: 0;
      padding: 0;
      color: #1f2937;
    }

    .ticket-container {
      max-width: 700px;
      margin: 60px auto;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
      padding: 48px 50px;
      border: 1px solid #e5e7eb;
    }

    h1 {
      font-size: 26px;
      color: #111827;
      margin-bottom: 14px;
      font-weight: 700;
    }

    .highlight {
      color: #4f46e5;
    }

    p {
      font-size: 16px;
      margin-bottom: 18px;
      color: #4b5563;
    }

    .transaction-code {
      display: inline-block;
      background: #f97316;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      margin: 20px 0;
      letter-spacing: 1px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 24px;
    }

    th, td {
      text-align: left;
      padding: 14px 16px;
      border-bottom: 1px solid #e5e7eb;
      font-size: 15px;
    }

    th {
      background-color: #f3f4f6;
      color: #374151;
      font-weight: 600;
    }

    tr:hover {
      background-color: #f9fafb;
    }

    .summary {
      margin-top: 30px;
      font-size: 16px;
    }

    .summary p {
      margin-bottom: 10px;
    }

    .summary strong {
      color: #10b981;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid #e5e7eb;
      font-size: 14px;
      color: #9ca3af;
    }

    @media (max-width: 720px) {
      .ticket-container {
        padding: 30px 20px;
        margin: 30px 15px;
      }

      h1 {
        font-size: 22px;
      }

      p, .summary {
        font-size: 14.5px;
      }
    }
  </style>
</head>
<body>
  <div class="ticket-container">
    <h1>Thank you, <span class="highlight">{{ $transaction->customer_name }}</span>!</h1>
    <p>Your ticket booking at <strong>Wonderfull NTT</strong> has been successfully confirmed.</p>

    <div class="transaction-code">
      Transaction Code: {{ $transaction->id }}
    </div>

    <p>Your ticket details:</p>

    <table>
      <thead>
        <tr>
          <th>Ticket Code</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tickets as $ticket)
        <tr>
          <td>{{ $ticket->ticket_code }}</td>
          <td>{{ ucfirst($ticket->status) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="summary">
      <p>Total Tickets: <strong>{{ $transaction->ticket_quantity }}</strong></p>
      <p>Total Price: <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>
    </div>

    @if ($transaction->hotel)
      <div class="summary" style="margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
        <h3>Hotel Booking Details</h3>
        <p><strong>Hotel Name:</strong> {{ $transaction->hotel->name }}</p>
        <p><strong>Room Type:</strong> {{ $transaction->variant_price->room_type ?? 'N/A' }}</p>
        <p><strong>Price per Room:</strong> Rp {{ number_format($transaction->hotel->price, 0, ',', '.') }}</p>
        <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($transaction->check_in_date)->format('d M Y') }}</p>
        <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($transaction->check_out_date)->format('d M Y') }}</p>
      </div>
    @endif

    <div class="footer">
      <p>We wish you an unforgettable experience!<br>— The Wonderfull NTT Team</p>
    </div>
  </div>
</body>
</html>
