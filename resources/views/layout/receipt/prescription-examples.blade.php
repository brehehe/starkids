<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contoh Template Resep Obat</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Arial', sans-serif;
                background: #f5f5f5;
                padding: 20px;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
            }

            .header {
                text-align: center;
                margin-bottom: 30px;
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .header h1 {
                color: #1976D2;
                font-size: 28px;
                margin-bottom: 10px;
            }

            .header p {
                color: #666;
                font-size: 16px;
            }

            .templates-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }

            .template-card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transition: transform 0.3s ease;
            }

            .template-card:hover {
                transform: translateY(-5px);
            }

            .template-preview {
                height: 200px;
                background: linear-gradient(135deg, #e3f2fd, #bbdefb);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }

            .template-preview::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50" font-size="12" fill="%23666" opacity="0.3">RESEP OBAT</text></svg>') center/contain no-repeat;
            }

            .template-icon {
                font-size: 48px;
                color: #1976D2;
                z-index: 1;
            }

            .template-info {
                padding: 20px;
            }

            .template-title {
                font-size: 18px;
                font-weight: bold;
                color: #333;
                margin-bottom: 8px;
            }

            .template-description {
                color: #666;
                font-size: 14px;
                line-height: 1.5;
                margin-bottom: 15px;
            }

            .template-features {
                list-style: none;
                margin-bottom: 20px;
            }

            template-features li {
                nt-size: 12px;
                color: #555;
                margin-bottom: 5px;
                padding-left: 15px;
                position: relative;
            }

            .template-features li::before {
                content: '✓';
                position: absolute;
                left: 0;
                color: #4CAF50;
                font-weight: bold;
            }

            .template-actions {
                display: flex;
                gap: 10px;
            }

            .btn {
                padding: 8px 16px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 12px;
                font-weight: 500;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                transition: all 0.3s ease;
            }

            .btn-primary {
                background: #2196F3;
                color: white;
            }

            .btn-secondary {
                background: #f5f5f5;
                color: #333;
                border: 1px solid #ddd;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .quick-actions {
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .quick-actions h3 {
                color: #333;
                margin-bottom: 15px;
            }

            .quick-actions-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .quick-action-btn {
                padding: 15px;
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 6px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                color: #333;
            }

            .quick-action-btn:hover {
                background: #e9ecef;
                transform: translateY(-2px);
            }

            .quick-action-icon {
                font-size: 24px;
                margin-bottom: 8px;
                display: block;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: white;
                margin: 5% auto;
                padding: 20px;
                border-radius: 8px;
                width: 90%;
                max-width: 800px;
                max-height: 80vh;
                overflow-y: auto;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }

            .close:hover {
                color: #000;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: 500;
                color: #333;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                width: 100%;
                padding: 8px 12px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 14px;
            }

            .form-group textarea {
                height: 80px;
                resize: vertical;
            }

            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            @media (max-width: 768px) {
                .templates-grid {
                    grid-template-columns: 1fr;
                }

                .form-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>

    <body>
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1><i class="fas fa-prescription-bottle-alt"></i> Template Resep Obat</h1>
                <p>Pilih template resep yang sesuai dengan kebutuhan klinik atau apotek Anda</p>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
                <div class="quick-actions-grid">
                    <a href="#" class="quick-action-btn" onclick="openCustomForm()">
                        <i class="fas fa-plus-circle quick-action-icon"></i>
                        <div>Buat Resep Baru</div>
                    </a>
                    <a href="#" class="quick-action-btn" onclick="loadSampleData()">
                        <i class="fas fa-file-medical quick-action-icon"></i>
                        <div>Muat Data Contoh</div>
                    </a>
                    <a href="#" class="quick-action-btn" onclick="showPrintOptions()">
                        <i class="fas fa-print quick-action-icon"></i>
                        <div>Opsi Cetak</div>
                    </a>
                    <a href="#" class="quick-action-btn" onclick="exportTemplates()">
                        <i class="fas fa-download quick-action-icon"></i>
                        <div>Export Template</div>
                    </a>
                </div>
            </div>

            <!-- Templates Grid -->
            <div class="templates-grid">
                <!-- Template 1: Resep Umum -->
                <div class="template-card">
                    <div class="template-preview">
                        <i class="fas fa-file-medical template-icon"></i>
                    </div>
                    <div class="template-info">
                        <div class="template-title">Resep Umum</div>
                        <div class="template-description">
                            Template standar untuk resep obat umum dengan format lengkap sesuai standar medis Indonesia.
                        </div>
                        <ul class="template-features">
                            <li>Header klinik/apotek</li>
                            <li>Data dokter dan pasien</li>
                            <li>Tabel obat dengan dosis</li>
                            <li>Catatan dan instruksi</li>
                            <li>Tanda tangan digital</li>
                        </ul>
                        <div class="template-actions">
                            <a href="#" class="btn btn-primary" onclick="useTemplate('general')">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                            <a href="#" class="btn btn-secondary" onclick="copyTemplate('general')">
                                <i class="fas fa-copy"></i> Copy
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Template 2: Resep Anak -->
                <div class="template-card">
                    <div class="template-preview">
                        <i class="fas fa-baby template-icon"></i>
                    </div>
                    <div class="template-info">
                        <div class="template-title">Resep Anak</div>
                        <div class="template-description">
                            Template khusus untuk resep anak dengan perhitungan dosis berdasarkan berat badan dan usia.
                        </div>
                        <ul class="template-features">
                            <li>Perhitungan dosis anak</li>
                            <li>Peringatan khusus</li>
                            <li>Bentuk sediaan anak</li>
                            <li>Instruksi untuk orang tua</li>
                            <li>Jadwal pemberian obat</li>
                        </ul>
                        <div class="template-actions">
                            <a href="#" class="btn btn-primary" onclick="useTemplate('pediatric')">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                            <a href="#" class="btn btn-secondary" onclick="copyTemplate('pediatric')">
                                <i class="fas fa-copy"></i> Copy
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Template 3: Resep Rawat Inap -->
                <div class="template-card">
                    <div class="template-preview">
                        <i class="fas fa-hospital template-icon"></i>
                    </div>
                    <div class="template-info">
                        <div class="template-title">Resep Rawat Inap</div>
                        <div class="template-description">
                            Template untuk pasien rawat inap dengan jadwal pemberian obat yang detail dan monitoring.
                        </div>
                        <ul class="template-features">
                            <li>Jadwal pemberian 24 jam</li>
                            <li>Rute pemberian obat</li>
                            <li>Monitoring efek samping</li>
                            <li>Instruksi perawat</li>
                            <li>Catatan khusus</li>
                        </ul>
                        <div class="template-actions">
                            <a href="#" class="btn btn-primary" onclick="useTemplate('inpatient')">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                            <a href="#" class="btn btn-secondary" onclick="copyTemplate('inpatient')">
                                <i class="fas fa-copy"></i> Copy
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Template 4: Resep Psikotropika -->
                <div class="template-card">
                    <div class="template-preview">
                        <i class="fas fa-brain template-icon"></i>
                    </div>
                    <div class="template-info">
                        <div class="template-title">Resep Psikotropika</div>
                        <div class="template-description">
                            Template khusus untuk obat psikotropika dengan keamanan dan dokumentasi ekstra.
                        </div>
                        <ul class="template-features">
                            <li>Nomor seri khusus</li>
                            <li>Validasi ganda</li>
                            <li>Peringatan keamanan</li>
                            <li>Dokumentasi lengkap</li>
                            <li>Tracking pemberian</li>
                        </ul>
                        <div class="template-actions">
                            <a href="#" class="btn btn-primary" onclick="useTemplate('psychotropic')">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                            <a href="#" class="btn btn-secondary" onclick="copyTemplate('psychotropic')">
                                <i class="fas fa-copy"></i> Copy
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Template 5: Resep Herbal -->
                <div class="template-card">
                    <div class="template-preview">
                        <i class="fas fa-leaf template-icon"></i>
                    </div>
                    <div class="template-info">
                        <div class="template-title">Resep Herbal</div>
                        <div class="template-description">
                            Template untuk obat herbal dan tradisional dengan informasi komposisi dan cara pembuatan.
                        </div>
                        <ul class="template-features">
                            <li>Komposisi herbal</li>
                            <li>Cara pembuatan</li>
                            <li>Durasi penggunaan</li>
                            <li>Pantangan makanan</li>
                            <li>Efek samping minimal</li>
                        </ul>
                        <div class="template-actions">
                            <a href="#" class="btn btn-primary" onclick="useTemplate('herbal')">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                            <a href="#" class="btn btn-secondary" onclick="copyTemplate('herbal')">
                                <i class="fas fa-copy"></i> Copy
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Template 6: Resep Emergensi -->
                <div class="template-card">
                    <div class="template-preview">
                        <i class="fas fa-ambulance template-icon"></i>
                    </div>
                    <div class="template-info">
                        <div class="template-title">Resep Emergensi</div>
                        <div class="template-description">
                            Template untuk situasi darurat dengan prioritas tinggi dan instruksi cepat.
                        </div>
                        <ul class="template-features">
                            <li>Prioritas STAT</li>
                            <li>Instruksi darurat</li>
                            <li>Kontak emergency</li>
                            <li>Monitoring ketat</li>
                            <li>Dokumentasi cepat</li>
                        </ul>
                        <div class="template-actions">
                            <a href="#" class="btn btn-primary" onclick="useTemplate('emergency')">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                            <a href="#" class="btn btn-secondary" onclick="copyTemplate('emergency')">
                                <i class="fas fa-copy"></i> Copy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Custom Form -->
        <div id="customModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2><i class="fas fa-plus-circle"></i> Buat Resep Baru</h2>
                <form id="customPrescriptionForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Dokter</label>
                            <input type="text" id="doctorName" placeholder="Dr. Nama Dokter">
                        </div>
                        <div class="form-group">
                            <label>Spesialisasi</label>
                            <input type="text" id="specialization" placeholder="Spesialis...">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Pasien</label>
                            <input type="text" id="patientName" placeholder="Nama Lengkap Pasien">
                        </div>
                        <div class="form-group">
                            <label>Umur</label>
                            <input type="text" id="patientAge" placeholder="35 Tahun">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Diagnosis</label>
                        <textarea id="diagnosis" placeholder="Diagnosis utama..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Catatan Khusus</label>
                        <textarea id="specialNotes" placeholder="Catatan atau instruksi khusus..."></textarea>
                    </div>

                    <div style="text-align: right; margin-top: 20px;">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="generateCustomPrescription()">
                            <i class="fas fa-file-medical"></i> Buat Resep
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Template data
            const templates = {
                general: {
                    title: 'Resep Umum',
                    doctor: 'Dr. Ahmad Santoso, Sp.PD',
                    patient: 'Budi Santoso',
                    diagnosis: 'Hipertensi Grade 1',
                    medicines: [{
                            name: 'Amlodipine 5mg',
                            dosage: '1x1',
                            quantity: '30 tablet',
                            instruction: 'Diminum pagi hari setelah makan'
                        },
                        {
                            name: 'Vitamin B Complex',
                            dosage: '1x1',
                            quantity: '30 tablet',
                            instruction: 'Diminum setelah makan'
                        }
                    ]
                },
                pediatric: {
                    title: 'Resep Anak',
                    doctor: 'Dr. Sarah Pediatri, Sp.A',
                    patient: 'Andi (8 tahun, 25kg)',
                    diagnosis: 'ISPA (Infeksi Saluran Pernapasan Atas)',
                    medicines: [{
                            name: 'Amoxicillin Sirup 125mg/5ml',
                            dosage: '3x1 cth',
                            quantity: '1 botol',
                            instruction: 'Diminum 3x sehari setelah makan, habiskan'
                        },
                        {
                            name: 'Paracetamol Sirup 120mg/5ml',
                            dosage: '3x1 cth',
                            quantity: '1 botol',
                            instruction: 'Diminum jika demam >38°C'
                        }
                    ]
                },
                inpatient: {
                    title: 'Resep Rawat Inap',
                    doctor: 'Dr. Budi Internal, Sp.PD',
                    patient: 'Siti Aminah (Kamar 201)',
                    diagnosis: 'Diabetes Mellitus Tipe 2 dengan Komplikasi',
                    medicines: [{
                            name: 'Insulin Rapid Acting',
                            dosage: '3x8 unit SC',
                            quantity: 'PRN',
                            instruction: 'Sebelum makan, sesuaikan dengan GDS'
                        },
                        {
                            name: 'Metformin 500mg',
                            dosage: '2x1 tab',
                            quantity: 'Selama rawat inap',
                            instruction: 'Setelah makan pagi dan malam'
                        }
                    ]
                }
            };

            function useTemplate(templateType) {
                const template = templates[templateType];
                if (template) {
                    // Generate prescription with template data
                    generatePrescription(template);
                }
            }

            function copyTemplate(templateType) {
                const template = templates[templateType];
                if (template) {
                    const templateText = `
TEMPLATE: ${template.title}
Dokter: ${template.doctor}
Pasien: ${template.patient}
Diagnosis: ${template.diagnosis}

OBAT:
${template.medicines.map((med, index) =>
    `${index + 1}. ${med.name} - ${med.dosage} - ${med.quantity}
           ${med.instruction}`
).join('\n')}
                `.trim();

                    navigator.clipboard.writeText(templateText).then(() => {
                        showNotification('Template berhasil disalin ke clipboard!');
                    }).catch(() => {
                        showNotification('Gagal menyalin template', 'error');
                    });
                }
            }

            function generatePrescription(data) {
                // Open new window with prescription
                const prescriptionWindow = window.open('', '_blank');
                prescriptionWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Resep - ${data.patient}</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        .header { text-align: center; border-bottom: 2px solid #2196F3; padding-bottom: 10px; margin-bottom: 20px; }
                        .patient-info { background: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 5px; }
                        .medicines { margin: 20px 0; }
                        .medicine-item { padding: 10px; border-left: 3px solid #2196F3; margin: 10px 0; background: #f9f9f9; }
                        .signature { margin-top: 40px; text-align: right; }
                        @media print { body { margin: 0; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>RESEP OBAT</h1>
                        <p>No. RCP-${Date.now()}</p>
                        <p>Tanggal: ${new Date().toLocaleDateString('id-ID')}</p>
                    </div>

                    <div class="patient-info">
                        <h3>Data Pasien</h3>
                        <p><strong>Nama:</strong> ${data.patient}</p>
                        <p><strong>Dokter:</strong> ${data.doctor}</p>
                        <p><strong>Diagnosis:</strong> ${data.diagnosis}</p>
                    </div>

                    <div class="medicines">
                        <h3>Daftar Obat</h3>
                        ${data.medicines.map((med, index) => `
                                    <div class="medicine-item">
                                        <strong>${index + 1}. ${med.name}</strong><br>
                                        Dosis: ${med.dosage} | Jumlah: ${med.quantity}<br>
                                        <em>${med.instruction}</em>
                                    </div>
                                `).join('')}
                            </div>

                            <div class="signature">
                                <p>Jakarta, ${new Date().toLocaleDateString('id-ID')}</p>
                                <br><br>
                                <p>${data.doctor}</p>
                            </div>

                            <script>
                                function printPrescription() { window.print(); }
                                window.onload = function() {
                                    document.body.innerHTML += '<div style="position:fixed;top:10px;right:10px;"><button onclick="printPrescription()" style="padding:10px;background:#2196F3;color:white;border:none;border-radius:4px;cursor:pointer;">Cetak</button></div>';
                                }
        </script>
    </body>

</html>
`);
}

function openCustomForm() {
document.getElementById('customModal').style.display = 'block';
}

function closeModal() {
document.getElementById('customModal').style.display = 'none';
}

function generateCustomPrescription() {
const customData = {
title: 'Resep Custom',
doctor: document.getElementById('doctorName').value || 'Dr. Dokter',
patient: document.getElementById('patientName').value || 'Pasien',
diagnosis: document.getElementById('diagnosis').value || 'Diagnosis',
medicines: [
{ name: 'Obat sesuai diagnosis', dosage: 'Sesuai kebutuhan', quantity: 'Sesuai resep', instruction:
document.getElementById('specialNotes').value || 'Sesuai petunjuk dokter' }
]
};

generatePrescription(customData);
closeModal();
}

function loadSampleData() {
useTemplate('general');
showNotification('Data contoh berhasil dimuat!');
}

function showPrintOptions() {
alert('Opsi Cetak:\n1. Cetak langsung dari preview\n2. Export ke PDF\n3. Cetak dengan watermark\n4. Cetak copy resep');
}

function exportTemplates() {
const allTemplates = JSON.stringify(templates, null, 2);
const blob = new Blob([allTemplates], { type: 'application/json' });
const url = URL.createObjectURL(blob);
const a = document.createElement('a');
a.href = url;
a.download = 'prescription-templates.json';
a.click();
URL.revokeObjectURL(url);
showNotification('Template berhasil diexport!');
}

function showNotification(message, type = 'success') {
const notification = document.createElement('div');
notification.textContent = message;
notification.style.cssText = `
position: fixed;
top: 20px;
right: 20px;
background: ${type === 'success' ? '#4CAF50' : '#f44336'};
color: white;
padding: 12px 20px;
border-radius: 4px;
z-index: 1001;
font-size: 14px;
box-shadow: 0 2px 8px rgba(0,0,0,0.2);
`;

document.body.appendChild(notification);

setTimeout(() => {
document.body.removeChild(notification);
}, 3000);
}

// Close modal when clicking outside
window.onclick = function(event) {
const modal = document.getElementById('customModal');
if (event.target === modal) {
closeModal();
}
}
</script>
</body>

</html>
