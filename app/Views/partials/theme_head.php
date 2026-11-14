<?php
/**
 * Head bersama untuk seluruh layout.
 * Skala tipografi & spacing memakai pendekatan golden ratio (φ ≈ 1.618):
 * 10 · 16 · 26 · 42 · 68 px.
 */
$pageTitle = $title ?? 'Dashboard';
?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="#4f46e5" />
<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
<link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
<title><?= esc($pageTitle) ?> - PresensiKu</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        },
        colors: {
          brand: {
            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
            400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca',
            800: '#3730a3', 900: '#312e81', 950: '#1e1b4b',
          },
          ink: { DEFAULT: '#0f172a', soft: '#1e293b' },
        },
        boxShadow: {
          card: '0 1px 2px rgba(15,23,42,.04), 0 18px 40px -24px rgba(15,23,42,.18)',
          lift: '0 18px 40px -16px rgba(79,70,229,.35)',
        },
        borderRadius: {
          '2xl': '18px',
          '3xl': '26px',
        },
        maxWidth: {
          app: '1440px',
        },
        transitionTimingFunction: {
          'out-expo': 'cubic-bezier(.16,1,.3,1)',
        },
      },
    },
  };
</script>

<style type="text/tailwindcss">
  @layer components {
    /* ---------- Struktur halaman ---------- */
    .app-card {
      @apply bg-white border border-slate-200/80 rounded-2xl shadow-card;
    }
    .app-card-header {
      @apply flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-slate-100;
    }
    .app-title {
      @apply text-[26px] leading-tight font-extrabold tracking-tight text-slate-900;
    }
    .app-subtitle {
      @apply mt-1 text-[13px] leading-relaxed text-slate-500;
    }
    .app-page-head {
      @apply mb-[26px] flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between;
    }

    /* ---------- Tombol ---------- */
    .app-btn {
      @apply inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-[13px] font-semibold transition duration-200 focus:outline-none focus:ring-4;
    }
    .app-btn-primary {
      @apply inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-brand-600 px-4 text-[13px] font-semibold text-white shadow-sm shadow-brand-600/20 transition duration-200 hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-500/20;
    }
    .app-btn-outline {
      @apply inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-slate-200 bg-white px-4 text-[13px] font-semibold text-slate-700 transition duration-200 hover:border-brand-200 hover:bg-brand-50/60 hover:text-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-500/10;
    }
    .app-btn-ghost {
      @apply inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-[13px] font-semibold text-slate-600 transition duration-200 hover:bg-slate-100 hover:text-slate-900;
    }
    .app-btn-danger {
      @apply inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-rose-600 px-4 text-[13px] font-semibold text-white shadow-sm transition duration-200 hover:bg-rose-700 focus:outline-none focus:ring-4 focus:ring-rose-500/20;
    }
    .app-btn-sm {
      @apply h-9 rounded-lg px-3 text-[12px];
    }
    .app-icon-btn {
      @apply inline-flex h-9 w-9 items-center justify-center rounded-lg border text-[12px] transition duration-200;
    }

    /* ---------- Form ---------- */
    .app-label {
      @apply mb-2 block text-[11px] font-bold uppercase tracking-[0.08em] text-slate-500;
    }
    .app-input {
      @apply h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 text-[13.5px] text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-brand-500 focus:outline-none focus:ring-4 focus:ring-brand-500/10;
    }
    .app-select {
      @apply h-11 w-full appearance-none rounded-xl border border-slate-200 bg-white bg-[length:16px] bg-[right_0.9rem_center] bg-no-repeat px-3.5 pr-10 text-[13.5px] text-slate-800 transition duration-200 focus:border-brand-500 focus:outline-none focus:ring-4 focus:ring-brand-500/10;
      background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.6' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
    }
    .app-textarea {
      @apply w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-[13.5px] text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-brand-500 focus:outline-none focus:ring-4 focus:ring-brand-500/10;
    }
    .app-help {
      @apply mt-1.5 text-[11.5px] leading-relaxed text-slate-400;
    }
    .app-error {
      @apply mt-1.5 text-[11.5px] font-medium text-rose-600;
    }

    /* ---------- Tabel ---------- */
    .app-table {
      @apply w-full border-collapse text-[13px];
    }
    .app-table thead th {
      @apply whitespace-nowrap border-b border-slate-100 bg-slate-50/80 px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.09em] text-slate-500;
    }
    .app-table tbody td {
      @apply border-b border-slate-50 px-4 py-3.5 align-middle text-slate-600;
    }
    .app-table tbody tr {
      @apply transition-colors;
    }
    .app-table tbody tr:hover {
      @apply bg-brand-50/40;
    }
    .app-table tbody tr:last-child td {
      @apply border-b-0;
    }

    /* ---------- Navigasi samping ---------- */
    .sidebar-link {
      @apply flex items-center gap-3 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold text-slate-400 transition duration-200 hover:bg-white/5 hover:text-white;
    }
    .sidebar-link.is-active {
      @apply bg-gradient-to-r from-brand-600 to-violet-600 text-white shadow-lg shadow-brand-950/40;
    }
    .sidebar-label {
      @apply mb-2 mt-5 px-3 text-[9.5px] font-bold uppercase tracking-[0.18em] text-slate-500;
    }
    .sidebar-chevron {
      @apply ml-auto text-[9px] text-slate-500 transition-transform duration-200;
    }
    details[open] .sidebar-chevron {
      transform: rotate(180deg);
    }
    .sidebar-link.is-active .sidebar-chevron {
      @apply text-white/70;
    }

    /* ---------- Badge & empty state ---------- */
    .app-empty {
      @apply flex flex-col items-center justify-center gap-3 px-6 py-12 text-center text-[13px] text-slate-400;
    }
    .app-empty i {
      @apply text-3xl text-slate-300;
    }
  }
