<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Digital Ticket - Wonderfull NTT</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #4f46e5;
      --primary-light: #6366f1;
      --secondary: #f97316;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --gray-light: #f3f4f6;
      --gray-medium: #e5e7eb;
      --gray-dark: #4b5563;
      --text-dark: #111827;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
      margin: 0;
      padding: 20px;
      color: var(--text-dark);
      min-height: 100vh;
    }

    .ticket-container {
      max-width: 700px;
      margin: 40px auto;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      padding: 48px;
      border: 1px solid var(--gray-medium);
      position: relative;
      overflow: hidden;
    }

    .ticket-container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
    }

    h1 {
      font-size: 28px;
      color: var(--text-dark);
      margin-bottom: 16px;
      font-weight: 700;
      line-height: 1.3;
    }

    .highlight {
      color: var(--primary);
      font-weight: 700;
    }

    .subtitle {
      font-size: 16px;
      margin-bottom: 24px;
      color: var(--gray-dark);
      line-height: 1.5;
    }

    .transaction-code {
      display: inline-block;
      background: linear-gradient(90deg, var(--secondary) 0%, #fb923c 100%);
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      margin: 20px 0 30px;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
    }

    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .status-confirmed {
      background-color: rgba(16, 185, 129, 0.1);
      color: var(--success);
    }

    .status-pending {
      background-color: rgba(245, 158, 11, 0.1);
      color: var(--warning);
    }

    .status-cancelled {
      background-color: rgba(239, 68, 68, 0.1);
      color: var(--danger);
    }

    .section-title {
      font-size: 18px;
      font-weight: 600;
      color: var(--text-dark);
      margin: 30px 0 15px;
      position: relative;
      padding-left: 15px;
    }

    .section-title::before {
      content: "";
      position: absolute;
      left: 0;
      top: 5px;
      height: 18px;
      width: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0 30px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    th, td {
      text-align: left;
      padding: 16px 20px;
      border-bottom: 1px solid var(--gray-medium);
      font-size: 15px;
    }

    th {
      background-color: var(--primary);
      color: white;
      font-weight: 500;
      text-transform: uppercase;
      font-size: 14px;
      letter-spacing: 0.5px;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover {
      background-color: rgba(79, 70, 229, 0.03);
    }

    .summary-card {
      background: var(--gray-light);
      border-radius: 12px;
      padding: 20px;
      margin: 30px 0;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
      font-size: 16px;
    }

    .summary-item:last-child {
      margin-bottom: 0;
      padding-top: 12px;
      border-top: 1px dashed var(--gray-medium);
      font-weight: 600;
      color: var(--text-dark);
    }

    .summary-value {
      font-weight: 600;
    }

    .price-original {
      text-decoration: line-through;
      color: var(--gray-dark);
      margin-right: 8px;
    }

    .price-discounted {
      color: var(--success);
    }

    .hotel-section, .package-section {
      margin-top: 40px;
      padding-top: 30px;
      border-top: 1px dashed var(--gray-medium);
    }

    .detail-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-top: 20px;
    }

    .detail-item {
      background: var(--gray-light);
      padding: 16px;
      border-radius: 8px;
    }

    .detail-label {
      font-size: 14px;
      color: var(--gray-dark);
      margin-bottom: 6px;
    }

    .detail-value {
      font-weight: 600;
      color: var(--text-dark);
    }

    .footer {
      text-align: center;
      margin-top: 50px;
      padding-top: 20px;
      border-top: 1px solid var(--gray-medium);
      font-size: 14px;
      color: var(--gray-dark);
    }

    .footer p {
      margin: 8px 0;
    }

    .qr-code {
      text-align: center;
      margin: 30px 0;
    }

    .qr-code img {
      width: 150px;
      height: 150px;
      border: 1px solid var(--gray-medium);
      padding: 10px;
      border-radius: 8px;
      background: white;
    }

    .qr-note {
      font-size: 13px;
      color: var(--gray-dark);
      margin-top: 8px;
    }

    .map-container {
      margin-top: 20px;
      border-radius: 12px;
      overflow: hidden;
      height: 200px;
      background: var(--gray-light);
      position: relative;
    }

    .map-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--gray-dark);
    }

    @media (max-width: 768px) {
      .ticket-container {
        padding: 30px;
        margin: 20px auto;
      }

      h1 {
        font-size: 24px;
      }

      .subtitle {
        font-size: 15px;
      }

      .transaction-code {
        font-size: 15px;
        padding: 10px 20px;
      }

      th, td {
        padding: 12px 15px;
      }

      .detail-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 480px) {
      .ticket-container {
        padding: 25px 20px;
        border-radius: 12px;
      }

      h1 {
        font-size: 22px;
      }

      .section-title {
        font-size: 17px;
      }

      .summary-item {
        font-size: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="ticket-container">
    <h1>Thank you, <span class="highlight">{{ $transaction->customer_name }}</span>!</h1>
    <p class="subtitle">Your booking at <strong>Wonderfull NTT</strong> has been successfully confirmed. Please present this ticket at the entrance.</p>

    <div class="transaction-code">
      Booking #{{ $transaction->booking_code }}
      <span class="status-badge status-{{ strtolower($transaction->status) }}">{{ ucfirst($transaction->status) }}</span>
    </div>

    <div class="qr-code">
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaction->booking_code) }}" alt="QR Code" />
      <p class="qr-note">Scan this QR code at the entrance</p>
    </div>

    @if($transaction->destination)
      <div class="section-title">Destination Details</div>
      <div class="detail-grid">
        <div class="detail-item">
          <div class="detail-label">Destination Name</div>
          <div class="detail-value">{{ $transaction->destination->name }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Category</div>
          <div class="detail-value">{{ $transaction->destination->category }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Location</div>
          <div class="detail-value">{{ $transaction->destination->location }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Booking Date</div>
          <div class="detail-value">{{ \Carbon\Carbon::parse($transaction->booking_date)->format('d M Y') }}</div>
        </div>
      </div>

      <div class="map-container">
        <div class="map-placeholder">
          Map view of {{ $transaction->destination->location }}
        </div>
      </div>
    @endif

    @if($transaction->tourPackage)
      <div class="package-section">
        <div class="section-title">Tour Package Details</div>
        <div class="detail-grid">
          <div class="detail-item">
            <div class="detail-label">Package Name</div>
            <div class="detail-value">{{ $transaction->tourPackage->name }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Tour Date</div>
            <div class="detail-value">{{ \Carbon\Carbon::parse($transaction->tourPackage->date)->format('d M Y') }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Departure Time</div>
            <div class="detail-value">{{ $transaction->tourPackage->time }}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Duration</div>
            <div class="detail-value">{{ $transaction->tourPackage->duration }} hours</div>
          </div>
        </div>
      </div>
    @endif

    <div class="section-title">Booking Summary</div>
    <div class="summary-card">
      <div class="summary-item">
        <span>Number of Tickets:</span>
        <span class="summary-value">{{ $transaction->number_of_tickets }}</span>
      </div>
      <div class="summary-item">
        <span>Price per Ticket:</span>
        <span class="summary-value">Rp {{ number_format($transaction->package_price, 0, ',', '.') }}</span>
      </div>
      @if($transaction->discount > 0)
      <div class="summary-item">
        <span>Discount Applied:</span>
        <span class="summary-value">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
      </div>
      @endif
      <div class="summary-item">
        <span>Total Price:</span>
        <span class="summary-value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
      </div>
    </div>

    <div class="footer">
      <p>Need help? Contact us at support@wonderfullntt.com or call +62 123 4567 890</p>
      <p>We wish you an unforgettable experience!</p>
      <p style="margin-top: 15px; color: var(--primary); font-weight: 600;">— The Wonderfull NTT Team</p>
    </div>
  </div>
</body>
</html>