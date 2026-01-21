<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Item Cards - {{ $event->venue->name ?? 'Event' }} - {{ \Carbon\Carbon::parse($event->starts_at)->format('d M Y') }}</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f3f4f6;
            padding: 1rem;
        }

        .print-header {
            text-align: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .print-header h1 {
            font-size: 1.5rem;
            color: #1f2937;
        }

        .print-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .print-btn:hover {
            background: #2563eb;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .item-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            page-break-inside: avoid;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
        }

        .item-id {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .item-id span {
            font-size: 1rem;
            font-weight: 400;
            color: #6b7280;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-broken { background: #e5e7eb; color: #374151; }
        .status-assessed { background: #bfdbfe; color: #1e40af; }
        .status-fixed { background: #bbf7d0; color: #166534; }
        .status-awaitingparts { background: #fef08a; color: #854d0e; }
        .status-unfixable { background: #fecaca; color: #991b1b; }

        .card-section {
            margin-bottom: 1rem;
        }

        .card-section:last-child {
            margin-bottom: 0;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .section-value {
            font-size: 1rem;
            color: #1f2937;
            line-height: 1.5;
        }

        .section-value.large {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-row {
            display: flex;
            gap: 1rem;
        }

        .card-row .card-section {
            flex: 1;
        }

        .powered-badge {
            display: inline-block;
            padding: 0.125rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            background: #f3f4f6;
            color: #374151;
        }

        .powered-mains { background: #fee2e2; color: #991b1b; }
        .powered-batteries { background: #dcfce7; color: #166534; }
        .powered-no { background: #e5e7eb; color: #374151; }

        .customer-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }

        /* Print styles - 3 columns */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0.5cm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                background: white;
                padding: 0;
                font-size: 9pt;
            }

            .print-header {
                display: none;
            }

            .cards-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.4cm;
            }

            .item-card {
                max-width: 100%;
                border: 2px solid #000 !important;
                border-radius: 0 !important;
                box-shadow: none;
                padding: 0.5rem;
                page-break-inside: avoid;
            }

            .card-header {
                padding-bottom: 0.3rem;
                margin-bottom: 0.4rem;
                border-bottom: 2px solid #000 !important;
            }

            .item-id {
                font-size: 1.2rem;
            }

            .item-id span {
                font-size: 0.7rem;
            }

            .status-badge {
                font-size: 0.65rem;
                padding: 0.1rem 0.4rem;
                border: 1px solid #000 !important;
                border-radius: 0 !important;
            }

            .card-section {
                margin-bottom: 0.4rem;
            }

            .section-label {
                font-size: 0.6rem;
                margin-bottom: 0.1rem;
            }

            .section-value {
                font-size: 0.75rem;
                line-height: 1.3;
            }

            .section-value.large {
                font-size: 0.85rem;
            }

            .powered-badge {
                font-size: 0.65rem;
                padding: 0.1rem 0.3rem;
                border: 1px solid #000 !important;
                border-radius: 0 !important;
            }

            .customer-box {
                padding: 0.3rem;
                font-size: 0.75rem;
                border: 1px solid #166534 !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-header">
        <h1>Item Cards</h1>
        <p>{{ $event->venue->name ?? 'Event' }} - {{ \Carbon\Carbon::parse($event->starts_at)->format('l jS F Y') }}</p>
        <p>{{ $items->count() }} item(s)</p>
        <button class="print-btn" onclick="window.print()">Print Cards</button>
    </div>

    <div class="cards-container">
        @foreach ($items as $item)
        <div class="item-card">
            <div class="card-header">
                <div class="item-id">
                    <span>ID</span> #{{ $item->id }}
                </div>
                @php
                    $statusClass = 'status-' . $item->status;
                    $statusOptions = \App\Models\Item::statusOptions();
                    $statusDisplay = $statusOptions[$item->status]['display'] ?? ucfirst($item->status);
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ $statusDisplay }}</span>
            </div>

            <div class="card-section">
                <div class="section-label">Description</div>
                <div class="section-value large">{{ $item->description }}</div>
            </div>

            <div class="card-section">
                <div class="section-label">Category</div>
                <div class="section-value">{{ $item->category->name ?? 'Uncategorized' }}</div>
            </div>

            <div class="card-section">
                <div class="section-label">Issue / Problem</div>
                <div class="section-value">{{ $item->issue }}</div>
            </div>

            <div class="card-row">
                <div class="card-section">
                    <div class="section-label">Power</div>
                    @php
                        $poweredClass = 'powered-' . $item->powered;
                    @endphp
                    <span class="powered-badge {{ $poweredClass }}">{{ ucfirst($item->powered) }}</span>
                </div>
            </div>

            <div class="card-section">
                <div class="section-label">Customer</div>
                <div class="customer-box">
                    @if($item->user)
                        <strong>{{ $item->user->name }}</strong>
                        @if($item->user->phone)
                            <br>{{ $item->user->phone }}
                        @endif
                    @else
                        <em style="color: #6b7280;">Anonymous / Walk-in</em>
                    @endif
                </div>
            </div>

        </div>
        @endforeach
    </div>
</body>
</html>