</style>

<style>
  html { scroll-behavior: smooth; }
  body { -webkit-font-smoothing: antialiased; }
  .app-scroll::-webkit-scrollbar { width: 6px; }
  .app-scroll::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, .35); border-radius: 999px; }
  .app-scroll::-webkit-scrollbar-track { background: transparent; }
  summary { list-style: none; }
  summary::-webkit-details-marker { display: none; }

  /* DataTables diselaraskan dengan design system */
  .dt-container { font-size: 13px; color: #475569; }
  .dt-container .dt-layout-row {
    display: flex; flex-wrap: wrap; align-items: center;
    justify-content: space-between; gap: 12px; margin: 14px 0;
  }
  .dt-container .dt-layout-row:first-child { margin-top: 0; }
  .dt-container .dt-layout-row:last-child { margin-bottom: 0; }
  /* Toolbar: pencarian & jumlah data */
  div.dt-container .dt-length,
  div.dt-container .dt-search { display: flex; align-items: center; }

  div.dt-container .dt-length label {
    display: inline-flex; align-items: center; gap: 8px;
    margin: 0; font-size: 12px; font-weight: 600; color: #64748b;
  }
  div.dt-container .dt-length select {
    height: 38px; min-width: 112px; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 0 32px 0 12px; font-size: 12.5px; font-weight: 600; color: #334155;
    background-color: #fff;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.7' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 11px center; background-size: 14px;
    appearance: none; -webkit-appearance: none; outline: none; cursor: pointer;
    transition: border-color .15s, box-shadow .15s;
  }
  div.dt-container .dt-length select:focus {
    border-color: #818cf8; box-shadow: 0 0 0 4px rgba(99, 102, 241, .10);
  }

  div.dt-container .dt-search { position: relative; }
  div.dt-container .dt-search label {
    position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
    overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; border: 0;
  }
  div.dt-container .dt-search input {
    height: 38px; width: 240px; border: 1px solid #e2e8f0; border-radius: 999px;
    padding: 0 16px 0 38px; font-size: 12.5px; color: #334155; background-color: #fff;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='7'/%3E%3Cpath stroke-linecap='round' d='m20 20-3.5-3.5'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: 14px center; background-size: 15px;
    outline: none; transition: border-color .15s, box-shadow .15s;
  }
  div.dt-container .dt-search input::placeholder { color: #94a3b8; }
  div.dt-container .dt-search input:focus {
    border-color: #818cf8; box-shadow: 0 0 0 4px rgba(99, 102, 241, .10);
  }
  div.dt-container .dt-search input::-webkit-search-cancel-button { cursor: pointer; }

  .dt-container .dt-info { font-size: 12px; color: #94a3b8; }
  .dt-container .dt-layout-cell { min-width: 0; }
  .dt-container .dt-layout-cell.dt-layout-end { gap: 8px; }

  /* Tombol filter */
  div.dt-container .dt-filter-btn {
    display: inline-flex; align-items: center; gap: 7px; height: 38px;
    padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 12px;
    background: #fff; color: #475569; font-size: 12.5px; font-weight: 700;
    cursor: pointer; transition: border-color .15s, color .15s, background .15s, box-shadow .15s;
  }
  div.dt-container .dt-filter-btn:hover,
  div.dt-container .dt-filter-btn.is-active {
    border-color: #c7d2fe; color: #4f46e5; background: #eef2ff;
  }
  div.dt-container .dt-filter-btn:focus-visible {
    outline: none; box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
  }
  div.dt-container .dt-filter-btn i { font-size: 12px; }
  div.dt-container .dt-filter-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 18px; height: 18px; padding: 0 5px; border-radius: 999px;
    background: #4f46e5; color: #fff; font-size: 10.5px; font-weight: 800; line-height: 1;
  }
  div.dt-container .dt-filter-count[hidden] { display: none; }

  /* Panel filter */
  div.dt-container .dt-filter-panel {
    display: none; margin: 0 0 14px; padding: 14px 16px 16px;
    border: 1px solid #e2e8f0; border-radius: 16px; background: #f8fafc;
  }
  div.dt-container .dt-filter-panel.is-open { display: block; }
  div.dt-container .dt-filter-head {
    display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px;
  }
  div.dt-container .dt-filter-title {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 12px; font-weight: 800; letter-spacing: .02em; color: #334155;
  }
  div.dt-container .dt-filter-title i { color: #4f46e5; font-size: 12px; }
  div.dt-container .dt-filter-reset {
    height: 30px; padding: 0 12px; border: 1px solid #e2e8f0; border-radius: 9px;
    background: #fff; color: #64748b; font-size: 11.5px; font-weight: 700; cursor: pointer;
    transition: border-color .15s, color .15s;
  }
  div.dt-container .dt-filter-reset:hover:not(:disabled) { border-color: #fecdd3; color: #e11d48; }
  div.dt-container .dt-filter-reset:disabled { opacity: .45; cursor: not-allowed; }
  div.dt-container .dt-filter-grid {
    display: flex; flex-wrap: wrap; gap: 12px;
  }
  div.dt-container .dt-filter-field {
    display: flex; flex-direction: column; gap: 6px;
    flex: 1 1 200px; max-width: 320px; min-width: 0;
  }
  div.dt-container .dt-filter-field > span {
    font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; color: #94a3b8;
  }
  div.dt-container .dt-filter-field select,
  div.dt-container .dt-filter-field input[type="date"] {
    height: 36px; width: 100%; min-width: 0; border: 1px solid #e2e8f0; border-radius: 10px;
    padding: 0 10px; font-size: 12px; color: #334155; background: #fff; outline: none;
    transition: border-color .15s, box-shadow .15s;
  }
  div.dt-container .dt-filter-field select:focus,
  div.dt-container .dt-filter-field input[type="date"]:focus {
    border-color: #818cf8; box-shadow: 0 0 0 4px rgba(99, 102, 241, .10);
  }
  div.dt-container .dt-filter-range { display: flex; align-items: center; gap: 6px; }
  div.dt-container .dt-filter-range > span { color: #cbd5e1; font-size: 11px; }
  .dt-container .dt-paging {
    display: flex; flex-wrap: wrap; align-items: center; justify-content: center;
    gap: 2px; width: fit-content; margin-left: auto;
    padding: 4px; border: 1px solid #eef2f7; border-radius: 12px; background: #f8fafc;
  }
  .dt-container .dt-paging .dt-paging-button {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 34px; height: 32px; margin: 0; padding: 0 8px;
    border: 1px solid transparent; border-radius: 8px; background: transparent;
    color: #64748b; font-size: 12px; font-weight: 700; line-height: 1;
    cursor: pointer; transition: background .15s, color .15s, box-shadow .15s;
  }
  .dt-container .dt-paging .dt-paging-button:hover:not(.disabled):not(.current) {
    background: #fff; color: #4f46e5; box-shadow: 0 1px 2px rgba(15, 23, 42, .08);
  }
  .dt-container .dt-paging .dt-paging-button.current {
    background: #4f46e5; color: #fff; border-color: #4f46e5;
    box-shadow: 0 6px 14px -8px rgba(79, 70, 229, .9);
  }
  .dt-container .dt-paging .dt-paging-button.current:hover { color: #fff; }
  .dt-container .dt-paging .dt-paging-button.disabled {
    opacity: .35; cursor: not-allowed; background: transparent; color: #94a3b8;
  }
  .dt-container .dt-paging .dt-paging-button.previous,
  .dt-container .dt-paging .dt-paging-button.next { padding: 0 10px; }
  .dt-container .dt-paging .ellipsis {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 22px; height: 32px; color: #94a3b8; font-size: 12px; font-weight: 700;
  }

  /* Area scroll horizontal milik DataTables (scrollX) */
  .dt-container .dt-scroll { width: 100%; }
  .dt-container .dt-scroll-head { border-bottom: 1px solid #f1f5f9; }
  .dt-container .dt-scroll-body { border-bottom: 1px solid #f8fafc; }
  .dt-container .dt-scroll-body::-webkit-scrollbar { height: 8px; }
  .dt-container .dt-scroll-body::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, .45); border-radius: 999px; }
  .dt-container table.dataTable { border-collapse: collapse !important; margin: 0 !important; }
  .dt-container table.dataTable thead th { border-bottom: 1px solid #f1f5f9 !important; }
  .dt-container table.dataTable tbody td { border-bottom: 1px solid #f8fafc !important; }

  /* Pagination & filter tetap terbaca di layar kecil (breakpoint sama dengan DataTables) */
  @media (max-width: 767px) {
    .dt-container .dt-layout-row { flex-direction: column; align-items: stretch; gap: 10px; }
    .dt-container .dt-layout-cell { width: 100%; }
    div.dt-container .dt-length { justify-content: space-between; }
    div.dt-container .dt-length select { width: auto; min-width: 132px; }
    div.dt-container .dt-search { width: 100%; }
    div.dt-container .dt-search input { width: 100%; }
    div.dt-container .dt-filter-btn { display: flex; width: 100%; justify-content: center; }
    div.dt-container .dt-filter-field { flex: 1 1 100%; max-width: none; }
    .dt-container .dt-info { text-align: center; font-size: 11.5px; }
    /* Selector dibuat se-spesifik CSS DataTables agar margin auto tidak kalah. */
    div.dt-container div.dt-layout-row div.dt-layout-cell > .dt-paging {
      margin: 0 auto; justify-content: center;
    }
    div.dt-container div.dt-layout-row div.dt-layout-cell > .dt-paging .dt-paging-button { min-width: 36px; height: 36px; }
    div.dt-container div.dt-layout-row div.dt-layout-cell > .dt-paging .ellipsis { height: 36px; }
  }

  /* Leaflet di dalam kartu */
  .leaflet-container { border-radius: 14px; font-family: inherit; z-index: 0; }
  .leaflet-pane, .leaflet-top, .leaflet-bottom { z-index: 0 !important; }

  /* SweetAlert menyesuaikan font */
  .swal2-popup { font-family: "Plus Jakarta Sans", sans-serif !important; border-radius: 18px !important; }
</style>

<?= $this->renderSection('styles') ?>
