<?php

namespace App\Livewire\Admin\Master\Printer;

use App\Helpers\AlertHelper;
use Livewire\Component;
use App\Models\Printer\Printer;
use Log;
use DB;
use Livewire\WithPagination;

class AdminMasterPrinterIndex extends Component
{
    use WithPagination;
    public $search, $perPage = 5;
    public $data_id, $device_id, $device_name;

    public function openModal()
    {
        $this->reset(['device_id', 'device_name']);
        $this->dispatch('open-modal', ['id' => 'modal']);
    }
    public function getDevice($device)
    {
        $this->device_id = $device['id'];
        $this->device_name = $device['name'];
    }
    public function edit($id)
    {
        $device = Printer::find($id);
        if ($device) {
            $this->data_id = $device->id;
            $this->device_id = $device->device_id;
            $this->device_name = $device->device_name;
            $this->dispatch('open-modal', ['id' => 'modal']);
        } else {
            AlertHelper::error('Gagal', 'Device tidak ditemukan.');
        }
    }

    public function closeModal()
    {
        $this->reset(['data_id', 'device_id', 'device_name']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function submit()
    {
        // Validate and save the device information
        $this->validate([
            'device_name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            Printer::updateOrCreate(
                ['id' => $this->data_id],
                [
                    'device_id' => $this->device_id,
                    'device_name' => $this->device_name
                ]
            );

            DB::commit();
            $this->dispatch('close-modal', ['id' => 'modal']);
            $this->reset(['data_id', 'device_id', 'device_name']);
            return AlertHelper::success('Berhasil', 'Device Berhasil Di tambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving device: ' . $e->getMessage());
            return AlertHelper::error('Gagal', 'Device Gagal Di tambahkan.');
        }
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus device ini?', $id);
    }

    public function delete($id)
    {
        $device = Printer::find($id[0]);
        if ($device) {
            try {
                $device->delete();
                return AlertHelper::success('Berhasil', 'Device Berhasil Di Hapus.');
            } catch (\Exception $e) {
                Log::error('Error deleting device: ' . $e->getMessage());
                return AlertHelper::error('Gagal', 'Device Gagal Di Hapus.');
            }
        }
        return AlertHelper::error('Gagal', 'Device Tidak Ditemukan.');
    }

    public function render()
    {
        $devices = Printer::search($this->search)
            ->orderBy('order', 'asc')
            ->paginate($this->perPage);
        return view('livewire.admin.master.printer.admin-master-printer-index', [
            'devices' => $devices
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
