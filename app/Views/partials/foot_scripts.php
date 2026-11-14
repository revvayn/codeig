<?php
$flashSuccess = session()->getFlashdata('success');
$flashError   = session()->getFlashdata('error');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  (function () {
    var sidebar = document.getElementById('appSidebar');
    var overlay = document.getElementById('appOverlay');
    var toggle  = document.getElementById('sidebarToggle');

    function openSidebar() {
      if (!sidebar) return;
      sidebar.classList.remove('-translate-x-full');
      overlay && overlay.classList.remove('hidden');
      document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
    }
    function closeSidebar() {
      if (!sidebar) return;
      sidebar.classList.add('-translate-x-full');
      overlay && overlay.classList.add('hidden');
      document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
    }
    toggle && toggle.addEventListener('click', function () {
      var closed = sidebar.classList.contains('-translate-x-full');
      closed ? openSidebar() : closeSidebar();
    });
    overlay && overlay.addEventListener('click', closeSidebar);
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 1024) {
        overlay && overlay.classList.add('hidden');
        sidebar && sidebar.classList.remove('-translate-x-full');
        document.body.classList.remove('overflow-hidden');
      }
    });

    // Dropdown profil
    var userBtn = document.getElementById('userMenuButton');
    var userMenu = document.getElementById('userMenu');
    userBtn && userBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      userMenu && userMenu.classList.toggle('hidden');
    });
    document.addEventListener('click', function (e) {
      if (userMenu && !userMenu.contains(e.target) && e.target !== userBtn) {
        userMenu.classList.add('hidden');
      }
    });

    // Notifikasi (belum ada pusat notifikasi)
    var notifBtn = document.getElementById('notifButton');
    notifBtn && notifBtn.addEventListener('click', function () {
      if (window.Swal) {
        Swal.fire({
          toast: true, position: 'top-end', icon: 'info',
          title: 'Belum ada notifikasi baru.',
          showConfirmButton: false, timer: 2600, timerProgressBar: true
        });
      }
    });

    $(function () {
      if ($.fn.dataTable) {
        $.fn.dataTable.ext.errMode = 'none';

        // Pager ringkas & responsif: jumlah nomor mengikuti lebar layar.
        // Mobile: ‹ 1 2 … 50 ›  |  Desktop: ‹ 1 2 3 4 … 50 ›
        $.fn.dataTable.ext.pager.presensiku = function (opts) {
          var mobile = window.matchMedia('(max-width: 767px)').matches;
          opts.buttons         = mobile ? 4 : 6;
          opts.boundaryNumbers = true;
          return ['previous', 'numbers', 'next'];
        };
      }

      // -----------------------------------------------------------------
      // Preferensi jumlah data per halaman (disimpan di browser)
      // -----------------------------------------------------------------
      var OPSI_PANJANG = [10, 25, 50, 100, -1];
      var KUNCI_PANJANG = 'presensiku_length';

      function bacaPanjang() {
        var nilai = 10;
        try {
          var simpan = localStorage.getItem(KUNCI_PANJANG);
          if (simpan !== null) {
            var angka = parseInt(simpan, 10);
            if (OPSI_PANJANG.indexOf(angka) !== -1) nilai = angka;
          }
        } catch (e) {}
        return nilai;
      }

      function simpanPanjang(nilai) {
        try { localStorage.setItem(KUNCI_PANJANG, String(nilai)); } catch (e) {}
      }

      // -----------------------------------------------------------------
      // Filter per kolom (dibuat otomatis dari isi tabel)
      // -----------------------------------------------------------------
      var filterTabel = {};

      var BULAN_ID = {
        januari: 0, februari: 1, maret: 2, april: 3, mei: 4, juni: 5,
        juli: 6, agustus: 7, september: 8, oktober: 9, november: 10, desember: 11,
        jan: 0, feb: 1, mar: 2, apr: 3, jun: 5, jul: 6, agu: 7, agt: 7,
        sep: 8, okt: 9, nov: 10, des: 11
      };

      function parseTanggal(teks) {
        if (!teks) return null;

        var m = teks.match(/(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})/);
        if (m) {
          var bulan = BULAN_ID[m[2].toLowerCase()];
          if (bulan !== undefined) return new Date(parseInt(m[3], 10), bulan, parseInt(m[1], 10));
        }

        m = teks.match(/(\d{4})-(\d{1,2})-(\d{1,2})/);
        if (m) return new Date(parseInt(m[1], 10), parseInt(m[2], 10) - 1, parseInt(m[3], 10));

        m = teks.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
        if (m) return new Date(parseInt(m[3], 10), parseInt(m[2], 10) - 1, parseInt(m[1], 10));

        return null;
      }

      function teksSel(td) {
        return td ? (td.textContent || '').replace(/\s+/g, ' ').trim() : '';
      }

      // Mesin filter: dipanggil DataTables untuk setiap baris.
      if ($.fn.dataTable) {
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
          var aturan = filterTabel[settings.sTableId];
          if (!aturan || !aturan.length) return true;

          var baris = settings.aoData[dataIndex] ? settings.aoData[dataIndex].nTr : null;
          if (!baris) return true;

          for (var i = 0; i < aturan.length; i++) {
            var a = aturan[i];
            var sel = baris.cells[a.kolom];
            if (!sel) return false;

            var teks = teksSel(sel);

            if (a.jenis === 'pilih') {
              if (teks.toLowerCase() !== a.nilai.toLowerCase()) return false;
            } else {
              var tgl = parseTanggal(teks);
              if (!tgl) return false;
              if (a.dari && tgl < a.dari) return false;
              if (a.sampai && tgl > a.sampai) return false;
            }
          }

          return true;
        });
      }

      function pasangFilter(api) {
        var container = $(api.table().container());
        var barisAtas = container.find('.dt-layout-row').first();
        var selAkhir  = barisAtas.find('.dt-layout-cell.dt-layout-end');
        if (!selAkhir.length) return;

        var kolom = [];

        api.columns().every(function (idx) {
          var judul = $(this.header()).text().replace(/\s+/g, ' ').trim();
          if (!judul || /^no\.?$/i.test(judul) || /^#$/.test(judul)) return;
          if (/^jam\b/i.test(judul)) return;

          var nodes = this.nodes();
          var nilai = [];
          var terlihat = {};
          var terisi = 0;
          var tanggalTerlihat = 0;
          var semuaAngka = true;

          for (var i = 0; i < nodes.length; i++) {
            var teks = teksSel(nodes[i]);
            if (!teks || teks === '-') continue;

            terisi++;
            if (!/^\d+$/.test(teks)) semuaAngka = false;
            if (parseTanggal(teks)) tanggalTerlihat++;

            var kunci = teks.toLowerCase();
            if (!terlihat[kunci]) {
              terlihat[kunci] = true;
              nilai.push(teks);
            }
          }

          if (!terisi || semuaAngka) return;

          var adalahTanggal = /tanggal|tgl|waktu/i.test(judul) && tanggalTerlihat >= Math.ceil(terisi * 0.6);

          if (adalahTanggal) {
            kolom.push({ kolom: idx, judul: judul, jenis: 'tanggal' });
            return;
          }

          var terpanjang = 0;
          for (var j = 0; j < nilai.length; j++) {
            if (nilai[j].length > terpanjang) terpanjang = nilai[j].length;
          }

          if (nilai.length >= 2 && nilai.length <= 15 && terpanjang <= 40) {
            nilai.sort(function (a, b) { return a.localeCompare(b, 'id'); });
            kolom.push({ kolom: idx, judul: judul, jenis: 'pilih', nilai: nilai });
          }
        });

        if (!kolom.length) return;
        if (kolom.length > 8) kolom = kolom.slice(0, 8);

        var idTabel = api.table().node().id;
        var $tombol = $(
          '<button type="button" class="dt-filter-btn" aria-expanded="false">' +
            '<i class="fa-solid fa-sliders"></i><span>Filter</span>' +
            '<span class="dt-filter-count" hidden>0</span>' +
          '</button>'
        );

        var $panel = $('<div class="dt-filter-panel" role="region" aria-label="Filter data"></div>');
        var $kepala = $('<div class="dt-filter-head"></div>');
        var $judul = $('<div class="dt-filter-title"><i class="fa-solid fa-filter"></i><span>Filter Data</span></div>');
        var $reset = $('<button type="button" class="dt-filter-reset" disabled>Reset</button>');
        var $grid = $('<div class="dt-filter-grid"></div>');

        kolom.forEach(function (k) {
          var id = 'dtf-' + idTabel + '-' + k.kolom;
          var $field = $('<div class="dt-filter-field"></div>');
          $field.append($('<span></span>').text(k.judul));

          if (k.jenis === 'pilih') {
            var $select = $('<select></select>').attr({ id: id, 'data-kolom': k.kolom });
            $select.append($('<option value=""></option>').text('Semua ' + k.judul.toLowerCase()));
            k.nilai.forEach(function (v) {
              $select.append($('<option></option>').attr('value', v).text(v));
            });
            $field.append($select);
          } else {
            var $range = $('<div class="dt-filter-range"></div>');
            $range.append(
              $('<input type="date">').attr({
                id: id, 'data-kolom': k.kolom, 'data-peran': 'dari', 'aria-label': 'Dari ' + k.judul
              }),
              $('<span>-</span>'),
              $('<input type="date">').attr({
                'data-kolom': k.kolom, 'data-peran': 'sampai', 'aria-label': 'Sampai ' + k.judul
              })
            );
            $field.append($range);
          }

          $grid.append($field);
        });

        $kepala.append($judul, $reset);
        $panel.append($kepala, $grid);

        selAkhir.prepend($tombol);
        barisAtas.after($panel);

        function terapkan() {
          var aturan = [];

          $panel.find('select[data-kolom]').each(function () {
            var nilai = $(this).val();
            if (nilai) {
              aturan.push({ jenis: 'pilih', kolom: parseInt($(this).attr('data-kolom'), 10), nilai: nilai });
            }
          });

          var rentang = {};

          $panel.find('input[type="date"][data-kolom]').each(function () {
            var kunci = $(this).attr('data-kolom');
            rentang[kunci] = rentang[kunci] || {};
            var nilai = $(this).val();
            if (!nilai) return;

            var bagian = nilai.split('-');
            rentang[kunci][$(this).attr('data-peran')] = new Date(
              parseInt(bagian[0], 10), parseInt(bagian[1], 10) - 1, parseInt(bagian[2], 10)
            );
          });

          Object.keys(rentang).forEach(function (kunci) {
            var r = rentang[kunci];
            if (r.dari || r.sampai) {
              aturan.push({
                jenis: 'tanggal', kolom: parseInt(kunci, 10),
                dari: r.dari || null, sampai: r.sampai || null
              });
            }
          });

          filterTabel[idTabel] = aturan;

          $tombol.find('.dt-filter-count').text(aturan.length).prop('hidden', aturan.length === 0);
          $tombol.toggleClass('is-active', aturan.length > 0);
          $reset.prop('disabled', aturan.length === 0);

          api.draw();
        }

        $tombol.on('click', function () {
          var buka = !$panel.hasClass('is-open');
          $panel.toggleClass('is-open', buka);
          $tombol.attr('aria-expanded', buka ? 'true' : 'false');
          if (buka) $panel.find('select, input').first().trigger('focus');
        });

        $panel.on('change', 'select[data-kolom], input[type="date"][data-kolom]', terapkan);

        $reset.on('click', function () {
          $panel.find('select[data-kolom]').val('');
          $panel.find('input[type="date"][data-kolom]').val('');
          terapkan();
        });
      }

      var tabelPresensi = null;

      if ($.fn.DataTable && $('#datatables').length) {
        var panjangAwal = bacaPanjang();

        tabelPresensi = $('#datatables').DataTable({
          pagingType: 'presensiku',
          pageLength: panjangAwal,
          lengthMenu: [
            { value: 10, label: '10 data' },
            { value: 25, label: '25 data' },
            { value: 50, label: '50 data' },
            { value: 100, label: '100 data' },
            { value: -1, label: 'Semua' }
          ],
          scrollX: true,
          scrollCollapse: true,
          autoWidth: false,
          language: {
            search: 'Cari',
            searchPlaceholder: 'Cari data...',
            lengthMenu: 'Tampilkan _MENU_',
            lengthLabels: { '-1': 'Semua' },
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            infoFiltered: '(difilter dari _MAX_ total data)',
            zeroRecords: 'Data tidak ditemukan',
            emptyTable: 'Belum ada data',
            paginate: {
              first: 'Pertama',
              last: 'Terakhir',
              previous: '<i class="fa-solid fa-chevron-left"></i>',
              next: '<i class="fa-solid fa-chevron-right"></i>'
            },
            aria: {
              paginate: {
                first: 'Halaman pertama',
                last: 'Halaman terakhir',
                previous: 'Halaman sebelumnya',
                next: 'Halaman berikutnya'
              }
            }
          },
          layout: {
            topStart: 'pageLength',
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'paging'
          }
        });

        // Simpan pilihan jumlah data agar konsisten di semua halaman.
        $('#datatables').on('length.dt', function (e, settings, len) {
          simpanPanjang(len);
        });

        // Bangun panel filter dari isi tabel.
        pasangFilter(tabelPresensi);

        // Redraw saat breakpoint mobile berubah agar jumlah tombol menyesuaikan.
        var modeMobile  = window.matchMedia('(max-width: 767px)').matches;
        var resizeTimer = null;

        window.addEventListener('resize', function () {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function () {
            var sekarang = window.matchMedia('(max-width: 767px)').matches;
            if (sekarang !== modeMobile) {
              modeMobile = sekarang;
              tabelPresensi.draw(false);
            }
          }, 180);
        });
      }

      <?php if ($flashSuccess): ?>
      Swal.fire({
        toast: true, position: 'top-end', icon: 'success',
        title: <?= json_encode($flashSuccess) ?>,
        showConfirmButton: false, timer: 3200, timerProgressBar: true
      });
      <?php endif; ?>

      <?php if ($flashError): ?>
      Swal.fire({
        toast: true, position: 'top-end', icon: 'error',
        title: <?= json_encode($flashError) ?>,
        showConfirmButton: false, timer: 4200, timerProgressBar: true
      });
      <?php endif; ?>

      $(document).on('click', '.tombol-hapus', function (e) {
        e.preventDefault();
        var link = $(this).attr('href');
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Data akan dihapus secara permanen!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#e11d48',
          cancelButtonColor: '#64748b',
          confirmButtonText: 'Ya, hapus',
          cancelButtonText: 'Batal',
          reverseButtons: true
        }).then(function (result) {
          if (result.isConfirmed) window.location.href = link;
        });
      });
    });
  })();
</script>
