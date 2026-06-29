from flask import Flask, request, jsonify
import win32print
import serial
import serial.tools.list_ports
import traceback

app = Flask(__name__)

SELECTED_PRINTER = None
PRINTER_TYPE = None   # "windows", "com", "bluetooth-com", atau "bluetooth-web"
BT_CHANNEL = None     # COM port untuk bluetooth SPP


# --- Scan Printer ---
@app.route("/scan", methods=["GET"])
def scan_printers():
    printers = []

    # 🔹 1. Printer Windows (USB/WiFi dengan driver)
    win_printers = [p[2] for p in win32print.EnumPrinters(win32print.PRINTER_ENUM_LOCAL, None, 1)]
    for name in win_printers:
        printers.append({"type": "windows", "name": name})

    # 🔹 2. COM Port (USB-to-Serial atau Bluetooth SPP di Windows)
    com_ports = serial.tools.list_ports.comports()
    for port in com_ports:
        printers.append({
            "type": "com",
            "name": port.device,
            "desc": port.description
        })

    # 🔹 3. Opsi Web Bluetooth API (langsung di browser)
    printers.append({
        "type": "bluetooth-web",
        "name": "Gunakan Web Bluetooth API",
        "desc": "Cetak langsung dari browser dengan navigator.bluetooth"
    })

    return jsonify({"printers": printers})


# --- Select Printer ---
@app.route("/select", methods=["POST"])
def select_printer():
    global SELECTED_PRINTER, PRINTER_TYPE, BT_CHANNEL
    data = request.json
    name = data.get("printer_name")
    ptype = data.get("printer_type")
    channel = data.get("channel")

    if not name or not ptype:
        return jsonify({"status": "error", "message": "Harus kirim printer_name dan printer_type"}), 400

    SELECTED_PRINTER = name
    PRINTER_TYPE = ptype
    BT_CHANNEL = channel

    return jsonify({
        "status": "success",
        "message": f"Printer '{name}' dipilih",
        "type": ptype,
        "channel": channel
    })


# --- Print ---
@app.route("/print", methods=["POST"])
def print_receipt():
    global SELECTED_PRINTER, PRINTER_TYPE, BT_CHANNEL
    if not SELECTED_PRINTER:
        return jsonify({"status": "error", "message": "Belum memilih printer"}), 400

    try:
        data = request.json
        store_name = data.get("store_name", "My Store")
        items = data.get("items", [])
        total = data.get("total", 0)

        # Build receipt sederhana
        receipt = f"=== {store_name} ===\n"
        for item in items:
            receipt += f"{item['name']} {item.get('total','')}\n"
        receipt += f"\nTOTAL: {total}\n\n\n"

        # --- Windows native printer ---
        if PRINTER_TYPE == "windows":
            hprinter = win32print.OpenPrinter(SELECTED_PRINTER)
            hjob = win32print.StartDocPrinter(hprinter, 1, ("Struk", None, "RAW"))
            win32print.StartPagePrinter(hprinter)
            win32print.WritePrinter(hprinter, receipt.encode("ascii", errors="ignore"))
            win32print.EndPagePrinter(hprinter)
            win32print.EndDocPrinter(hprinter)
            win32print.ClosePrinter(hprinter)
            return jsonify({"status": "success", "message": f"Printed via Windows printer: {SELECTED_PRINTER}"})

        # --- COM port (USB-to-Serial, RS232) ---
        elif PRINTER_TYPE == "com":
            ser = serial.Serial(SELECTED_PRINTER, 9600, timeout=1)
            ser.write(receipt.encode("ascii", errors="ignore"))
            ser.close()
            return jsonify({"status": "success", "message": f"Printed via COM port: {SELECTED_PRINTER}"})

        # --- Bluetooth printer (SPP = COM di Windows) ---
        elif PRINTER_TYPE == "bluetooth-com":
            if not BT_CHANNEL:
                return jsonify({"status": "error", "message": "Bluetooth COM port belum dipilih"}), 400

            com_port = str(BT_CHANNEL)
            if not com_port.upper().startswith("COM"):
                com_port = f"COM{com_port}"

            ser = serial.Serial(com_port, 9600, timeout=1)
            ser.write(receipt.encode("ascii", errors="ignore"))
            ser.close()
            return jsonify({
                "status": "success",
                "message": f"Printed via Bluetooth (Serial over {com_port})"
            })

        # --- Web Bluetooth API (handled by browser) ---
        elif PRINTER_TYPE == "bluetooth-web":
            # Python tidak kirim data, hanya acknowledge
            # Karena printing ditangani langsung di browser via navigator.bluetooth
            return jsonify({
                "status": "success",
                "message": "Delegated to Web Bluetooth API. Browser will handle printing."
            })

        else:
            return jsonify({"status": "error", "message": "Tipe printer tidak valid"}), 400

    except Exception as e:
        return jsonify({
            "status": "error",
            "message": str(e),
            "trace": traceback.format_exc()
        }), 500


if __name__ == "__main__":
    print("🚀 Print server berjalan di http://127.0.0.1:5054")
    app.run(host="0.0.0.0", port=5054, ssl_context=("cert.pem", "key.pem"))
