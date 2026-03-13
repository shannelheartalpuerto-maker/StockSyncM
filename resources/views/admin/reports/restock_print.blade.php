<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restock List - {{ date('Y-m-d') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #4a90e2;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #777;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-out {
            background-color: #ffebee;
            color: #c62828;
        }
        .status-low {
            background-color: #fff3e0;
            color: #ef6c00;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            button {
                display: none;
            }
        }
        .print-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .print-btn:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right;">
        <button onclick="window.print()" class="print-btn">Print Report</button>
        <button onclick="window.close()" class="print-btn" style="background-color: #6c757d;">Close</button>
    </div>

    <div class="header">
        <h1>Restock Purchase List</h1>
        <p>Generated on: {{ date('F j, Y, g:i a') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th class="text-center">Current Stock</th>
                <th class="text-center">Threshold</th>
                <th class="text-center">Status</th>
                <th class="text-center">Qty to Restock</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($restockProducts as $product)
                <tr>
                    <td><code>{{ $product->code }}</code></td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $product->quantity }}</td>
                    <td class="text-center">{{ $product->low_stock_threshold }}</td>
                    <td class="text-center">
                        @if($product->quantity <= 0)
                            <span class="status-badge status-out">Out of Stock</span>
                        @else
                            <span class="status-badge status-low">Low Stock</span>
                        @endif
                    </td>
                    <td class="text-center" style="font-weight: bold; color: #c62828;">{{ number_format($product->qty_to_restock) }}</td>
                    <td style="width: 150px; height: 30px; border-bottom: 1px solid #ccc;"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No items currently require restocking.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} StockSync Inventory Management System</p>
        <p>This report is for internal use only.</p>
    </div>

    <script>
        // Auto-trigger print dialog
        window.onload = function() {
            // Optional: window.print();
        }
    </script>
</body>
</html>
