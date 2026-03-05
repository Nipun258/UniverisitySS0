@extends('admin.admin_master')
@section('admin')
{{-- <meta http-equiv="refresh" content="30" /> --}}
<!-- Content Header (Page header) -->
<!-- /.content-header -->

<!-- Main content -->
<style>

</style>

<section class="content">
    <div class="container-fluid">
        <!-- <div class="alert alert-danger" id="success-danger">
          <button type="button" class="close text-white" data-dismiss="alert">x</button>
          <strong>Notice!&nbsp;&nbsp;</strong>
          USJNet Services Tempory unavailable.in case department head functionality may have some dealy.
       </div> -->
        
        <!-- /.row -->

        {{-- ═══════════════════════════════════════
             LIVE TRAFFIC PANEL
        ══════════════════════════════════════════ --}}
        <div class="row mt-3">

            {{-- Stat card --}}
            <div class="col-lg-3 col-6 mb-3">
                <div class="card card-outline card-success h-100" style="border-top:3px solid #28a745;">
                    <div class="card-body text-center py-4">
                        <div style="width:72px;height:72px;border-radius:50%;background:rgba(40,167,69,.12);
                                    display:flex;align-items:center;justify-content:center;margin:0 auto 14px;
                                    border:2px solid #28a745;position:relative;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#28a745;
                                         position:absolute;top:6px;right:6px;
                                         animation:pulse 1.4s infinite;"></span>
                            <i class="fas fa-users" style="font-size:28px;color:#28a745;"></i>
                        </div>
                        <h1 id="active-count" style="font-size:52px;font-weight:800;color:#28a745;line-height:1;margin:0 0 4px;">—</h1>
                        <p class="mb-0 text-muted" style="font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;">Active Users</p>
                        <small class="text-muted">Updated <span id="last-updated">—</span></small>
                    </div>
                </div>
            </div>

            {{-- Line chart --}}
            <div class="col-lg-9 mb-3">
                <div class="card card-outline card-primary h-100">
                    <div class="card-header border-0 pb-0">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1 text-primary"></i>
                            Login Activity — Last 10 Hours
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="loginChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active users table --}}
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-circle text-success mr-1" style="font-size:9px;vertical-align:middle;animation:pulse 1.4s infinite;"></i>
                            Currently Active Users
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-success" id="table-count">0 online</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>IP Address</th>
                                        <th>Last Seen</th>
                                        <th>Last Login</th>
                                    </tr>
                                </thead>
                                <tbody id="active-users-tbody">
                                    <tr><td colspan="6" class="text-center text-muted py-3">Loading…</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════
             OAUTH AUTH CODES SUMMARY
        ══════════════════════════════════════════ --}}
        <div class="row mt-2">
            <div class="col-12 mb-2">
                <h6 class="text-muted" style="text-transform:uppercase;letter-spacing:1px;font-size:11px;">
                    <i class="fas fa-key mr-1"></i> OAuth Authorization Codes
                </h6>
            </div>

            {{-- Total --}}
            <div class="col-lg-3 col-6 mb-3">
                <div class="info-box mb-0">
                    <span class="info-box-icon bg-secondary"><i class="fas fa-hashtag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Issued</span>
                        <span class="info-box-number" id="ac-total">—</span>
                    </div>
                </div>
            </div>

            {{-- Active --}}
            <div class="col-lg-3 col-6 mb-3">
                <div class="info-box mb-0">
                    <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Active</span>
                        <span class="info-box-number" id="ac-active">—</span>
                    </div>
                </div>
            </div>

            {{-- Revoked --}}
            <div class="col-lg-3 col-6 mb-3">
                <div class="info-box mb-0">
                    <span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Revoked</span>
                        <span class="info-box-number" id="ac-revoked">—</span>
                    </div>
                </div>
            </div>

            {{-- Expired --}}
            <div class="col-lg-3 col-6 mb-3">
                <div class="info-box mb-0">
                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Expired</span>
                        <span class="info-box-number" id="ac-expired">—</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-client breakdown table --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plug mr-1 text-warning"></i> Auth Codes — Per Client</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Revoked</th>
                                        <th class="text-center">Expired</th>
                                    </tr>
                                </thead>
                                <tbody id="auth-codes-tbody">
                                    <tr><td colspan="6" class="text-center text-muted py-3">Loading…</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<style>
