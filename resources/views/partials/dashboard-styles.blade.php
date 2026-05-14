<style>
/* ===== DASHBOARD GLOBAL STYLES ===== */
:root {
    --dash-radius: 16px;
    --dash-shadow: 0 4px 24px rgba(0,0,0,0.07);
    --dash-shadow-hover: 0 8px 32px rgba(0,0,0,0.13);
    --dash-transition: all 0.3s cubic-bezier(.4,0,.2,1);
}

/* Stat Cards */
.stat-card-modern {
    border-radius: var(--dash-radius);
    border: none;
    box-shadow: var(--dash-shadow);
    transition: var(--dash-transition);
    overflow: hidden;
    position: relative;
    background: #fff;
}
.stat-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: var(--dash-shadow-hover);
}
.stat-card-modern .card-body { padding: 1.4rem 1.5rem; }
.stat-card-modern .stat-icon {
    width: 54px; height: 54px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; flex-shrink: 0;
}
.stat-card-modern .stat-value {
    font-size: 2rem; font-weight: 800;
    line-height: 1.1; letter-spacing: -1px;
    color: #1e293b;
}
.stat-card-modern .stat-label {
    font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: #94a3b8; margin-bottom: 2px;
}
.stat-card-modern .stat-trend {
    font-size: 0.75rem; font-weight: 600;
}
.stat-card-modern::after {
    content: '';
    position: absolute; right: -10px; top: -10px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: 0.06;
}

/* Gradient Variants */
.stat-card-blue .stat-icon  { background: rgba(59,130,246,.13); color: #3b82f6; }
.stat-card-blue::after      { background: #3b82f6; }
.stat-card-green .stat-icon { background: rgba(16,185,129,.13); color: #10b981; }
.stat-card-green::after     { background: #10b981; }
.stat-card-amber .stat-icon { background: rgba(245,158,11,.13); color: #f59e0b; }
.stat-card-amber::after     { background: #f59e0b; }
.stat-card-rose .stat-icon  { background: rgba(244,63,94,.13); color: #f43f5e; }
.stat-card-rose::after      { background: #f43f5e; }
.stat-card-violet .stat-icon{ background: rgba(139,92,246,.13); color: #8b5cf6; }
.stat-card-violet::after    { background: #8b5cf6; }
.stat-card-cyan .stat-icon  { background: rgba(6,182,212,.13); color: #06b6d4; }
.stat-card-cyan::after      { background: #06b6d4; }

/* Gradient Header Card */
.dash-hero-card {
    border-radius: var(--dash-radius);
    border: none;
    color: #fff;
    padding: 1.8rem 2rem;
    position: relative; overflow: hidden;
    box-shadow: var(--dash-shadow);
}
.dash-hero-card::before {
    content: ''; position: absolute;
    right: -30px; top: -30px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
}
.dash-hero-card::after {
    content: ''; position: absolute;
    right: 40px; bottom: -40px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}
.dash-hero-card .hero-icon {
    font-size: 3.5rem; opacity: 0.2;
    position: absolute; right: 1.5rem; top: 50%;
    transform: translateY(-50%);
}

/* Table Card */
.dash-table-card {
    border-radius: var(--dash-radius);
    border: none;
    box-shadow: var(--dash-shadow);
    overflow: hidden;
}
.dash-table-card .card-header {
    background: #fff; border-bottom: 1px solid #f1f5f9;
    padding: 1rem 1.5rem;
}
.dash-table-card table thead th {
    background: #f8fafc; border: none;
    font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: #94a3b8; padding: 0.9rem 1rem;
}
.dash-table-card table tbody tr {
    transition: background 0.15s;
    border-bottom: 1px solid #f8fafc;
}
.dash-table-card table tbody tr:hover { background: #f8faff; }
.dash-table-card table tbody td { padding: 0.85rem 1rem; border: none; }

/* Chart Card */
.dash-chart-card {
    border-radius: var(--dash-radius);
    border: none;
    box-shadow: var(--dash-shadow);
    overflow: hidden;
}
.dash-chart-card .card-header {
    background: #fff; border-bottom: 1px solid #f1f5f9;
    padding: 1rem 1.5rem;
}

/* Quick Action Buttons */
.quick-action-item {
    display: flex; align-items: center;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    text-decoration: none;
    transition: var(--dash-transition);
    border: 1px solid #f1f5f9;
    background: #f8fafc;
    color: #334155;
    font-weight: 600; font-size: 0.875rem;
    gap: 0.75rem;
}
.quick-action-item:hover {
    background: #fff; color: #1e293b;
    border-color: #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    transform: translateX(3px);
}
.quick-action-item .qa-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.95rem; flex-shrink: 0;
}

/* Activity Item */
.activity-item {
    display: flex; gap: 0.75rem; padding: 0.6rem 0;
    border-bottom: 1px solid #f8fafc;
    align-items: flex-start;
}
.activity-item:last-child { border-bottom: none; }
.activity-dot {
    width: 10px; height: 10px; border-radius: 50%;
    flex-shrink: 0; margin-top: 5px;
}

/* Avatar */
.user-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.8rem;
    flex-shrink: 0;
}

/* Progress Bar */
.progress-modern {
    height: 6px; border-radius: 99px;
    background: #f1f5f9; overflow: hidden;
}
.progress-modern .progress-fill {
    height: 100%; border-radius: 99px;
    transition: width 1.2s cubic-bezier(.4,0,.2,1);
}

/* Badge Pill */
.status-badge {
    padding: 0.3em 0.8em; border-radius: 99px;
    font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
}

/* Animate on load */
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeSlideUp 0.5s ease both; }
.anim-2 { animation: fadeSlideUp 0.5s 0.1s ease both; }
.anim-3 { animation: fadeSlideUp 0.5s 0.2s ease both; }
.anim-4 { animation: fadeSlideUp 0.5s 0.3s ease both; }
.anim-5 { animation: fadeSlideUp 0.5s 0.4s ease both; }
.anim-6 { animation: fadeSlideUp 0.5s 0.5s ease both; }

/* Counter animation */
.counter-value { transition: all 0.3s; }

/* Soft BG Utilities */
.bg-blue-soft   { background: rgba(59,130,246,0.1) !important; }
.bg-green-soft  { background: rgba(16,185,129,0.1) !important; }
.bg-amber-soft  { background: rgba(245,158,11,0.1) !important; }
.bg-rose-soft   { background: rgba(244,63,94,0.1) !important; }
.bg-violet-soft { background: rgba(139,92,246,0.1) !important; }
.bg-cyan-soft   { background: rgba(6,182,212,0.1) !important; }
.text-blue   { color: #3b82f6 !important; }
.text-green  { color: #10b981 !important; }
.text-amber  { color: #f59e0b !important; }
.text-rose   { color: #f43f5e !important; }
.text-violet { color: #8b5cf6 !important; }
.text-cyan   { color: #06b6d4 !important; }
</style>

<script>
/* Animated counter */
function animateCounters() {
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseFloat(el.dataset.count.replace(/,/g, ''));
        const isFloat = el.dataset.count.includes('.');
        const prefix = el.dataset.prefix || '';
        const suffix = el.dataset.suffix || '';
        let start = 0, duration = 1400, startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            const progress = Math.min((ts - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            const val = isFloat ? (start + (target - start) * ease).toFixed(1)
                                : Math.floor(start + (target - start) * ease).toLocaleString();
            el.textContent = prefix + val + suffix;
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = prefix + (isFloat ? target.toFixed(1) : target.toLocaleString()) + suffix;
        }
        requestAnimationFrame(step);
    });
}
document.addEventListener('DOMContentLoaded', animateCounters);
</script>
