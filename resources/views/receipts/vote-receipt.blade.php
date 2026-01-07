<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6f42c1;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #6f42c1;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
        }
        .receipt-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .receipt-info table {
            width: 100%;
        }
        .receipt-info td {
            padding: 5px 0;
        }
        .receipt-info td:first-child {
            font-weight: bold;
            width: 150px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #6f42c1;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #6f42c1;
        }
        .campaign-details {
            background: #fff;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .vote-list {
            margin: 15px 0;
        }
        .vote-item {
            background: #f8f9fa;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 4px solid #6f42c1;
            border-radius: 3px;
        }
        .vote-item .candidate-name {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }
        .vote-item .position {
            font-size: 11px;
            color: #666;
        }
        .vote-item .party {
            font-size: 11px;
            color: #666;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .verification-code {
            background: #fff3cd;
            padding: 10px;
            border: 1px dashed #ffc107;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
        }
        .verification-code strong {
            font-size: 14px;
            color: #856404;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-info {
            background: #17a2b8;
            color: white;
        }
        .important-notice {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 11px;
        }
        .important-notice strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">🗳️ Vote2Voice</div>
        <div class="subtitle">Official Voting Receipt</div>
    </div>

    <!-- Receipt Information -->
    <div class="receipt-info">
        <table>
            <tr>
                <td>Receipt Number:</td>
                <td><strong>{{ $receiptNumber }}</strong></td>
            </tr>
            <tr>
                <td>Date & Time:</td>
                <td>{{ $voteDate->format('F d, Y - h:i A') }}</td>
            </tr>
            <tr>
                <td>Voter Name:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Voter Email:</td>
                <td>{{ $user->email }}</td>
            </tr>
        </table>
    </div>

    <!-- Campaign Details -->
    <div class="section-title">Campaign Details</div>
    <div class="campaign-details">
        <table style="width: 100%;">
            <tr>
                <td style="font-weight: bold; width: 150px;">Campaign Title:</td>
                <td>{{ $campaign->title }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Description:</td>
                <td>{{ $campaign->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Category:</td>
                <td><span class="badge badge-info">{{ ucfirst($campaign->category) }}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Campaign Period:</td>
                <td>{{ $campaign->start_date->format('M d, Y') }} - {{ $campaign->end_date->format('M d, Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Votes Cast -->
    <div class="section-title">Your Votes ({{ $candidates->count() }})</div>
    <div class="vote-list">
        @foreach($candidates as $candidate)
            <div class="vote-item">
                <div class="candidate-name">✓ {{ $candidate->name }}</div>
                @if($candidate->positionRelation)
                    <div class="position">Position: {{ $candidate->positionRelation->title }}</div>
                @elseif($candidate->position)
                    <div class="position">Position: {{ $candidate->position }}</div>
                @endif
                @if($candidate->party_list)
                    <div class="party">Party/Organization: {{ $candidate->party_list }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Verification Code -->
    <div class="verification-code">
        <strong>Verification Code: {{ strtoupper(substr(md5($receiptNumber), 0, 12)) }}</strong>
    </div>

    <!-- Important Notice -->
    <div class="important-notice">
        <strong>⚠️ Important Notice:</strong><br>
        • This is an official voting receipt generated by Vote2Voice system.<br>
        • Keep this receipt for your records.<br>
        • Your vote has been securely recorded and cannot be changed.<br>
        • For any inquiries, please contact the election administrator with your receipt number.
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Vote2Voice - Secure Electronic Voting System</strong></p>
        <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        <p style="margin-top: 10px; font-size: 9px;">
            This is a computer-generated receipt and does not require a signature.<br>
            © {{ now()->year }} Vote2Voice. All rights reserved.
        </p>
    </div>
</body>
</html>
