<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $sale->receipt_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .receipt-container {
            background: white;
            max-width: 800px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .receipt-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .company-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .receipt-title {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 300;
        }

        .receipt-body {
            padding: 40px 30px 30px;
        }

        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-section h3 {
            font-size: 14px;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .info-item {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .info-label {
            font-size: 13px;
            color: #666;
            min-width: 120px;
            font-weight: 500;
        }

        .info-value {
            font-size: 14px;
            color: #333;
            font-weight: 600;
        }

        .receipt-number-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background: #f8f9fa;
        }

        .items-table th {
            padding: 15px 10px;
            text-align: left;
            font-size: 13px;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            border-bottom: 2px solid #667eea;
        }

        .items-table th:last-child,
        .items-table td:last-child {
            text-align: right;
        }

        .items-table th:nth-child(2),
        .items-table td:nth-child(2) {
            text-align: center;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        .items-table tbody tr:hover {
            background: #f8f9fa;
        }

        .items-table td {
            padding: 18px 10px;
            font-size: 14px;
            color: #333;
        }

        .item-name {
            font-weight: 600;
            color: #222;
        }

        .totals-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            font-size: 15px;
        }

        .total-row.subtotal {
            color: #666;
            border-bottom: 1px solid #e0e0e0;
        }

        .total-row.tax,
        .total-row.discount {
            color: #666;
            font-size: 14px;
        }

        .total-row.grand-total {
            border-top: 2px solid #667eea;
            padding-top: 15px;
            margin-top: 10px;
            font-size: 20px;
            font-weight: 700;
            color: #667eea;
        }

        .payment-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .payment-card {
            background: white;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .payment-card-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .payment-card-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .payment-card.change .payment-card-value {
            color: #10b981;
        }

        .receipt-footer {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-top: 2px dashed #e0e0e0;
        }

        .thank-you {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .footer-text {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }

            .print-button {
                display: none;
            }

            .receipt-header {
                background: #667eea;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .totals-section,
            .receipt-footer {
                background: #f8f9fa;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media (max-width: 768px) {
            .receipt-info {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .payment-info {
                grid-template-columns: 1fr;
            }

            .print-button {
                position: static;
                margin: 0 auto 20px;
            }
        }
    </style>
</head>

<body>
    <button class="print-button" onclick="window.print()">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" />
        </svg>
        Print Receipt
    </button>

    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="company-logo">SM</div>
            <div class="company-name">StockMaster</div>
            <div class="receipt-title">Sales Receipt</div>
        </div>

        <!-- Body -->
        <div class="receipt-body">
            <!-- Receipt Info -->
            <div class="receipt-info">
                <div class="info-section">
                    <h3>Receipt Details</h3>
                    <div class="receipt-number-badge">{{ $sale->receipt_number }}</div>
                    <div class="info-item">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ $sale->created_at->format('d-m-Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Time:</span>
                        <span class="info-value">{{ $sale->created_at->format('h:i A') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cashier:</span>
                        <span class="info-value">{{ $sale->user->name }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <h3>Customer Information</h3>
                    @if($sale->customer)
                        <div class="info-item">
                            <span class="info-label">Name:</span>
                            <span class="info-value">{{ $sale->customer->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $sale->customer->phone }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $sale->customer->email }}</span>
                        </div>
                    @else
                        <div class="info-item">
                            <span class="info-value">Walk-in Customer</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td class="item-name">{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="totals-section">
                <div class="total-row subtotal">
                    <span>Subtotal</span>
                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                @if($sale->tax_rate > 0)
                    <div class="total-row tax">
                        <span>Tax ({{ number_format($sale->tax_rate, 2) }}%)</span>
                        <span>${{ number_format($sale->tax_amount, 2) }}</span>
                    </div>
                @endif
                @if($sale->discount_amount > 0)
                    <div class="total-row discount">
                        <span>Discount</span>
                        <span>-${{ number_format($sale->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="total-row grand-total">
                    <span>Grand Total</span>
                    <span>${{ number_format($sale->total_amount + $sale->tax_amount - $sale->discount_amount, 2) }}</span>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="payment-info">
                <div class="payment-card">
                    <div class="payment-card-label">Payment Method</div>
                    <div class="payment-card-value">{{ ucfirst($sale->payment_method) }}</div>
                </div>
                <div class="payment-card">
                    <div class="payment-card-label">Amount Paid</div>
                    <div class="payment-card-value">${{ number_format($sale->paid_amount, 2) }}</div>
                </div>
                <div class="payment-card change">
                    <div class="payment-card-label">Change</div>
                    <div class="payment-card-value">
                        ${{ number_format($sale->paid_amount - ($sale->total_amount + $sale->tax_amount - $sale->discount_amount), 2) }}
                    </div>
                </div>
            </div>

            @if($sale->notes)
                <div
                    style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong style="color: #856404;">Notes:</strong>
                    <p style="color: #856404; margin-top: 5px;">{{ $sale->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <div class="thank-you">Thank You!</div>
            <div class="footer-text">
                We appreciate your business.<br>
                Please visit us again soon!
            </div>
        </div>
    </div>
</body>

</html>