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

    $(function () {
      if ($.fn.dataTable) {
        $.fn.dataTable.ext.errMode = 'none';

        // Pager ringkas & responsif: jumlah nomor mengikuti lebar layar.
        $.fn.dataTable.ext.pager.presensiku = function (opts) {
          var mobile = window.matchMedia('(max-width: 640px)').matches;
          opts.buttons        = mobile ? 3 : 5;
          opts.boundaryNumbers = ! mobile;
          return ['previous', 'numbers', 'next'];
        };
      }

      var tabelPresensi = null;

      if ($.fn.DataTable && $('#datatables').length) {
        tabelPresensi = $('#datatables').DataTable({
          pagingType: 'presensiku',
          pageLength: 10,
          lengthMenu: [10, 25, 50, 100],
          scrollX: true,
          scrollCollapse: true,
          autoWidth: false,
          language: {
            search: 'Cari:',
            searchPlaceholder: 'Ketik untuk mencari...',
            lengthMenu: 'Tampilkan _MENU_ data',
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
          }
        });

        // Redraw saat breakpoint mobile berubah agar jumlah tombol menyesuaikan.
        var modeMobile  = window.matchMedia('(max-width: 640px)').matches;
        var resizeTimer = null;

        window.addEventListener('resize', function () {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function () {
            var sekarang = window.matchMedia('(max-width: 640px)').matches;
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
