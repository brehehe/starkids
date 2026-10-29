 <button onclick="printInvoiceFromPage()" class="text-green-600 hover:text-green-800 mx-1" title="Cetak Thermal Bluetooth">
     <i class="fas fa-print"></i> Cetak Bluetooth
 </button>
 <button onclick="printInvoiceBrowser()" class="text-purple-600 hover:text-purple-800 mx-1" title="Cetak Browser (window.print)">
     <i class="fas fa-file-invoice"></i> Cetak Browser
 </button>

 <script>
     const PAPER_WIDTH = 48; // 80mm thermal printer ≈ 42–48 karakter

     function printInvoiceBrowser() {
         let iframe = document.getElementById('sale_print_iframe');
         if (!iframe) {
             iframe = document.createElement('iframe');
             iframe.id = 'sale_print_iframe';
             iframe.style.position = 'fixed';
             iframe.style.right = '0';
             iframe.style.bottom = '0';
             iframe.style.width = '0';
             iframe.style.height = '0';
             iframe.style.border = '0';
             iframe.style.visibility = 'hidden';
             document.body.appendChild(iframe);
         }
         iframe.onload = function() {
             try {
                 iframe.contentWindow.focus();
                 iframe.contentWindow.print();
             } catch (e) {
                 window.open('/print/invoice-print?autoprint=1', '_blank');
             }
         };
         iframe.src = '/print/invoice-print?autoprint=1';
     }

     // Format kiri-kanan
     function formatLine(left, right, width = PAPER_WIDTH) {
         left = left.toString();
         right = right.toString();
         let space = width - left.length - right.length;
         if (space < 1) space = 1;
         return left + " ".repeat(space) + right;
     }

     // Format teks rata tengah
     function centerText(text, width = PAPER_WIDTH) {
         let lines = text.split("\n");
         return lines.map(line => {
             line = line.trim();
             let space = Math.floor((width - line.length) / 2);
             if (space < 0) space = 0;
             return " ".repeat(space) + line;
         }).join("\r\n");
     }

     async function printInvoiceFromPage(transactionId) {
         try {
             // 1. Ambil halaman invoice
             let res = await fetch(`/print/invoice-print`);
             let html = await res.text();
             let parser = new DOMParser();
             let doc = parser.parseFromString(html, "text/html");

             // --- Logo Section ---
             let storeName = doc.querySelector(".store-name")?.innerText.trim() ?? "Starkids Medical Center";
             let storeInfo = doc.querySelector(".store-info")?.innerText.trim() ?? "";
             let logoText = centerText(storeName) + "\n";
             if (storeInfo) logoText += centerText(storeInfo) + "\n";
             logoText += "================================================\n";

             // --- Info Section ---
             let infoRows = doc.querySelectorAll(".info-section .info-row");
             let infoText = "";
             infoRows.forEach(row => {
                 let label = row.querySelector(".label, .info-label")?.innerText.trim() ?? "";
                 let value = row.querySelector(".value, .info-value")?.innerText.trim() ?? "";
                 if (label && value) {
                     infoText += formatLine(label, value) + "\n";
                 }
             });
             infoText += "------------------------------------------------\n";

             // --- Detail Transaksi ---
             let itemsText = "";
             let items = doc.querySelectorAll(".transaction-item");
             items.forEach(div => {
                 let name = div.querySelector(".item-name")?.innerText.trim() || "";
                 let total = div.querySelector(".item-total")?.innerText.trim() || "";
                 if (name) {
                     let namaFix = name.length > 25 ? name.substring(0, 25) + "…" : name;
                     itemsText += formatLine(namaFix, total) + "\n";
                 }
             });

             // --- Summary ---
             let summaryRows = doc.querySelectorAll(".summary-section .summary-row");
             let summaryText = "\n------------------------------------------------\n";
             summaryRows.forEach(row => {
                 let label = row.querySelector(".label")?.innerText.trim() ?? "";
                 let value = row.querySelector(".value")?.innerText.trim() ?? "";

                 if (label && value) {
                     // ✅ Jika label = TOTAL, kasih ESC/POS bold
                     if (label.toUpperCase() === "TOTAL") {
                         let boldOn = "\x1B\x45\x01"; // ESC E 1 → Bold ON
                         let boldOff = "\x1B\x45\x00"; // ESC E 0 → Bold OFF
                         summaryText += boldOn + formatLine(label, value) + boldOff + "\n";
                     } else {
                         summaryText += formatLine(label, value) + "\n";
                     }
                 }
             });
             // --- Footer ---
             let footer = doc.querySelector(".footer")?.innerText.trim() ?? "";
             let footerText = "\n------------------------------------------------\n" +
                 centerText(footer) + "\n\n";

             let printEnd = "\n\n\n\n\n";

             // ✅ Satukan semua
             let invoiceText = logoText + infoText + itemsText + summaryText + footerText + printEnd;

             // 2. Deteksi platform
             let ua = navigator.userAgent.toLowerCase();
             if (/android/.test(ua)) {
                 // Android → arahkan ke RawBT
                 printWithRawBT(invoiceText);
                 return;
             } else if (/iphone|ipad|ipod/.test(ua)) {
                 alert("⚠️ Print langsung via Bluetooth tidak didukung di iOS. Gunakan AirPrint / Aplikasi Native.");
                 return;
             } else {
                 // Desktop → coba Web Bluetooth (BLE)
                 await printWithWebBluetooth(invoiceText);
             }

         } catch (err) {
             console.error("⚠️ Gagal print:", err);
             let msg = err?.message ?? (typeof err === "string" ? err : JSON.stringify(err));
             alert("⚠️ Gagal print: " + msg);
         }
     }

     // 🟢 Android RawBT Flow
     function printWithRawBT(text) {
         let encoded = encodeURIComponent(text);
         // RawBT protocol
         window.location.href = "rawbt:" + encoded;
     }

     // 🟢 Desktop Web Bluetooth Flow (BLE printer only)
     async function printWithWebBluetooth(invoiceText) {
         const device = await navigator.bluetooth.requestDevice({
             acceptAllDevices: true,
             optionalServices: ['battery_service']
         });

         const server = await device.gatt.connect();
         const services = await server.getPrimaryServices();

         let writableChar = null;
         for (const service of services) {
             const characteristics = await service.getCharacteristics();
             for (const char of characteristics) {
                 if (char.properties.write || char.properties.writeWithoutResponse) {
                     writableChar = char;
                     break;
                 }
             }
             if (writableChar) break;
         }

         if (!writableChar) throw new Error("Tidak menemukan characteristic 'write' di printer!");

         // ESC/POS: atur font kecil (~10px) + line spacing standard
         let encoder = new TextEncoder();
         let escposInit = new Uint8Array([0x1B, 0x40]); // init printer (ESC @)
         let escposFontB = new Uint8Array([0x1B, 0x4D, 0x01]); // font B (kecil)
         let escposLineSpacing = new Uint8Array([0x1B, 0x32]); // default line spacing standard 1/6 inch (~30 dots) (ESC 2)
         let escposCut = new Uint8Array([0x1D, 0x56, 0x00]); // cut

         let body = encoder.encode(invoiceText);

         // Gabungkan semua command
         let fullData = new Uint8Array(
             escposInit.length + escposFontB.length + escposLineSpacing.length + body.length + escposCut.length
         );
         let offset = 0;
         fullData.set(escposInit, offset);
         offset += escposInit.length;
         fullData.set(escposFontB, offset);
         offset += escposFontB.length;
         fullData.set(escposLineSpacing, offset);
         offset += escposLineSpacing.length;
         fullData.set(body, offset);
         offset += body.length;
         fullData.set(escposCut, offset);

         // Kirim per chunk kecil (48 byte) dengan pacing untuk mencegah buffer overflow printer BLE
         const chunkSize = 48;
         for (let i = 0; i < fullData.length; i += chunkSize) {
             let chunk = fullData.slice(i, i + chunkSize);
             if (writableChar.properties.write && typeof writableChar.writeValueWithResponse === 'function') {
                 try {
                     await writableChar.writeValueWithResponse(chunk);
                 } catch (e) {
                     if (typeof writableChar.writeValueWithoutResponse === 'function') {
                         await writableChar.writeValueWithoutResponse(chunk);
                     } else {
                         await writableChar.writeValue(chunk);
                     }
                 }
             } else if (typeof writableChar.writeValueWithoutResponse === 'function') {
                 await writableChar.writeValueWithoutResponse(chunk);
             } else {
                 await writableChar.writeValue(chunk);
             }
             await new Promise(r => setTimeout(r, 40));
         }

         alert("✅ Invoice berhasil dikirim ke printer via Web Bluetooth!");
     }
 </script>
