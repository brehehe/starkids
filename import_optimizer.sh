#!/bin/bash

# 🚀 CSV Import Optimization Script
# Script untuk mengoptimasi import CSV dengan berbagai method

echo "🚀 CSV Import Optimization Tool"
echo "================================"

# Fungsi untuk menampilkan menu
show_menu() {
    echo ""
    echo "Pilih method import:"
    echo "1. Bulk Insert (Recommended) - Cepat dan reliable"
    echo "2. LOAD DATA INFILE (Fastest) - Tercepat untuk MySQL"
    echo "3. League CSV (Memory Efficient) - Untuk file besar"
    echo "4. Queue Jobs (Parallel) - Untuk file sangat besar"
    echo "5. Benchmark All Methods - Test semua method"
    echo "6. Exit"
    echo ""
}

# Fungsi untuk mengecek file
check_file() {
    local file=$1
    if [ ! -f "$file" ]; then
        echo "❌ File tidak ditemukan: $file"
        exit 1
    fi

    local size=$(du -h "$file" | cut -f1)
    local lines=$(wc -l < "$file")

    echo "📁 File: $file"
    echo "📏 Size: $size"
    echo "📄 Lines: $lines"
    echo ""
}

# Fungsi untuk optimasi MySQL
optimize_mysql() {
    echo "🔧 Mengoptimasi MySQL untuk import besar..."

    mysql -u root -p << EOF
SET GLOBAL innodb_buffer_pool_size = 2147483648;
SET GLOBAL bulk_insert_buffer_size = 268435456;
SET GLOBAL local_infile = 1;
SET GLOBAL general_log = 'OFF';
SET GLOBAL slow_query_log = 'OFF';
FLUSH PRIVILEGES;
EOF

    echo "✅ MySQL telah dioptimasi"
}

# Fungsi untuk backup database
backup_database() {
    echo "💾 Membuat backup database..."
    local timestamp=$(date +"%Y%m%d_%H%M%S")
    local backup_file="backup_observation_codes_${timestamp}.sql"

    mysqldump -u root -p mediction master_observation_codes > $backup_file
    echo "✅ Backup tersimpan: $backup_file"
}

# Fungsi untuk menjalankan import
run_import() {
    local method=$1
    local file=$2
    local chunk_size=${3:-1000}

    echo "⏱️  Memulai import dengan method: $method"
    local start_time=$(date +%s)

    case $method in
        "bulk")
            php artisan import:observation-codes "$file" --method=bulk --chunk-size=$chunk_size --truncate
            ;;
        "load-data")
            php artisan import:observation-codes "$file" --method=load-data --truncate
            ;;
        "league")
            php artisan import:observation-codes "$file" --method=league --chunk-size=$chunk_size --truncate
            ;;
        "jobs")
            php artisan import:observation-codes "$file" --method=jobs --chunk-size=$chunk_size --truncate
            ;;
        "seeder")
            php artisan db:seed --class=OptimizedCodeSeeder
            ;;
    esac

    local end_time=$(date +%s)
    local duration=$((end_time - start_time))

    echo "⏰ Import selesai dalam: ${duration} detik"

    # Hitung statistik
    local count=$(mysql -u root -p -se "SELECT COUNT(*) FROM mediction.master_observation_codes;" 2>/dev/null)
    local speed=$((count / duration))

    echo "📊 Total records: $count"
    echo "🏃 Speed: $speed records/detik"
}

# Fungsi untuk benchmark
benchmark_all() {
    local file=$1

    echo "🏁 Menjalankan benchmark semua method..."
    echo "======================================="

    # Siapkan file test kecil dulu
    local test_file="test_sample.csv"
    head -n 1001 "$file" > $test_file  # 1000 records + header

    echo "📊 Testing dengan 1000 records..."

    for method in "bulk" "league" "jobs"; do
        echo ""
        echo "🧪 Testing method: $method"
        echo "------------------------"
        run_import $method $test_file 500
        sleep 2
    done

    rm $test_file
    echo ""
    echo "✅ Benchmark selesai!"
}

# Main script
main() {
    # Check prerequisites
    if ! command -v php &> /dev/null; then
        echo "❌ PHP tidak ditemukan"
        exit 1
    fi

    if ! command -v mysql &> /dev/null; then
        echo "❌ MySQL tidak ditemukan"
        exit 1
    fi

    # Get file path
    echo "📁 Masukkan path file CSV:"
    read -r file_path

    check_file "$file_path"

    # Tanya apakah mau backup
    echo "💾 Apakah Anda ingin membuat backup database? (y/n)"
    read -r backup_choice

    if [ "$backup_choice" = "y" ] || [ "$backup_choice" = "Y" ]; then
        backup_database
    fi

    # Tanya apakah mau optimasi MySQL
    echo "🔧 Apakah Anda ingin mengoptimasi MySQL? (y/n)"
    read -r optimize_choice

    if [ "$optimize_choice" = "y" ] || [ "$optimize_choice" = "Y" ]; then
        optimize_mysql
    fi

    # Main menu loop
    while true; do
        show_menu
        echo "Pilih opsi (1-6):"
        read -r choice

        case $choice in
            1)
                echo "📦 Masukkan chunk size (default: 1000):"
                read -r chunk_size
                chunk_size=${chunk_size:-1000}
                run_import "bulk" "$file_path" $chunk_size
                ;;
            2)
                run_import "load-data" "$file_path"
                ;;
            3)
                echo "📦 Masukkan chunk size (default: 1000):"
                read -r chunk_size
                chunk_size=${chunk_size:-1000}
                run_import "league" "$file_path" $chunk_size
                ;;
            4)
                echo "📦 Masukkan chunk size (default: 5000):"
                read -r chunk_size
                chunk_size=${chunk_size:-5000}
                run_import "jobs" "$file_path" $chunk_size
                echo "📈 Jalankan workers dengan: php artisan queue:work"
                ;;
            5)
                benchmark_all "$file_path"
                ;;
            6)
                echo "👋 Goodbye!"
                exit 0
                ;;
            *)
                echo "❌ Pilihan tidak valid"
                ;;
        esac
    done
}

# Run main function
main
