/**
 * Prescription Copy Utilities
 * Fungsi-fungsi untuk copy dan manipulasi resep
 */

class PrescriptionCopy {
    constructor() {
        this.currentPrescription = null;
        this.copyHistory = [];
        this.init();
    }

    init() {
.addCopyButtons();
        this.setupKeyboardShortcuts();
        this.loadCopyHistory();
    }

    // Menambahkan tombol copy ke semua elemen resep
    addCopyButtons() {
        const prescriptions = document.querySelectorAll('.prescription-container');
        prescriptions.forEach((prescription, index) => {
            this.addCopyButtonToElement(prescription, index);
        });
    }

    // Menambahkan tombol copy ke elemen tertentu
    addCopyButtonToElement(element, index) {
        const copyButton = document.createElement('button');
        copyButton.className = 'copy-btn';
        copyButton.innerHTML = '<i class="fas fa-copy"></i> Copy Resep';
        copyButton.style.cssText = `
            position: absolute;
            top: 10px;
            left: 10px;
            background: #FF9800;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        `;

        copyButton.addEventListener('click', (e) => {
            e.stopPropagation();
            this.copyPrescription(element, index);
        });

        copyButton.addEventListener('mouseenter', () => {
            copyButton.style.background = '#F57C00';
            copyButton.style.transform = 'translateY(-2px)';
        });

        copyButton.addEventListener('mouseleave', () => {
            copyButton.style.background = '#FF9800';
            copyButton.style.transform = 'translateY(0)';
        });

        element.style.position = 'relative';
        element.appendChild(copyButton);
    }

    // Copy resep dengan berbagai format
    copyPrescription(element, index) {
        const prescriptionData = this.extractPrescriptionData(element);
        this.currentPrescription = prescriptionData;

        // Tampilkan menu copy options
        this.showCopyOptions(prescriptionData, element);
    }

    // Extract data dari elemen resep
    extractPrescriptionData(element) {
        const data = {
            number: this.getTextContent(element, '.prescription-number'),
            date: this.getTextContent(element, '.prescription-info'),
            doctor: {
                name: this.getTextContent(element, '.doctor-details strong'),
                specialization: this.getTextContent(element, '.doctor-details', 1),
                license: this.getTextContent(element, '.signature-license')
            },
            patient: {
                name: this.getTextContent(element, '.patient-value'),
                age: this.getTextContent(element, '.patient-details .patient-row:nth-child(2) .patient-value'),
                gender: this.getTextContent(element, '.patient-details .patient-row:nth-child(3) .patient-value'),
                address: this.getTextContent(element, '.patient-details .patient-row:nth-child(4) .patient-value'),
                phone: this.getTextContent(element, '.patient-details .patient-row:nth-child(5) .patient-value'),
                diagnosis: this.getTextContent(element, '.patient-details .patient-row:nth-child(6) .patient-value')
            },
            medicines: this.extractMedicines(element),
            notes: this.getTextContent(element, '.notes-content'),
            clinic: {
                name: this.getTextContent(element, '.clinic-info'),
                address: 'Jl. Kesehatan No. 123, Jakarta Selatan'
            }
        };

        return data;
    }

