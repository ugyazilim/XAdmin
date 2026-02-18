<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yönetim Paneli') - Oba Ticaret</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    
    <!-- SortableJS for drag-and-drop -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --sidebar-bg: #1a1d29;
            --sidebar-hover: #252836;
            --content-bg: #f8f9fa;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --border-radius: 16px;
            --border-radius-sm: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            background-attachment: fixed;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Sidebar - Modern Design */
        #sidebar-wrapper {
            background: #0f172a;
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
        }

        @media (max-width: 767.98px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
                width: 280px;
            }

            #sidebar-wrapper.show {
                transform: translateX(0);
                box-shadow: 4px 0 40px rgba(0, 0, 0, 0.4);
            }

            #sidebar-wrapper.show::before {
                content: '';
                position: fixed;
                top: 0;
                left: 280px;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.6);
                z-index: -1;
                backdrop-filter: blur(4px);
            }
        }

        .sidebar-heading {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem 1.25rem;
            color: white;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .sidebar-heading::before {
            content: '';
            position: absolute;
            top: -100%;
            right: -100%;
            width: 300%;
            height: 300%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
            pointer-events: none;
            animation: shimmer 8s infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50%, 50%) rotate(180deg); }
        }

        .sidebar-heading h4 {
            font-weight: 900;
            font-size: 1.5rem;
            margin: 0 0 0.375rem 0;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            line-height: 1.2;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-heading h4 .burger-icon {
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .sidebar-heading h4 .brand-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-heading small {
            opacity: 0.85;
            font-size: 0.75rem;
            font-weight: 500;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
            display: block;
            margin-top: 0.25rem;
        }

        .list-group-item {
            border: none;
            background: transparent;
            color: #94a3b8;
            padding: 1rem 1.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.9375rem;
            margin: 0.25rem 1rem;
            border-radius: 12px;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .list-group-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 4px 4px 0;
            transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .list-group-item:hover {
            background: rgba(102, 126, 234, 0.12);
            color: #ffffff;
            transform: translateX(6px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .list-group-item:hover::before {
            height: 60%;
        }

        .list-group-item.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2) 0%, rgba(102, 126, 234, 0.08) 100%);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.25);
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .list-group-item.active::before {
            height: 70%;
        }

        .list-group-item i {
            width: 22px;
            font-size: 1.25rem;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .list-group-item:hover i {
            transform: scale(1.15);
        }

        .list-group-item.active i {
            color: #667eea;
        }

        /* Top Navbar - Modern Design */
        .top-navbar {
            background: rgba(255, 255, 255, 0.98);
            padding: 1.5rem 2.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 999;
            margin-left: 280px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(20px) saturate(180%);
            transition: all 0.3s ease;
        }

        @media (max-width: 767.98px) {
            .top-navbar {
                margin-left: 0;
                padding: 1.25rem 1.5rem;
            }

            .quick-actions-btn span {
                display: none;
            }

            .quick-actions-btn {
                padding: 0.625rem;
                min-width: 42px;
            }
        }

        @media (max-width: 991.98px) {
            .quick-actions-btn span {
                display: none;
            }

            .quick-actions-btn {
                padding: 0.625rem;
                min-width: 42px;
            }
        }

        .top-navbar h5 {
            font-weight: 800;
            font-size: 1.5rem;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .top-navbar .navbar-subtitle {
            font-size: 0.8125rem;
            color: #64748b;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        .top-navbar .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.125rem;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .top-navbar .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .top-navbar .dropdown-toggle {
            color: #0f172a;
            font-weight: 600;
            padding: 0;
            border: none;
            background: transparent;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .top-navbar .dropdown-toggle:focus {
            box-shadow: none;
        }

        .top-navbar .dropdown-menu {
            border: none;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            padding: 0.75rem;
            margin-top: 0.75rem;
            min-width: 240px;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .top-navbar .dropdown-item {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .top-navbar .dropdown-item i {
            width: 20px;
            font-size: 1.125rem;
        }

        .top-navbar .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.08) 0%, rgba(102, 126, 234, 0.04) 100%);
            color: #667eea;
            transform: translateX(4px);
        }

        .top-navbar .dropdown-item.text-danger:hover {
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #ef4444;
        }

        .top-navbar .user-info {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 0.5rem;
        }

        .top-navbar .user-info .user-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.9375rem;
        }

        .top-navbar .user-info .user-email {
            font-size: 0.8125rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        /* Main Content */
        #page-content-wrapper {
            margin-left: 280px;
            padding: 2.5rem;
            min-height: 100vh;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        @media (max-width: 767.98px) {
            #page-content-wrapper {
                margin-left: 0;
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 991.98px) {
            #page-content-wrapper {
                padding: 1.5rem;
            }
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius-sm);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            box-shadow: var(--card-shadow-lg);
            transform: translateY(-4px);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .card-header {
            background: linear-gradient(to bottom, #ffffff 0%, #f9fafb 100%);
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.125rem;
            color: #1f2937;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Modern Buttons */
        .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border: none;
            font-size: 0.9375rem;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-success {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.4);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.0625rem;
        }

        /* KPI Cards */
        .kpi-card {
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .kpi-card h5 {
            font-size: 0.875rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-card h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }

        .kpi-card i {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.2;
        }

        /* Modern KPI Cards */
        .kpi-card-modern {
            border-radius: var(--border-radius);
            padding: 2rem;
            color: white;
            box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.12), 0 4px 8px -2px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        .kpi-card-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            pointer-events: none;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .kpi-card-modern::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .kpi-card-modern:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 24px 32px -8px rgba(0, 0, 0, 0.2), 0 12px 16px -4px rgba(0, 0, 0, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .kpi-card-modern:hover::before {
            transform: rotate(45deg) scale(1.2);
        }

        .kpi-card-modern:hover::after {
            transform: scaleX(1);
        }

        .kpi-label {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.95;
            margin-bottom: 0.75rem;
        }

        .kpi-value {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.2;
            margin: 0.5rem 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .kpi-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 4rem;
            opacity: 0.25;
            transition: all 0.3s ease;
        }

        .kpi-card-modern:hover .kpi-icon {
            opacity: 0.35;
            transform: translateY(-50%) scale(1.1) rotate(5deg);
        }

        .kpi-change {
            font-size: 0.8125rem;
            font-weight: 500;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        /* Tables */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Table Container Padding - Global */
        .table-responsive {
            padding: 2px !important;
        }

        .card-body .table-responsive,
        .card-body > .table:not(.table-sm) {
            padding: 2px !important;
        }

        /* Card body with p-0 override for tables */
        .card-body.p-0 .table-responsive {
            padding: 2px !important;
        }

        .table thead th {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6b7280;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f9fafb;
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: var(--card-shadow);
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
            }

            #sidebar-wrapper.show {
                transform: translateX(0);
            }

            #page-content-wrapper,
            .top-navbar {
                margin-left: 0;
            }
        }

        /* Loading Spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        /* Drag Handle */
        .drag-handle {
            cursor: move;
            color: #9ca3af;
            padding: 0.5rem;
        }

        .drag-handle:hover {
            color: #667eea;
        }

        /* Icon Input Groups */
        .input-group-icon {
            position: relative;
        }

        .input-group-icon .input-group-text {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            z-index: 5;
            border-right: none;
            background: transparent;
            padding-left: 1rem;
            color: #6b7280;
        }

        .input-group-icon .form-control,
        .input-group-icon .form-select {
            padding-left: 3rem;
        }

        .input-group-icon .form-control:focus,
        .input-group-icon .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Sidebar Footer */
        .sidebar-footer {
            margin-top: auto;
            background: rgba(0, 0, 0, 0.3);
            padding: 1.5rem 1.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
            text-align: center;
        }

        .sidebar-footer small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            display: block;
            text-align: center;
        }

        .sidebar-footer .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            padding: 0.5rem;
            background: rgba(102, 126, 234, 0.15);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Scrollbar Styling */
        .list-group-flush::-webkit-scrollbar {
            width: 6px;
        }

        .list-group-flush::-webkit-scrollbar-track {
            background: transparent;
        }

        .list-group-flush::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .list-group-flush::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Quick Actions Button */
        .quick-actions-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .quick-actions-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .quick-actions-btn i {
            font-size: 1.125rem;
        }

        .quick-actions-menu {
            min-width: 280px;
            padding: 0.75rem;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            background: white;
        }

        .quick-action-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #334155;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .quick-action-item:last-child {
            margin-bottom: 0;
        }

        .quick-action-item:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.08) 0%, rgba(102, 126, 234, 0.04) 100%);
            color: #667eea;
            transform: translateX(4px);
        }

        .quick-action-item i {
            width: 24px;
            font-size: 1.25rem;
            text-align: center;
        }

        .quick-action-item .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .quick-action-item.primary .action-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .quick-action-item.success .action-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .quick-action-item.warning .action-icon {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .quick-action-item.danger .action-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .quick-action-item .action-text {
            flex: 1;
        }

        .quick-action-item .action-text strong {
            display: block;
            font-size: 0.9375rem;
            margin-bottom: 0.125rem;
        }

        .quick-action-item .action-text small {
            font-size: 0.75rem;
            color: #64748b;
            opacity: 0.8;
        }


        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        @media (max-width: 767.98px) {
            .welcome-section {
                padding: 1.5rem;
            }
        }

        /* Pagination Styles */
        .pagination {
            margin: 0 !important;
            padding: 0.75rem 1rem !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 0.25rem !important;
            font-size: 0.875rem !important;
        }

        .pagination .page-item {
            margin: 0 !important;
            list-style: none !important;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border-radius: 8px !important;
            border: 1px solid #e5e7eb !important;
            color: #6b7280 !important;
            background: white !important;
            transition: all 0.2s ease !important;
            min-width: 36px !important;
            height: 36px !important;
            text-align: center !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            text-decoration: none !important;
            box-sizing: border-box !important;
        }

        .pagination .page-link:hover:not(.disabled) {
            background: #f3f4f6 !important;
            border-color: #667eea !important;
            color: #667eea !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.15) !important;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: white !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3) !important;
        }

        .pagination .page-item.disabled .page-link {
            background: #f9fafb !important;
            border-color: #e5e7eb !important;
            color: #d1d5db !important;
            cursor: not-allowed !important;
            opacity: 0.5 !important;
            pointer-events: none !important;
        }

        .pagination .page-item.disabled .page-link:hover {
            transform: none !important;
            box-shadow: none !important;
            background: #f9fafb !important;
        }

        .pagination .page-link svg {
            width: 14px !important;
            height: 14px !important;
            max-width: 14px !important;
            max-height: 14px !important;
            display: block !important;
        }

        .pagination .page-link span[aria-hidden="true"] {
            font-size: 0.75rem !important;
            line-height: 1 !important;
            display: inline-block !important;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0.5rem 0.625rem !important;
            min-width: 36px !important;
        }

        .pagination .page-link * {
            max-width: 100% !important;
            max-height: 100% !important;
        }

        .card-footer {
            padding: 0.75rem 1.5rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        @media (max-width: 576px) {
            .pagination {
                padding: 0.75rem 0.5rem;
                gap: 0.125rem;
            }

            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.8125rem;
                min-width: 32px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <h4>
                <span class="burger-icon">🏗️</span>
                <span class="brand-text">Admin Panel</span>
            </h4>
        </div>
        <div class="list-group list-group-flush mt-3 flex-grow-1" style="overflow-y: auto; overflow-x: hidden;">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Kontrol Paneli
            </a>
            
            {{-- Kategori Yönetimi --}}
            <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i> Kategoriler
            </a>
            
            {{-- Proje Yönetimi --}}
            <a href="{{ route('admin.projects.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Projeler
            </a>
            
            {{-- Referans Yönetimi --}}
            <a href="{{ route('admin.references.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.references.*') ? 'active' : '' }}">
                <i class="bi bi-star"></i> Referanslar
            </a>
            
            {{-- Hizmet Yönetimi --}}
            <a href="{{ route('admin.services.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Hizmetler
            </a>
            
            {{-- Haber/Duyuru Yönetimi --}}
            <a href="{{ route('admin.news.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> Haberler
            </a>
            
            {{-- Slider Yönetimi --}}
            <a href="{{ route('admin.sliders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Slider
            </a>

            
            {{-- İletişim Yönetimi --}}
            <a href="{{ route('admin.contacts.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> İletişim
            </a>
            
            {{-- Sayfa Yönetimi --}}
            <a href="{{ route('admin.pages.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Sayfalar
            </a>


            {{-- Sistem --}}
            <a href="{{ route('admin.settings.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Ayarlar
            </a>
            <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kullanıcılar
            </a>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="security-badge">
                <i class="bi bi-shield-check"></i>
                <span>Yönetim Paneli</span>
            </div>
            <small>UG Teknoloji</small>
        </div>
    </div>

    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <button class="btn btn-link d-md-none p-0" id="sidebar-toggle" style="color: #0f172a; border: none;">
                    <i class="bi bi-list" style="font-size: 1.75rem;"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold">@yield('title', 'Kontrol Paneli')</h5>
                    <small class="text-muted d-none d-lg-block">Yönetim paneli ana sayfası</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <!-- Quick Actions -->
                <div class="dropdown">
                    <button class="quick-actions-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span class="d-none d-lg-inline">Hızlı İşlemler</span>
                        <i class="bi bi-chevron-down ms-1 d-none d-lg-inline" style="font-size: 0.75rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end quick-actions-menu">
                        <li>
                            <a href="{{ route('admin.projects.create') }}" class="quick-action-item primary">
                                <div class="action-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="action-text">
                                    <strong>Yeni Proje</strong>
                                    <small>Yeni proje ekle</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.create') }}" class="quick-action-item success">
                                <div class="action-icon">
                                    <i class="bi bi-folder-plus"></i>
                                </div>
                                <div class="action-text">
                                    <strong>Yeni Kategori</strong>
                                    <small>Proje kategorisi oluştur</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.news.create') }}" class="quick-action-item warning">
                                <div class="action-icon">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <div class="action-text">
                                    <strong>Yeni Haber</strong>
                                    <small>Haber/duyuru ekle</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.references.create') }}" class="quick-action-item danger">
                                    <div class="action-icon">
                                    <i class="bi bi-star"></i>
                                    </div>
                                    <div class="action-text">
                                    <strong>Yeni Referans</strong>
                                    <small>Referans ekle</small>
                                    </div>
                                </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="user-info">
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-email">{{ Auth::user()->email }}</div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear"></i> Ayarlar
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="page-content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <script>
        // Sidebar toggle for mobile
        (function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar-wrapper');
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999; display: none;';
            document.body.appendChild(overlay);

            function openSidebar() {
                sidebar.classList.add('show');
                overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            }

            sidebarToggle?.addEventListener('click', function(e) {
                e.stopPropagation();
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth >= 768) {
                        closeSidebar();
                    }
                }, 250);
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
