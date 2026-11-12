$p = 'app\Views\superadmin\layout.php'
$s = Get-Content $p -Raw
$start = $s.IndexOf('<div class="px-3 pt-2 pb-4 w-auto">')
$end = $s.IndexOf('</aside>', $start)
if ($start -lt 0 -or $end -lt 0) { throw "markers not found" }
$newSidebar = @"
    <div class="px-3 pt-2 pb-4 w-auto">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('superadmin/home') ?>">
            <i class="fas fa-gauge-high me-2"></i><span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('superadmin/perusahaan') ?>">
            <i class="fas fa-building me-2"></i><span>Data Perusahaan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('superadmin/admin') ?>">
            <i class="fas fa-user-shield me-2"></i><span>Data Admin</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('logout') ?>">
            <i class="fas fa-sign-out-alt me-2"></i><span>Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
"@
$s = $s.Substring(0, $start) + $newSidebar + $s.Substring($end + '</aside>'.Length)
$s = $s -replace "base_url\('admin/home'\)", "base_url('superadmin/home')"
$bytes = [System.Text.Encoding]::UTF8.GetBytes($s)
[System.IO.File]::WriteAllBytes((Resolve-Path $p), $bytes)
Write-Output "written"