@keyframes pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(1.5); }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    var url     = '{{ route("dashboard.live-traffic") }}';
    var chart   = null;
    var POLL_MS = 5000;

    // ── Build chart ──────────────────────────────────────────────────
    function buildChart(labels, data) {
        var ctx = document.getElementById('loginChart').getContext('2d');
        if (chart) { chart.destroy(); }
        chart = new Chart(ctx, {
            type : 'line',
            data : {
                labels   : labels,
                datasets : [{
                    label           : 'Logins',
                    data            : data,
                    borderColor     : '#007bff',
                    backgroundColor : 'rgba(0,123,255,.08)',
                    borderWidth     : 2,
                    pointBackgroundColor : '#007bff',
                    pointRadius     : 4,
                    fill            : true,
                    tension         : 0.4,
                }]
            },
            options : {
                responsive   : true,
                maintainAspectRatio : true,
                plugins : { legend : { display : false } },
                scales  : {
                    y : { beginAtZero : true, ticks : { stepSize : 1 } }
                }
            }
        });
    }

    // ── Render table rows ─────────────────────────────────────────────
    function renderTable(users) {
        var tbody = document.getElementById('active-users-tbody');
        document.getElementById('table-count').textContent = users.length + ' online';

        if (!users.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-3">No active users right now</td></tr>';
            return;
        }
        tbody.innerHTML = users.map(function (u, i) {
            return '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td><strong>' + u.name + '</strong></td>' +
                '<td>' + u.email + '</td>' +
                '<td><code>' + u.ip + '</code></td>' +
                '<td><span class="badge badge-success">' + u.last_seen + '</span></td>' +
                '<td>' + u.last_login + '</td>' +
            '</tr>';
        }).join('');
    }

    // ── Poll backend ──────────────────────────────────────────────────
    function fetchData() {
        fetch(url, { headers : { 'X-Requested-With' : 'XMLHttpRequest' } })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                // Stat card
                document.getElementById('active-count').textContent = d.active_count;
                document.getElementById('last-updated').textContent  =
                    new Date().toLocaleTimeString();

                // Chart
                buildChart(
                    d.chart.map(function (c) { return c.label; }),
                    d.chart.map(function (c) { return c.count; })
                );

                // Table
                renderTable(d.active_users);

                // Auth codes stat cards
                var ac = d.auth_codes;
                document.getElementById('ac-total').textContent   = ac.total;
                document.getElementById('ac-active').textContent  = ac.active;
                document.getElementById('ac-revoked').textContent = ac.revoked;
                document.getElementById('ac-expired').textContent = ac.expired;

                // Per-client table
                var tbody = document.getElementById('auth-codes-tbody');
                if (!ac.per_client || !ac.per_client.length) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-3">No auth codes found</td></tr>';
                } else {
                    tbody.innerHTML = ac.per_client.map(function (r, i) {
                        return '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td><strong>' + r.client_name + '</strong></td>' +
                            '<td class="text-center"><span class="badge badge-secondary">' + r.total + '</span></td>' +
                            '<td class="text-center"><span class="badge badge-success">' + r.active + '</span></td>' +
                            '<td class="text-center"><span class="badge badge-danger">' + r.revoked + '</span></td>' +
                            '<td class="text-center"><span class="badge badge-warning">' + r.expired + '</span></td>' +
                        '</tr>';
                    }).join('');
                }
            })
            .catch(function () { /* silently ignore network blip */ });
    }

    fetchData();
    setInterval(fetchData, POLL_MS);
})();
</script>

@endsection