    // Extract data obat dari tabel
    extractMedicines(element) {
        const medicines = [];
        const rows = element.querySelectorAll('.prescription-table tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 5) {
                medicines.push({
                    no: cells[0].textContent.trim(),
                    name: cells[1].querySelector('.medicine-name')?.textContent.trim() || '',
                    details: cells[1].querySelector('.medicine-details')?.textContent.trim() || '',
                    dosage: cells[2].textContent.trim(),
                    quantity: cells[3].textContent.trim(),
                    instruction: cells[4].textContent.trim()
                });
            }
        });

        return medicines;
    }

    // Helper untuk mengambil text content
    getTextContent(element, selector, index = 0) {
        const elements = element.querySelectorAll(selector);
        return elements[index]?.textContent.trim() || '';
    }

    // Tampilkan opsi copy
    showCopyOptions(data, element) {
        const modal = this.createCopyModal(data);
        document.body.appendChild(modal);

        // Auto focus pada modal
        setTimeout(() => {
            modal.style.opacity = '1';
            modal.style.transform = 'scale(1)';
        }, 10);
    }

    // Buat modal copy options
    createCopyModal(data) {
        const modal = document.createElement('div');
        modal.className = 'copy-modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.3s ease;
        `;

        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        `;

        content.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3><i class="fas fa-copy"></i> Copy Resep</h3>
                <button class="close-modal" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            </div>

            <div class="copy-options" style="display: grid; gap: 15px;">
                <button class="copy-option-btn" data-format="text">
                    <i class="fas fa-file-alt"></i>
                    <div>
                        <strong>Text Format</strong>
                        <small>Copy sebagai text biasa</small>
                    </div>
                </button>

                <button class="copy-option-btn" data-format="structured">
                    <i class="fas fa-list"></i>
                    <div>
                        <strong>Format Terstruktur</strong>
                        <small>Copy dengan format rapi</small>
                    </div>
                </button>

                <button class="copy-option-btn" data-format="json">
                    <i class="fas fa-code"></i>
                    <div>
                        <strong>JSON Format</strong>
                        <small>Copy sebagai data JSON</small>
                    </div>
                </button>

                <button class="copy-option-btn" data-format="csv">
                    <i class="fas fa-table"></i>
                    <div>
                        <strong>CSV Format</strong>
                        <small>Copy untuk spreadsheet</small>
                    </div>
                </button>

                <button class="copy-option-btn" data-format="whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    <div>
                        <strong>WhatsApp Format</strong>
                        <small>Copy untuk chat WhatsApp</small>
                    </div>
                </button>

                <button class="copy-option-btn" data-format="email">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email Format</strong>
                        <small>Copy untuk email</small>
                    </div>
                </button>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <h4>Preview:</h4>
                <div id="copy-preview" style="background: #f5f5f5; padding: 15px; border-radius: 4px; font-family: monospace; font-size: 12px; max-height: 200px; overflow-y: auto; white-space: pre-wrap;"></div>
            </div>
        `;

        modal.appendChild(content);

        // Add event listeners
        this.setupCopyModalEvents(modal, data);

        return modal;
    }

    // Setup event listeners untuk modal
    setupCopyModalEvents(modal, data) {
        const closeBtn = modal.querySelector('.close-modal');
        const optionBtns = modal.querySelectorAll('.copy-option-btn');
        const preview = modal.querySelector('#copy-preview');

        // Close modal
        closeBtn.addEventListener('click', () => this.closeCopyModal(modal));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) this.closeCopyModal(modal);
        });

        // Copy option buttons
        optionBtns.forEach(btn => {
            btn.style.cssText = `
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 6px;
                background: white;
                cursor: pointer;
                transition: all 0.3s ease;
                text-align: left;
                width: 100%;
            `;

            btn.addEventListener('mouseenter', () => {
                btn.style.background = '#f8f9fa';
                btn.style.borderColor = '#2196F3';
                btn.style.transform = 'translateY(-2px)';

                // Show preview
                const format = btn.dataset.format;
                const formattedText = this.formatPrescription(data, format);
                preview.textContent = formattedText.substring(0, 500) + (formattedText.length > 500 ? '...' : '');
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.background = 'white';
                btn.style.borderColor = '#ddd';
                btn.style.transform = 'translateY(0)';
            });

            btn.addEventListener('click', () => {
                const format = btn.dataset.format;
                this.copyToClipboard(data, format);
                this.closeCopyModal(modal);
            });
        });

        // Show default preview
        const defaultFormat = this.formatPrescription(data, 'text');
        preview.textContent = defaultFormat.substring(0, 500) + (defaultFormat.length > 500 ? '...' : '');
    }

    // Format resep sesuai dengan format yang dipilih
    formatPrescription(data, format) {
        switch (format) {
            case 'text':
                return this.formatAsText(data);
            case 'structured':
                return this.formatAsStructured(data);
            case 'json':
                return JSON.stringify(data, null, 2);
            case 'csv':
                return this.formatAsCSV(data);
            case 'whatsapp':
                return this.formatAsWhatsApp(data);
            case 'email':
                return this.formatAsEmail(data);
            default:
                return this.formatAsText(data);
        }
    }

    // Format sebagai text biasa
    formatAsText(data) {
        return `
RESEP OBAT
${data.number}
Tanggal: ${new Date().toLocaleDateString('id-ID')}

DOKTER: ${data.doctor.name}
PASIEN: ${data.patient.name} (${data.patient.age})
DIAGNOSIS: ${data.patient.diagnosis}

OBAT:
${data.medicines.map((med, index) =>
    `${index + 1}. ${med.name} - ${med.dosage} - ${med.quantity}\n   ${med.instruction}`
).join('\n')}

CATATAN: ${data.notes}
        `.trim();
    }

    // Format terstruktur
    formatAsStructured(data) {
        return `
╔══════════════════════════════════════╗
║              RESEP OBAT              ║
╚══════════════════════════════════════╝

📋 ${data.number}
📅 ${new Date().toLocaleDateString('id-ID')}

👨‍⚕️ DOKTER
   Nama: ${data.doctor.name}
   Spesialisasi: ${data.doctor.specialization}

👤 PASIEN
   Nama: ${data.patient.name}
   Umur: ${data.patient.age}
   Diagnosis: ${data.patient.diagnosis}

💊 DAFTAR OBAT
${data.medicines.map((med, index) =>
    `   ${index + 1}. ${med.name}
      Dosis: ${med.dosage}
      Jumlah: ${med.quantity}
      Aturan: ${med.instruction}`
).join('\n\n')}

📝 CATATAN
${data.notes}
        `.trim();
    }

    // Format CSV
    formatAsCSV(data) {
        let csv = 'No,Nama Obat,Dosis,Jumlah,Aturan Pakai\n';
        data.medicines.forEach(med => {
            csv += `"${med.no}","${med.name}","${med.dosage}","${med.quantity}","${med.instruction}"\n`;
        });
        return csv;
    }

    // Format WhatsApp
    formatAsWhatsApp(data) {
        return `
🏥 *RESEP OBAT*
${data.number}

👨‍⚕️ *Dokter:* ${data.doctor.name}
👤 *Pasien:* ${data.patient.name}
🩺 *Diagnosis:* ${data.patient.diagnosis}

💊 *OBAT-OBATAN:*
${data.medicines.map((med, index) =>
    `${index + 1}. *${med.name}*\n   📋 ${med.dosage} | 📦 ${med.quantity}\n   ℹ️ ${med.instruction}`
).join('\n\n')}

📝 *Catatan:* ${data.notes}

_Simpan resep ini dengan baik_
        `.trim();
    }

    // Format Email
    formatAsEmail(data) {
        return `
Subject: Resep Obat - ${data.patient.name} (${data.number})

Kepada Yth. Apoteker,

Berikut adalah resep obat untuk pasien:

INFORMASI PASIEN:
- Nama: ${data.patient.name}
- Umur: ${data.patient.age}
- Diagnosis: ${data.patient.diagnosis}

DOKTER PEMERIKSA:
- ${data.doctor.name}
- ${data.doctor.specialization}

DAFTAR OBAT:
${data.medicines.map((med, index) =>
    `${index + 1}. ${med.name}
   Dosis: ${med.dosage}
   Jumlah: ${med.quantity}
   Aturan Pakai: ${med.instruction}`
).join('\n\n')}

CATATAN KHUSUS:
${data.notes}

Mohon disiapkan sesuai dengan resep di atas.

Terima kasih,
${data.doctor.name}
        `.trim();
    }

    // Copy ke clipboard
    async copyToClipboard(data, format) {
        const formattedText = this.formatPrescription(data, format);

        try {
            await navigator.clipboard.writeText(formattedText);
            this.showNotification(`Resep berhasil disalin dalam format ${format.toUpperCase()}!`);
            this.addToCopyHistory(data, format);
        } catch (err) {
            // Fallback untuk browser lama
            this.fallbackCopyToClipboard(formattedText);
            this.showNotification(`Resep berhasil disalin dalam format ${format.toUpperCase()}!`);
            this.addToCopyHistory(data, format);
        }
    }

    // Fallback copy method
    fallbackCopyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
    }

    // Tutup modal
    closeCopyModal(modal) {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.9)';
        setTimeout(() => {
            document.body.removeChild(modal);
        }, 300);
    }

    // Tambah ke history
    addToCopyHistory(data, format) {
        const historyItem = {
            timestamp: new Date().toISOString(),
            patient: data.patient.name,
            format: format,
            preview: this.formatPrescription(data, format).substring(0, 100) + '...'
        };

        this.copyHistory.unshift(historyItem);
        if (this.copyHistory.length > 10) {
            this.copyHistory = this.copyHistory.slice(0, 10);
        }

        this.saveCopyHistory();
    }

    // Simpan history ke localStorage
    saveCopyHistory() {
        localStorage.setItem('prescriptionCopyHistory', JSON.stringify(this.copyHistory));
    }

    // Load history dari localStorage
    loadCopyHistory() {
        const saved = localStorage.getItem('prescriptionCopyHistory');
        if (saved) {
            this.copyHistory = JSON.parse(saved);
        }
    }

    // Setup keyboard shortcuts
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+Shift+C untuk copy resep
            if (e.ctrlKey && e.shiftKey && e.key === 'C') {
                e.preventDefault();
                const prescription = document.querySelector('.prescription-container');
                if (prescription) {
                    this.copyPrescription(prescription, 0);
                }
            }
        });
    }

    // Show notification
    showNotification(message, type = 'success') {
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
            animation: slideInRight 0.3s ease;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
}

// CSS Animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.prescriptionCopy = new PrescriptionCopy();
});

// Export untuk penggunaan manual
window.PrescriptionCopy = PrescriptionCopy;
