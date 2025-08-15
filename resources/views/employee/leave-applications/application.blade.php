@extends('layouts.app-admin')

@section('title', 'Leave Application')

@section('content')
<div class="leave-application-container">
    <div class="application-card">
        <!-- Header Section -->
        <div class="application-header">
            <div class="header-background">
                <div class="header-pattern"></div>
            </div>
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" alt="BD Logo" onerror="this.style.display='none'">
                    </div>
                    <div class="org-info">
                        <h1>GLOBAL DEVELOPMENT & RESEARCH INITIATIVE</h1>
                        <p class="address">Block-H, Plot-H/1, Floor-08, Flat-8/A, Bonosree Main Road, Dhaka-1219</p>
                        <p class="contact">📞 +880 1829520879 | 📧 info@gdri.org</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Title -->
        <div class="application-title">
            <h2>📋 LEAVE APPLICATION FORM</h2>
            <div class="title-underline"></div>
        </div>

        <!-- Application Content -->
        <div class="application-content">
            <!-- Employee Information -->
            <div class="section">
                <div class="section-header">
                    <h3>👤 Employee Information</h3>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <div class="info-value">{{ $application->user->name ?? 'Null' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Employee ID</label>
                        <div class="info-value">{{ $application->user->profile->employee_id ?? 'Null' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Office Location</label>
                        <div class="info-value">{{ $application->user->profile->work_office ?? 'Null' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Designation</label>
                        <div class="info-value">{{ $application->user->profile->designation ?? 'Null' }}</div>
                    </div>
                </div>
            </div>

            <!-- Leave Details -->
            <div class="section">
                <div class="section-header">
                    <h3>📅 Leave Details</h3>
                </div>
                <div class="info-grid">
                    <div class="info-item full-width">
                        <label>Type of Leave</label>
                        <div class="info-value leave-type">
                            <span class="badge badge-{{ strtolower($application->type) }}">
                                {{ ucfirst($application->type) }} Leave
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <label>From Date</label>
                        <div class="info-value">{{ \Carbon\Carbon::parse($application->start_date)->format('d M Y') }}</div>
                    </div>
                    <div class="info-item">
                        <label>To Date</label>
                        <div class="info-value">{{ \Carbon\Carbon::parse($application->end_date)->format('d M Y') }}</div>
                    </div>
                    <div class="info-item">
                        <label>Total Days</label>
                        <div class="info-value total-days">
                            {{ \Carbon\Carbon::parse($application->start_date)->diffInDays(\Carbon\Carbon::parse($application->end_date)) + 1 }} Days
                        </div>
                    </div>
                    <div class="info-item">
                        <label>Application Date</label>
                        <div class="info-value">{{ \Carbon\Carbon::parse($application->apply_date)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Reason Section -->
            <div class="section">
                <div class="section-header">
                    <h3>📝 Reason for Leave</h3>
                </div>
                <div class="reason-box" style="text-align: justify;font-size: 8px !important;color:#2c3e50 !important;">
                    {!! $application->reason ?? 'No reason provided' !!}
                </div>
            </div>

            <!-- Contact Information -->
            <div class="section">
                <div class="section-header">
                    <h3>📞 Contact Information During Leave</h3>
                </div>
                <div class="info-grid">
                    <div class="info-item full-width">
                        <label>Contact Address</label>
                        <div class="info-value">{{ $application->user->profile->address.', '.$application->user->profile->thana.', '.$application->user->profile->district.', '.$application->user->profile->division ?? 'Null' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Contact Phone</label>
                        <div class="info-value">{{ $application->user->phone ?? 'Null' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <div class="info-value">{{ $application->user->email ?? 'Null' }}</div>
                    </div>
                </div>
            </div>

            <!-- Leave Summary Section -->
            <div class="section">
                <div class="section-header">
                    <h3>📈 Leave Summary ({{ date('Y') }})</h3>
                </div>
                <div class="info-grid">
                    @php
                        // Calculate total leave days taken this year
                        $currentYear = date('Y');
                        $totalLeaveDays = \App\Models\LeaveApplication::where('user_id', $application->user_id)
                            ->where('status', 'approved')
                            ->whereYear('start_date', $currentYear)
                            ->get()
                            ->sum(function($leave) {
                                return \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
                            });
                        
                        // Calculate leave by type
                        $leaveByType = \App\Models\LeaveApplication::where('user_id', $application->user_id)
                            ->where('status', 'approved')
                            ->whereYear('start_date', $currentYear)
                            ->get()
                            ->groupBy('type')
                            ->map(function($leaves) {
                                return $leaves->sum(function($leave) {
                                    return \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
                                });
                            });
                    @endphp
                    
                    <div class="info-item">
                        <label>Total Days Taken</label>
                        <div class="info-value total-days">{{ $totalLeaveDays }} Days</div>
                    </div>
                    
                    @foreach($leaveByType as $type => $days)
                        <div class="info-item">
                            <label>{{ ucfirst($type) }} Leave</label>
                            <div class="info-value">
                                <span class="badge badge-{{ strtolower($type) }}">{{ $days }} Days</span>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="info-item">
                        <label>Remaining Balance</label>
                        <div class="info-value">
                            @php
                                // Assuming 30 days annual leave allowance
                                $annualAllowance = 30;
                                $remaining = $annualAllowance - $totalLeaveDays;
                            @endphp
                            <span class="badge {{ $remaining > 10 ? 'badge-annual' : ($remaining > 5 ? 'badge-emergency' : 'badge-sick') }}">
                                {{ max(0, $remaining) }} Days
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Section -->
            <div class="section">
                <div class="section-header">
                    <h3>📊 Application Status</h3>
                </div>
                <div class="status-section">
                    <div class="status-badge status-{{ strtolower($application->status) }}">
                        <span class="status-icon">
                            @if($application->status == 'approved')
                                ✅
                            @elseif($application->status == 'rejected')
                                ❌
                            @else
                                ⏳
                            @endif
                        </span>
                        {{ ucfirst($application->status) }}
                    </div>
                    @if($application->remarks)
                        <div class="remarks-box">
                            <strong>Remarks:</strong> {{ $application->remarks }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Signature Section -->
            <div class="section">
                <div class="section-header">
                    <h3>✍️ Digital Signatures</h3>
                </div>
                <div class="signature-grid">
                    <div class="signature-box">
                        <div class="signature-area">
                            @if($application->signature)
                                <img src="{{ asset($application->signature) }}" alt="Employee Signature" class="signature-img">
                            @else
                                <div class="signature-placeholder">No Signature</div>
                            @endif
                        </div>
                        <div class="signature-label">
                            <strong>Employee Signature</strong>
                            <small>{{ \Carbon\Carbon::parse($application->created_at)->format('d M Y') }}</small>
                        </div>
                    </div>
                    
                    <div class="signature-box">
                        <div class="signature-area">
                            @if($application->supervisor_signature)
                                <img src="{{ asset($application->supervisor_signature) }}" alt="Supervisor Signature" class="signature-img">
                            @else
                                <div class="signature-placeholder">Pending</div>
                            @endif
                        </div>
                        <div class="signature-label">
                            <strong>Immediate Supervisor</strong>
                            <small>{{ $application->supervisor_approved_at ? \Carbon\Carbon::parse($application->supervisor_approved_at)->format('d M Y') : 'Pending' }}</small>
                        </div>
                    </div>

                    <div class="signature-box">
                        <div class="signature-area">
                            @if($application->hr_signature)
                                <img src="{{ asset($application->hr_signature) }}" alt="HR Signature" class="signature-img">
                            @else
                                <div class="signature-placeholder">Pending</div>
                            @endif
                        </div>
                        <div class="signature-label">
                            <strong>HR Department</strong>
                            <small>{{ $application->hr_approved_at ? \Carbon\Carbon::parse($application->hr_approved_at)->format('d M Y') : 'Pending' }}</small>
                        </div>
                    </div>

                    <div class="signature-box">
                        <div class="signature-area">
                            @if($application->final_signature)
                                <img src="{{ asset($application->final_signature) }}" alt="Final Authority Signature" class="signature-img">
                            @else
                                <div class="signature-placeholder">Pending</div>
                            @endif
                        </div>
                        <div class="signature-label">
                            <strong>Final Authority</strong>
                            <small>{{ $application->final_approved_at ? \Carbon\Carbon::parse($application->final_approved_at)->format('d M Y') : 'Pending' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="application-footer">
            <div class="footer-info">
                <p><strong>Application ID:</strong> {{ $application->id ?? 'Null' }}</p>
                <p><strong>Generated on:</strong> {{ now()->format('d M Y, h:i A') }}</p>
            </div>
            <div class="footer-actions">
                <button onclick="window.print()" class="btn btn-print">🖨️ Print</button>
                <button onclick="downloadPDF()" class="btn btn-download">📄 Download PDF</button>
            </div>
        </div>
    </div>
</div>

<style>
    .leave-application-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .application-card {
        width: 210mm;
        max-width: 100%;
        height: 297mm;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        animation: slideIn 0.6s ease-out;
        display: flex;
        flex-direction: column;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .application-header {
        position: relative;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 8px 15px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .header-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0.1;
    }

    .header-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(255,255,255,0.2) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.2) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(255,255,255,0.1) 0%, transparent 50%);
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .logo-section {
        display: flex;
        align-items: center;
        justify-content: start;
        gap: 20px;
    }

    .logo {
        width: 160px !important;
        height: 60px !important;
        border-radius: 10px;
        background: #fff;
        position: relative;
        top: 2px;
        left: 2px;
    }

    .logo img {
        width: 100px;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .logo-placeholder {
        font-size: 14px;
    }

    .org-info {
        text-align: center;
        margin: 0 20px;
        width: 50%;
    }

    .org-info h1 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .org-info .address, .org-info .contact {
        margin: 1px 0;
        font-size: 12px;
        color: #bdc3c7;
    }

    .application-title {
        text-align: center;
        padding: 8px;
        background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
        flex-shrink: 0;
        margin-top: 15px;
    }

    .application-title h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .title-underline {
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, #3498db, #9b59b6);
        margin: 4px auto;
        border-radius: 2px;
    }

    .application-content {
        padding: 8px 15px;
        flex: 1;
        overflow: hidden;
    }

    .section {
        margin-bottom: 8px;
        background: #f8f9fa;
        border-radius: 6px;
        padding: 8px;
        border-left: 3px solid #3498db;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .section:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .section-header {
        margin-bottom: 6px;
    }

    .section-header h3 {
        margin: 0;
        font-size: 11px;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 6px;
    }

    .info-item {
        background: white;
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        transition: border-color 0.3s ease;
    }

    .info-item:hover {
        border-color: #3498db;
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .info-item label {
        display: block;
        font-size: 8px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .info-value {
        font-size: 10px;
        font-weight: 500;
        color: #2c3e50;
        min-height: 12px;
    }

    .badge {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-casual { background: #e3f2fd; color: #1976d2; }
    .badge-sick { background: #fce4ec; color: #c2185b; }
    .badge-annual { background: #e8f5e8; color: #388e3c; }
    .badge-emergency { background: #fff3e0; color: #f57c00; }
    .badge-maternity { background: #f3e5f5; color: #7b1fa2; }

    .total-days {
        font-weight: 700;
        color: #2c3e50;
        font-size: 10px;
    }

    .reason-box {
        background: white;
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        font-size: 9px;
        line-height: 1.3;
        color: #2c3e50;
        min-height: 25px;
    }

    .status-section {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 9px;
        text-transform: capitalize;
    }

    .status-approved { background: #d4edda; color: #155724; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-rejected { background: #f8d7da; color: #721c24; }

    .remarks-box {
        flex: 1;
        background: white;
        padding: 4px;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        font-size: 9px;
    }

    .signature-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
    }

    .signature-box {
        background: white;
        border-radius: 4px;
        padding: 4px;
        text-align: center;
        border: 1px solid #e9ecef;
        transition: border-color 0.3s ease;
    }

    .signature-area {
        height: 25px;
        border: 1px dashed #dee2e6;
        border-radius: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 3px;
        background: #f8f9fa;
    }

    .signature-img {
        max-width: 100%;
        max-height: 20px;
        object-fit: contain;
    }

    .signature-placeholder {
        color: #6c757d;
        font-size: 7px;
        font-style: italic;
    }

    .signature-label {
        font-size: 7px;
    }

    .signature-label strong {
        display: block;
        margin-bottom: 1px;
        color: #2c3e50;
    }

    .signature-label small {
        color: #6c757d;
    }

    .application-footer {
        background: #f8f9fa;
        padding: 6px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e9ecef;
        flex-wrap: wrap;
        gap: 6px;
        flex-shrink: 0;
    }

    .footer-info p {
        margin: 0;
        font-size: 8px;
        color: #6c757d;
    }

    .footer-actions {
        display: flex;
        gap: 4px;
    }

    .btn {
        padding: 4px 8px;
        border: none;
        border-radius: 10px;
        font-size: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .btn-print {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-download {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    @media print {
        .leave-application-container {
            background: white;
            padding: 0;
            min-height: auto;
        }
        .application-card {
            box-shadow: none;
            border-radius: 0;
            width: 100%;
            height: auto;
            min-height: 297mm;
            max-height: 297mm;
        }
        .footer-actions {
            display: none;
        }
        body {
            margin: 0;
            padding: 0;
        }
        @page {
            size: A4;
            margin: 0;
        }
    }

    @media (max-width: 768px) {
        .logo-section {
            flex-direction: column;
            gap: 8px;
        }
        .org-info {
            margin: 0;
        }
        .org-info h1 {
            font-size: 12px;
        }
        .application-content {
            padding: 10px;
        }
        .application-footer {
            padding: 10px;
            flex-direction: column;
            text-align: center;
        }
        .signature-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<script>
    function downloadPDF() {
        // Add PDF download functionality here
        alert('PDF download functionality would be implemented here');
    }

    // Add smooth scrolling animations
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    });
</script>
@endsection
