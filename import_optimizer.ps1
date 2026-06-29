# 🚀 CSV Import Optimization Script for Windows PowerShell
# Script untuk mengoptimasi import CSV dengan berbagai method

Write-Host "🚀 CSV Import Optimization Tool" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green

# Fungsi untuk menampilkan menu
function Show-Menu {
    Write-Host ""
    Write-Host "Pilih method import:" -ForegroundColor Yellow
    Write-Host "1. Bulk Insert (Recommended) - Cepat dan reliable" -ForegroundColor White
    Write-Host "2. LOAD DATA INFILE (Fastest) - Tercepat untuk MySQL" -ForegroundColor White
    Write-Host "3. League CSV (Memory Efficient) - Untuk file besar" -ForegroundColor White
    Write-Host "4. Queue Jobs (Parallel) - Untuk file sangat besar" -ForegroundColor White
    Write-Host "5. Optimized Seeder - Gunakan seeder yang dioptimasi" -ForegroundColor White
    Write-Host "6. Benchmark All Methods - Test semua method" -ForegroundColor White
    Write-Host "7. Exit" -ForegroundColor Red
    Write-Host ""
}

# Fungsi untuk mengecek file
function Test-CsvFile {
    param([string]$FilePath)

    if (-not (Test-Path $FilePath)) {
        Write-Host "❌ File tidak ditemukan: $FilePath" -ForegroundColor Red
        exit 1
    }

    $fileInfo = Get-Item $FilePath
    $size = [math]::Round($fileInfo.Length / 1MB, 2)
    $lines = (Get-Content $FilePath | Measure-Object -Line).Lines

    Write-Host "📁 File: $FilePath" -ForegroundColor Cyan
    Write-Host "📏 Size: $size MB" -ForegroundColor Cyan
    Write-Host "📄 Lines: $lines" -ForegroundColor Cyan
    Write-Host ""

    return $true
}

# Fungsi untuk mengecek prerequisites
function Test-Prerequisites {
    Write-Host "🔍 Mengecek prerequisites..." -ForegroundColor Yellow

    # Check PHP
    try {
        $phpVersion = php --version 2>$null
        if ($phpVersion) {
            Write-Host "✅ PHP ditemukan" -ForegroundColor Green
        }
    }
    catch {
        Write-Host "❌ PHP tidak ditemukan atau tidak ada di PATH" -ForegroundColor Red
        exit 1
    }

    # Check Laravel Artisan
    if (Test-Path "artisan") {
        Write-Host "✅ Laravel Artisan ditemukan" -ForegroundColor Green
    }
    else {
        Write-Host "❌ File artisan tidak ditemukan. Pastikan Anda di root directory Laravel" -ForegroundColor Red
        exit 1
    }

    # Check database connection
    try {
        $dbTest = php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB Connected';" 2>$null
        if ($dbTest -match "DB Connected") {
            Write-Host "✅ Database connection OK" -ForegroundColor Green
        }
    }
    catch {
        Write-Host "⚠️  Tidak bisa test database connection" -ForegroundColor Yellow
    }

    Write-Host ""
}

# Fungsi untuk menjalankan import
function Start-Import {
    param(
        [string]$Method,
        [string]$FilePath,
        [int]$ChunkSize = 1000
    )

    Write-Host "⏱️  Memulai import dengan method: $Method" -ForegroundColor Yellow
    $startTime = Get-Date

    switch ($Method) {
        "bulk" {
            php artisan import:observation-codes $FilePath --method=bulk --chunk-size=$ChunkSize --truncate
        }
        "load-data" {
            php artisan import:observation-codes $FilePath --method=load-data --truncate
        }
        "league" {
            # Check if League CSV is installed
            $composerJson = Get-Content "composer.json" | ConvertFrom-Json
            $hasLeague = $composerJson.require.'league/csv' -or $composerJson.'require-dev'.'league/csv'

            if (-not $hasLeague) {
                Write-Host "📦 Installing League CSV..." -ForegroundColor Yellow
                composer require league/csv
            }

            php artisan import:observation-codes $FilePath --method=league --chunk-size=$ChunkSize --truncate
        }
        "jobs" {
            php artisan import:observation-codes $FilePath --method=jobs --chunk-size=$ChunkSize --truncate
            Write-Host "📈 Untuk memproses jobs, jalankan di terminal terpisah:" -ForegroundColor Cyan
            Write-Host "php artisan queue:work --tries=3" -ForegroundColor White
        }
        "seeder" {
            php artisan db:seed --class=OptimizedCodeSeeder
        }
    }

    $endTime = Get-Date
    $duration = ($endTime - $startTime).TotalSeconds

    Write-Host "⏰ Import selesai dalam: $([math]::Round($duration, 2)) detik" -ForegroundColor Green

    # Hitung statistik jika bisa
    try {
        $count = php artisan tinker --execute="echo App\Models\Master\CodeSystem\Observation\MasterObservationCode::count();" 2>$null
        if ($count -match '\d+') {
            $recordCount = [int]($count -replace '\D', '')
            $speed = [math]::Round($recordCount / [math]::Max($duration, 0.1), 2)

            Write-Host "📊 Total records: $recordCount" -ForegroundColor Cyan
            Write-Host "🏃 Speed: $speed records/detik" -ForegroundColor Cyan
        }
    }
    catch {
        Write-Host "📊 Statistik tidak bisa dihitung" -ForegroundColor Yellow
    }
}

