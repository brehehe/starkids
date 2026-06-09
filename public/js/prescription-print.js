/**
 * Prescription Print Manager
 * Handles printing functionality for prescriptions and prescription copies
 */

class PrescriptionPrintManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupPrintStyles();
    }

    bindEvents() {
        // Print prescription button
        $(document).on("click", ".print-prescription", (e) => {
            e.preventDefault();
            const transactionId = $(e.target).data("transaction-id");
            this.printPrescription(transactionId);
        });

        // Print copy button
        $(document).on("click", ".print-copy", (e) => {
            e.preventDefault();
            const transactionId = $(e.target).data("transaction-id");
            this.printCopy(transactionId);
        });

        // Quick print buttons
        $(document).on("click", ".quick-print", (e) => {
            e.preventDefault();
            const transactionId = $(e.target).data("transaction-id");
            const type = $(e.target).data("type");

            if (type === "copy") {
                this.printCopy(transactionId);
            } else {
                this.printPrescription(transactionId);
            }
        });
    }

    setupPrintStyles() {
        // Add print-specific styles
        const printStyles = `
            <style id="prescription-print-styles">
                @media print {
                    @page {
                        size: A4 portrait;
                        margin: 15mm;
                    }

                    body {
                        font-size: 10px;
                        line-height: 1.4;
                    }

                    .no-print {
                        display: none !important;
                    }

                    .print-only {
                        display: block !important;
                    }

                    .prescription-container {
                        width: 100% !important;
                        box-shadow: none !important;
                        border-radius: 0 !important;
                    }

                    .watermark {
                        display: block !important;
                        opacity: 0.1;
                    }

                    .copy-indicator {
                        display: block !important;
                        background: #ff5722 !important;
                        color: white !important;
                        padding: 5px 10px !important;
                        border-radius: 4px !important;
                        position: absolute !important;
                        top: 10px !important;
                        right: 15px !important;
                        font-weight: bold !important;
                        text-transform: uppercase !important;
                        z-index: 1000 !important;
                    }
                }
            </style>
        `;

        if ($("#prescription-print-styles").length === 0) {
            $("head").append(printStyles);
        }
    }

    async printPrescription(transactionId) {
        try {
            this.showLoading("Memuat resep...");

            const response = await fetch(
                `/user/prescription/print/${transactionId}`,
                {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "text/html",
                    },
                }
            );

            if (!response.ok) {
                throw new Error("Gagal memuat resep");
            }

            const htmlContent = await response.text();
            this.openPrintWindow(htmlContent, "Resep Obat");
        } catch (error) {
            console.error("Error printing prescription:", error);
            this.showError("Gagal mencetak resep: " + error.message);
        } finally {
            this.hideLoading();
        }
    }

    async printCopy(transactionId) {
        try {
            this.showLoading("Memuat copy resep...");

            const response = await fetch(
                `/user/prescription/print-copy/${transactionId}`,
                {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "text/html",
                    },
                }
            );

            if (!response.ok) {
                throw new Error("Gagal memuat copy resep");
            }

            const htmlContent = await response.text();
            this.openPrintWindow(htmlContent, "Copy Resep Obat");
        } catch (error) {
            console.error("Error printing copy prescription:", error);
            this.showError("Gagal mencetak copy resep: " + error.message);
        } finally {
            this.hideLoading();
        }
    }

    openPrintWindow(htmlContent, title) {
        const printWindow = window.open("", "_blank", "width=800,height=600");

        if (!printWindow) {
            this.showError("Popup diblokir. Izinkan popup untuk mencetak.");
            return;
        }

        printWindow.document.write(htmlContent);
        printWindow.document.close();

        // Wait for content to load then print
        printWindow.onload = () => {
            setTimeout(() => {
                printWindow.print();

                // Close window after printing (optional)
                printWindow.onafterprint = () => {
                    setTimeout(() => {
                        printWindow.close();
                    }, 100);
                };
            }, 500);
        };
    }

    showLoading(message = "Memuat...") {
        // Remove existing loading
        this.hideLoading();

        const loadingHtml = `
            <div id="prescription-loading" class="fixed-top d-flex align-items-center justify-content-center"
                 style="height: 100vh; background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="text-center text-white">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>${message}</p>
                </div>
            </div>
        `;

        $("body").append(loadingHtml);
    }

    hideLoading() {
        $("#prescription-loading").remove();
    }

    showError(message) {
        // Use SweetAlert if available, otherwise use alert
        if (typeof Swal !== "undefined") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: message,
                confirmButtonText: "OK",
            });
        } else {
            alert("Error: " + message);
        }
    }

    showSuccess(message) {
        // Use SweetAlert if available, otherwise use alert
        if (typeof Swal !== "undefined") {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: message,
                timer: 2000,
                showConfirmButton: false,
            });
        } else {
            alert("Success: " + message);
        }
    }
}

// Initialize when document is ready
$(document).ready(function () {
    window.prescriptionPrintManager = new PrescriptionPrintManager();
});

// Global helper functions
window.printPrescription = function (transactionId) {
    window.prescriptionPrintManager.printPrescription(transactionId);
};

window.printCopy = function (transactionId) {
    window.prescriptionPrintManager.printCopy(transactionId);
};

// Export for module usage
if (typeof module !== "undefined" && module.exports) {
    module.exports = PrescriptionPrintManager;
}
