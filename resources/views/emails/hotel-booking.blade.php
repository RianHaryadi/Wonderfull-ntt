<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Booking Confirmation</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f6f7fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div style="max-width: 640px; margin: 30px auto; background: #ffffff; border-radius: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.08); overflow: hidden;">

        <!-- Header -->
        <div style="background: linear-gradient(90deg, #43cea2, #185a9d); padding: 30px 40px; color: white; text-align: center;">
            <img src="https://via.placeholder.com/70x70?text=🏨" alt="Logo" style="border-radius: 50%; margin-bottom: 15px;" />
            <h1 style="margin: 0; font-size: 26px;">Your Booking is Confirmed!</h1>
            <p style="margin: 5px 0 0; font-size: 15px; opacity: 0.9;">Your reservation has been successfully made 💼</p>
        </div>

        <!-- Body -->
        <div style="padding: 30px 40px;">
            <p style="font-size: 16px; color: #333;">Hi <strong>{{ $booking->customer_name }}</strong>,</p>
            <p style="font-size: 16px; color: #555; line-height: 1.7;">
                Thank you for booking a room at <strong>{{ $booking->hotel->name }}</strong>. Here are your reservation details:
            </p>

            <!-- Booking Code -->
            <div style="background: #f1faf6; border-left: 5px solid #43cea2; border-radius: 10px; padding: 15px 20px; margin: 25px 0;">
                <p style="margin: 0; font-size: 16px; color: #222;"><strong>🔖 Booking Number:</strong> <span style="color: #2f855a;">{{ $booking->booking_number ?? '—' }}</span></p>
            </div>

            <!-- Booking Details -->
            <table style="width: 100%; margin-top: 15px; font-size: 15px; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; color: #555;">👤 <strong>Guest Name</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ $booking->customer_name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555;">🏨 <strong>Hotel</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ $booking->hotel->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555;">🛏️ <strong>Room Type</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ ucfirst($booking->room_type) }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555;">🌙 <strong>Nights</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ $booking->night_count }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555;">📅 <strong>Check-in</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555;">📅 <strong>Check-out</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555;">💳 <strong>Payment Method</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #333;">{{ ucfirst($booking->payment_method) }}</td>
                </tr>
            </table>

            <!-- Price Breakdown -->
            <div style="background: #f8fafc; border-radius: 10px; padding: 20px; margin: 25px 0;">
                <h3 style="font-size: 18px; color: #333; margin: 0 0 15px; font-weight: 600;">Price Breakdown</h3>
                <table style="width: 100%; font-size: 15px; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #555;">Room Price (per night)</td>
                        <td style="padding: 8px 0; text-align: right; color: #333;">Rp{{ number_format($booking->room_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #555;">Room Total ({{ $booking->night_count }} nights)</td>
                        <td style="padding: 8px 0; text-align: right; color: #333;">Rp{{ number_format($booking->room_price * $booking->night_count, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #555;">Tax (10%)</td>
                        <td style="padding: 8px 0; text-align: right; color: #333;">Rp{{ number_format($booking->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #555;">Service Fee (5%)</td>
                        <td style="padding: 8px 0; text-align: right; color: #333;">Rp{{ number_format($booking->service_charge, 0, ',', '.') }}</td>
                    </tr>
                    @if ($booking->promo_code || $booking->promo_code_id)
                        @php
                            $promo = $booking->promo_code_id ? \App\Models\CodePromotion::find($booking->promo_code_id) : null;
                            $effectiveDiscount = ($promo && $promo->discount_percent > 0)
                                ? ($booking->room_price * $booking->night_count * $promo->discount_percent / 100)
                                : ($booking->discount_amount ?? 0);
                            $discountDisplay = ($promo && $promo->discount_percent > 0)
                                ? $promo->discount_percent . '% (Rp' . number_format($effectiveDiscount, 0, ',', '.') . ')'
                                : ($booking->discount_amount > 0 ? 'Rp' . number_format($booking->discount_amount, 0, ',', '.') : 'None');
                        @endphp
                        <tr>
                            <td style="padding: 8px 0; color: #16a34a;">Promo Code</td>
                            <td style="padding: 8px 0; text-align: right; color: #16a34a;">{{ $booking->promo_code ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #16a34a;">Discount</td>
                            <td style="padding: 8px 0; text-align: right; color: #16a34a;">{{ $discountDisplay }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; color: #333; font-weight: 600; border-top: 1px solid #e2e8f0;">Total Amount</td>
                        @php
                            $calculatedTotal = ($booking->room_price * $booking->night_count) + $booking->tax + $booking->service_charge - $effectiveDiscount;
                        @endphp
                        <td style="padding: 8px 0; text-align: right; color: #3b82f6; font-weight: 600; border-top: 1px solid #e2e8f0;">Rp{{ number_format($calculatedTotal, 0, ',', '.') }}</td>
                    </tr>
                    @if (abs($calculatedTotal - $booking->total_price) > 0.01)
                        <tr>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Info -->
            <p style="font-size: 15px; color: #444; margin-top: 25px;">
                Please present this email upon <strong>check-in</strong>. If you have any questions or changes, feel free to contact us anytime.
            </p>

            <!-- CTA Button -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('booking.show', ['booking_number' => $booking->booking_number]) }}" 
                   style="display: inline-block; background-color: #2563eb; color: #fff; text-decoration: none;
                          padding: 12px 20px; border-radius: 6px; font-weight: 600; font-size: 14px;">
                    🔍 View Booking Details
                </a>
            </div>

            <p style="font-size: 15px; color: #444; margin-top: 40px;">Warm regards,<br><strong>Wonderful Indonesia - NTT Team</strong></p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f0f2f5; padding: 20px 40px; text-align: center; font-size: 12px; color: #888;">
            📩 This email was sent automatically. Please do not reply directly to this message.
        </div>
    </div>
</body>
</html>