# Fungsi untuk benchmark
function Start-Benchmark {
    param([string]$FilePath)

    Write-Host "🏁 Menjalankan benchmark semua method..." -ForegroundColor Yellow
    Write-Host "=======================================" -ForegroundColor Yellow

    # Siapkan file test kecil dulu
    $testFile = "test_sample.csv"
    $content = Get-Content $FilePath -Head 1001  # 1000 records + header
    $content | Set-Content $testFile

    Write-Host "📊 Testing dengan 1000 records..." -ForegroundColor Cyan

    $methods = @("bulk", "league")

    foreach ($method in $methods) {
        Write-Host ""
        Write-Host "🧪 Testing method: $method" -ForegroundColor Magenta
        Write-Host "------------------------" -ForegroundColor Magenta
        Start-Import -Method $method -FilePath $testFile -ChunkSize 500
        Start-Sleep -Seconds 2
    }

    Remove-Item $testFile -ErrorAction SilentlyContinue
    Write-Host ""
    Write-Host "✅ Benchmark selesai!" -ForegroundColor Green
}

# Fungsi untuk setup environment
function Set-Environment {
    Write-Host "🔧 Setup environment..." -ForegroundColor Yellow

    # Increase PHP memory limit
    $phpIni = php --ini | Select-String "Loaded Configuration File" | ForEach-Object { $_.ToString().Split(":")[1].Trim() }
    if ($phpIni -and (Test-Path $phpIni)) {
        Write-Host "📝 PHP config file: $phpIni" -ForegroundColor Cyan
        Write-Host "💡 Untuk performa optimal, set di php.ini:" -ForegroundColor Yellow
        Write-Host "   memory_limit = 2G" -ForegroundColor White
        Write-Host "   max_execution_time = 0" -ForegroundColor White
        Write-Host "   max_input_time = -1" -ForegroundColor White
    }

    # Check .env configuration
    if (Test-Path ".env") {
        $env = Get-Content ".env"
        $dbConnection = $env | Where-Object { $_ -match "DB_CONNECTION=" }
        Write-Host "🗄️  Database: $dbConnection" -ForegroundColor Cyan

        $queueConnection = $env | Where-Object { $_ -match "QUEUE_CONNECTION=" }
        if ($queueConnection -match "sync") {
            Write-Host "⚠️  Queue menggunakan 'sync'. Untuk parallel processing, gunakan 'database' atau 'redis'" -ForegroundColor Yellow
        }
    }

    Write-Host ""
}

# Main script
function Main {
    # Check prerequisites
    Test-Prerequisites

    # Setup environment info
    Set-Environment

    # Get file path
    do {
        $filePath = Read-Host "📁 Masukkan path file CSV (atau 'exit' untuk keluar)"
        if ($filePath -eq 'exit') { exit 0 }
    } while (-not (Test-CsvFile $filePath))

    # Tanya apakah mau backup
    $backupChoice = Read-Host "💾 Apakah Anda ingin info backup database? (y/n)"
    if ($backupChoice -eq 'y' -or $backupChoice -eq 'Y') {
        Write-Host "💾 Untuk backup manual, gunakan:" -ForegroundColor Cyan
        Write-Host "mysqldump -u root -p mediction master_observation_codes > backup.sql" -ForegroundColor White
    }

    # Main menu loop
    while ($true) {
        Show-Menu
        $choice = Read-Host "Pilih opsi (1-7)"

        switch ($choice) {
            "1" {
                $chunkSize = Read-Host "📦 Masukkan chunk size (default: 1000)"
                if (-not $chunkSize) { $chunkSize = 1000 }
                Start-Import -Method "bulk" -FilePath $filePath -ChunkSize ([int]$chunkSize)
            }
            "2" {
                Start-Import -Method "load-data" -FilePath $filePath
            }
            "3" {
                $chunkSize = Read-Host "📦 Masukkan chunk size (default: 1000)"
                if (-not $chunkSize) { $chunkSize = 1000 }
                Start-Import -Method "league" -FilePath $filePath -ChunkSize ([int]$chunkSize)
            }
            "4" {
                $chunkSize = Read-Host "📦 Masukkan chunk size (default: 5000)"
                if (-not $chunkSize) { $chunkSize = 5000 }
                Start-Import -Method "jobs" -FilePath $filePath -ChunkSize ([int]$chunkSize)
            }
            "5" {
                Start-Import -Method "seeder" -FilePath $filePath
            }
            "6" {
                Start-Benchmark -FilePath $filePath
            }
            "7" {
                Write-Host "👋 Goodbye!" -ForegroundColor Green
                exit 0
            }
            default {
                Write-Host "❌ Pilihan tidak valid" -ForegroundColor Red
            }
        }
    }
}

# Run main function
Main
